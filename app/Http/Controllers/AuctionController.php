<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Bid;
use App\Models\Auction;
use App\Models\MetaInfo;
use App\Models\AuctionMetaInfoValue;

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
        Auth::check();
        $metaInfos = MetaInfo::all();
        return view('pages/createauction', ['metaInfos' => $metaInfos]);
    }

    public function startAuction(Request $request, $auctionId)
    {
        $request->validate([
            'days' => 'required|numeric|min:1',
        ]);

        $auction = Auction::find($auctionId);

        if (!$auction) {
            return redirect()->back();
        }

        if ($auction->state === 'approved') {
            $days = $request->input('days');
            $endTime = now()->addDays($days);

            $auction->update([
                'state' => 'active',
                'initial_time' => now(),
                'end_time' => $endTime,
            ]);

            
        }
        
        return redirect()->back();
    }

    public function createAuction(Request $request)
    {
        Auth::check();
        $validatedData = $request->validate([
            'auction_name' => 'required|string',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:1',
            'category' => 'required|in:strings,woodwinds,brass,percussion',
        ]);

        $auctionData['name'] = $validatedData['auction_name'];
        $auctionData['description'] = $validatedData['description'];
        $auctionData['initial_price'] = $validatedData['starting_price'];
        $auctionData['price'] = $validatedData['starting_price'];
        $auctionData['category'] = $validatedData['category'];
        $auctionData['owner_id'] = Auth::user()->id;
        
        try {
            DB::beginTransaction();

            $auction = new Auction($auctionData);
            $auction->save();

            if ($request->hasFile('image')) {
                $request->file('image')->move('images/auction', "{$auction->id}.jpg");
            }

            $metaInfos = $request->input('categories', []);

            foreach ($metaInfos as $metaInfoName => $selectedValueId) {
                if (!empty($selectedValueId)) {
                    $auctionMetaInfoValue = new AuctionMetaInfoValue([
                        'auction_id' => $auction->id,
                        'meta_info_value_id' => $selectedValueId,
                    ]);
                    $auctionMetaInfoValue->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Bid submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error ocurred. Try again later.');
        }
    }

    public function auctionBid(Request $request, $auctionId)
    {
        Auth::check();
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
    
        try {
            DB::beginTransaction();
            
            DB::table('users')
                ->where('id', function ($query) use ($auctionId) {
                    $query->select('user_id')
                        ->from(DB::raw("(SELECT user_id, amount FROM bid WHERE auction_id = :auction_id ORDER BY amount DESC LIMIT 1) AS LastBid"))
                        ->addBinding(['auction_id' => $auctionId], 'select');
                })
                ->update(['balance' => DB::raw('balance + (SELECT amount FROM (SELECT user_id, amount FROM bid WHERE auction_id = :auction_id ORDER BY amount DESC LIMIT 1) AS LastBid)')]);


            $bid = new Bid([
                'user_id' => Auth::user()->id,
                'auction_id' => $auctionId,
                'amount' => $validatedData['amount'],
                'time' => now(),
            ]);
            $bid->save();

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['balance' => DB::raw('balance - ' . $validatedData['amount'] . '::MONEY')]);
    
            Auction::where('id', $auctionId)
                ->update(['price' => DB::raw($validatedData['amount'] . '::MONEY')]);

            DB::commit();

            return redirect()->back()->with('success', 'Bid submitted successfully.');
        } catch (\Exception $e) {
            $errorMessages = [
                "Your bid must be higher than the current highest bid.",
                "You cannot bid if you currently own the highest bid.",
                "You do not have enough balance in your account.",
                "You may only bid in active auctions.",
                "You cannot bid on your own auction as the owner.",
            ];

            $errorMessage = $e->getMessage();

            foreach ($errorMessages as $expectedErrorMessage) {
                if (strpos($errorMessage, $expectedErrorMessage) !== false) {
                    return redirect()->back()->with('error', $expectedErrorMessage);
                }
            }

            return redirect()->back()->with('error', 'Error submitting bid.');
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $auctionsQuery = Auction::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword . ':*'])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery(?)) DESC", [$keyword]);

        $auctions = $auctionsQuery->simplePaginate(12, ['*'], 'page', $request->input('page'));

        return view('pages.auction.search', ['auctions' => $auctions, 'keyword' => $keyword]);
    }

}
