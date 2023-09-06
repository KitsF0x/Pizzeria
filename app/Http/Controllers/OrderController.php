<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Order::create($request->all());
    }

    public function destroy(Request $request, Order $order)
    {
        if (Auth::id() == $order->user_id) {
            $order->delete();
        } else {
            return response()->json(['message' => 'It is not your order!'], 401);
        }
    }
}