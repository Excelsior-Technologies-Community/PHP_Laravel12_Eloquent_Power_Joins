<?php

namespace App\Http\Controllers;

use App\Models\User;

class OrderController extends Controller
{
    public function index()
{
    $users = User::query()
        ->joinRelationship('orders.items.product')
        ->select(
            'users.name as user_name',
            'products.name as product_name',
            'order_items.quantity as quantity'
        )
        ->get();

    return view('orders.index', compact('users'));
}


}
