<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardOrder;
use Illuminate\Http\Request;

class CardOrderController extends Controller
{
    public function index()
    {
        $orders = CardOrder::with('user', 'smartCard')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.cardOrder.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = CardOrder::with('user', 'smartCard')->findOrFail($id);

        return view('admin.cardOrder.edit', compact('order'));
    }


    public function update(Request $request, $id)
    {
        $order = CardOrder::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('admin.card-order.index')->with('success', 'Order status updated successfully.');
    }

    public function destroy($id)
    {
        $order = CardOrder::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.card-order.index')->with('success', 'Order deleted successfully.');
    }
}
