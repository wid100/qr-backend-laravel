<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardOrder;
use Illuminate\Http\Request;

class CardOrderController extends Controller
{
    public function index()
    {
        $orders = CardOrder::with('user', 'smartCard') // assuming relationships exist
            ->orderByDesc('created_at')
            ->get();

        return view('admin.cardOrder.index', compact('orders'));
    }
}
