<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('client', 'categories'));

    }//end of create

    public function store(Request $request, Client $client)
    {
        $data = $request->validate([
            'products' => 'required|array',
        ]);

        $this->attachOrder($request, $client);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    } // end of store

    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories'));

    }// end of edit

    public function update(Request $request, Client $client, Order $order)
    {
        $data = $request->validate([
            'products' => 'required|array',
        ]);

        $this->detachOrder($order);
        $this->attachOrder($request, $client);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of update

    private function attachOrder(Request $request, Client $client) {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::findOrFail($id);
            $total_price = $total_price + ($product->sale_price * $quantity['quantity']);
            $product->update([
                'stock' => $product->stock - $quantity['quantity'],
            ]);
        }

        $order->update([
            'total_price' => $total_price,
        ]);

    }// end of attachOrder


    private function detachOrder(Order $order)
    {
        foreach ($order->products as $product) {
            $quantity = $product->pivot->quantity;
            $product->update([
                'stock' => $product->stock + $quantity,
            ]);
        }
        $order->delete();

    }// end of detachOrder

}// end of class



