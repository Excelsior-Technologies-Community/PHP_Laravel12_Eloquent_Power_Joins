<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $orders = User::query()
            ->joinRelationship('orders.items.product')

            // SEARCH FILTER
            ->when($search, function ($query) use ($search) {
                $query->where('users.name', 'like', "%{$search}%")
                    ->orWhere('orders.order_number', 'like', "%{$search}%")
                    ->orWhere('products.name', 'like', "%{$search}%");
            })

            // STATUS FILTER
            ->when($status, function ($query) use ($status) {
                $query->where('orders.status', $status);
            })

            ->select(
                'orders.id as order_id',
                'users.name as user_name',
                'orders.order_number as order_no',
                'products.name as product_name',
                'order_items.quantity as qty',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_amount')
            )

            ->groupBy(
                'orders.id',
                'users.name',
                'orders.order_number',
                'products.name',
                'order_items.quantity'
            )

            ->paginate(5)
            ->withQueryString();

        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        return view('orders.index', compact(
            'orders',
            'totalUsers',
            'totalOrders',
            'totalProducts'
        ));
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Order deleted successfully');
    }
}