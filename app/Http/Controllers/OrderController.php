<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Order::create($request->all());
    }

    public function destroy(Request $request, Order $order)
    {
        $order->delete();
    }
}