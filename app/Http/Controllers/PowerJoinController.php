<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PowerJoinController extends Controller
{
    public function nestedJoins()
    {
        $orders = Order::query()
            ->joinRelationship('user')
            ->joinRelationship('items.product.category')
            ->select(
                'orders.id',
                'orders.order_number',
                'users.name as user_name',
                'products.name as product_name',
                'categories.name as category_name',
                'order_items.quantity',
                'order_items.price'
            )
            ->get();

        return view('powerjoins.nested', compact('orders'));
    }

    public function leftJoins()
    {
        $products = Product::query()
            ->leftJoinRelationship('orderItems')
            ->leftJoinRelationship('category')
            ->select(
                'products.name as product_name',
                'products.price',
                'categories.name as category_name',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_ordered')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'categories.name')
            ->get();

        return view('powerjoins.leftjoin', compact('products'));
    }

    public function aggregateQueries()
    {
        $userSpending = User::query()
            ->joinRelationship('orders')
            ->select(
                'users.name',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total_amount) as total_spent'),
                DB::raw('AVG(orders.total_amount) as avg_order_value')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->get();

        $productStats = Product::query()
            ->joinRelationship('orderItems')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'),
                DB::raw('AVG(order_items.price) as avg_selling_price'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as times_ordered')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_revenue')
            ->get();

        return view('powerjoins.aggregate', compact('userSpending', 'productStats'));
    }

    public function groupByExamples()
    {
        $ordersByMonth = Order::query()
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $ordersByUserAndStatus = User::query()
            ->joinRelationship('orders')
            ->select(
                'users.name',
                'orders.status',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total_amount) as total_amount')
            )
            ->groupBy('users.id', 'users.name', 'orders.status')
            ->orderBy('users.name')
            ->get();

        return view('powerjoins.groupby', compact('ordersByMonth', 'ordersByUserAndStatus'));
    }
}
