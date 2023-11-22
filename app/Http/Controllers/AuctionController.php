<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;
use App\Models\MetaInfoValue;

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
        $metaInfoValues = MetaInfoValue::all();
        return view('pages/createauction', ['metaInfoValues' => $metaInfoValues]);
    }

    public function createAuction(Request $request)
    {
        $validatedData = $request->validate([
            'auction_name' => 'required|string',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:1',
        ]);

        $auctionData['name'] = $validatedData['auction_name'];
        $auctionData['description'] = $validatedData['description'];
        $auctionData['initial_price'] = $validatedData['starting_price'];
        $auctionData['price'] = $validatedData['starting_price'];
        $auctionData['category'] = 'strings';
        $auctionData['owner_id'] = Auth::user()->id;
        $auctionData['state'] = 'active';

        $auction = new Auction($auctionData);
        $auction->save();

        return view('pages/createauction');
    }
    
}