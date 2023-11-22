<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $auctions = Auction::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword . ':*'])
            ->get();

        return view('pages.auction.search', ['auctions' => $auctions]);
    }
}
