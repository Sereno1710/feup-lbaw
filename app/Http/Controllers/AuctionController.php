<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Auction;

class AuctionController extends Controller
{
    public function showAuction($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        $bids = $auction->bids()->orderBy('time', 'desc')->take(3)->get();

        return view('pages.auction', ['auction' => $auction, 'bids' => $bids]);
    }
    public function showActiveAuctions()
    {
        $activeAuctions = $activeAuctions = Auction::activeAuctions()->get();

        return view('pages/activeauctions', ['activeAuctions' => $activeAuctions]);
    }

    public function showAuctionForm()
    {
        return view('pages/createauction');
    }

    
}