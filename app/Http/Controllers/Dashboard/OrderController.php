<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(4);
        return view('dashboard.orders.index', compact('orders'));

    }// end of index

    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));

    }// end of products

    public function destroy(Order $order)
    {
        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of delete

    public function restore(Order $order)
    {
        foreach ($order->products as $product) {
            $quantity = $product->pivot->quantity;
            $product->update([
                'stock' => $product->stock + $quantity,
            ]);
        }
        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of restore
}





