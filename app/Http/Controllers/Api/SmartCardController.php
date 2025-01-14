<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\SmartCard;
use Illuminate\Http\Request;

class SmartCardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $cards = SmartCard::all()->map(function ($card) {
            $card->font_image = url('storage/' . $card->font_image);
            $card->back_image = url('storage/' . $card->back_image);
            $card->status = $card->status === 0 ? 'active' : 'inactive';
            return $card;
        })->makeHidden(['created_at', 'updated_at']);

        return response()->json($cards);
    }
}
