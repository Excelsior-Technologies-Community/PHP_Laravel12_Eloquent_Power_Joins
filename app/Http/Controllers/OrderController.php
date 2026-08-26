<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $userFilter = $request->user_id;
        $productFilter = $request->product_id;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $priceMin = $request->price_min;
        $priceMax = $request->price_max;

        $orders = Order::query()
            ->joinRelationship('user')
            ->joinRelationship('items.product')
            ->select(
                'orders.id as order_id',
                'orders.status as order_status',
                'orders.created_at as order_date',
                'users.name as user_name',
                'users.id as user_id_val',
                'orders.order_number as order_no',
                'products.name as product_name',
                'products.id as product_id_val',
                'order_items.quantity as qty',
                'order_items.price as item_price',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_amount')
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('users.name', 'like', "%{$search}%")
                      ->orWhere('orders.order_number', 'like', "%{$search}%")
                      ->orWhere('products.name', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('orders.status', $status);
            })
            ->when($userFilter, function ($query) use ($userFilter) {
                $query->where('orders.user_id', $userFilter);
            })
            ->when($productFilter, function ($query) use ($productFilter) {
                $query->where('order_items.product_id', $productFilter);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('orders.created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('orders.created_at', '<=', $dateTo);
            })
            ->groupBy(
                'orders.id',
                'orders.status',
                'orders.created_at',
                'users.name',
                'users.id',
                'orders.order_number',
                'products.name',
                'products.id',
                'order_items.quantity',
                'order_items.price'
            )
            ->when($priceMin, function ($query) use ($priceMin) {
                $query->havingRaw('SUM(order_items.quantity * order_items.price) >= ?', [$priceMin]);
            })
            ->when($priceMax, function ($query) use ($priceMax) {
                $query->havingRaw('SUM(order_items.quantity * order_items.price) <= ?', [$priceMax]);
            })
            ->paginate(10)
            ->withQueryString();

        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $todayRevenue = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $monthlyRevenue = Order::where('status', 'completed')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount');

        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        $topProducts = Product::query()
            ->joinRelationship('orderItems')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $users = User::all();
        $products = Product::all();

        return view('orders.index', compact(
            'orders',
            'totalUsers',
            'totalOrders',
            'totalProducts',
            'totalRevenue',
            'todayRevenue',
            'monthlyRevenue',
            'ordersByStatus',
            'recentOrders',
            'topProducts',
            'users',
            'products'
        ));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,completed,cancelled',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'order_number' => 'ORD-' . Str::upper(Str::random(8)),
            'status' => $request->status,
            'total_amount' => 0,
        ]);

        $totalAmount = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            $qty = $item['quantity'];
            $price = $product->price;
            $totalAmount += $qty * $price;

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $price,
            ]);
        }

        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function edit($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,completed,cancelled',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);

        $order->items()->delete();

        $totalAmount = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            $qty = $item['quantity'];
            $price = $product->price;
            $totalAmount += $qty * $price;

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $price,
            ]);
        }

        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Order deleted successfully');
    }
}
