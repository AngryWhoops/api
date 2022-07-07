<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function GetAllCards() {
        $cards = Card::all();
        return response()->json($cards);
    }

    public function GetCardById($id) {
        $card = Card::find($id);
        return response()->json($card);
    }

    public function CreateCard(Request $request) {
        $newCard = new Card(
            array(
                'title' => $request->get('title'),
                'body' => $request->get('body')
            )
        );
        $newCard->save();
    }
}
