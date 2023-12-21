<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Events\AuctionBid;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\MetaInfo;
use App\Models\AuctionMetaInfoValue;
use App\Models\follows;
use App\Models\Report;
use App\Models\Comment;
use App\Models\AuctionWinner;

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
            $endTime = now()->addMinutes($days);

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

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $key = 1;
                foreach ($images as $image) {
                    $image->move('images/auction', "{$auction->id}_{$key}.jpg");
                    $key++;
                }
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

            return redirect('/auction/' . $auction->id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error ocurred. Try again later.');
        }
    }

    public function bidOnAuction(Request $request, $auctionId)
    {
        Auth::check();
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            DB::statement('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');

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

            return redirect()->back()->with('message', 'Bid submitted successfully.');
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

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function followAuction(Request $request)
    {
        $userId = $request->user_id;
        if ($request->user_id != Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        follows::create([
            'user_id' => $request->user_id,
            'auction_id' => $request->auction_id,
        ]);

        return response()->json(['message' => 'Auction followed successfully']);
    }

    public function unfollowAuction(Request $request)
    {
        if ($request->user_id != Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        follows::where('user_id', $request->user_id)
            ->where('auction_id', $request->auction_id)
            ->delete();

        return response()->json(['message' => 'Auction unfollowed successfully']);
    }

    public function commentOnAuction(Request $request, $auctionId)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
        ]);
        Comment::create([
            'user_id' => Auth::user()->id,
            'auction_id' => $auctionId,
            'message' => $validatedData['message'],
            'time' => now(),
        ]);

        return redirect()->back()->with('message', "Comment successfully added.");
    }

    public function deleteCommentOnAuction($auctionId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Auth::user()->id !== $comment->user->id) {
            return redirect()->back()->with('message', 'Unauthorized to delete this comment.');
        }

        $comment->delete();
        return redirect()->back()->with('message', 'Comment deleted successfully.');
    }

    public function reportAuction(Request $request)
    {
        $validatedData = $request->validate([
            'auction_id' => 'required|integer',
            'user_id' => 'required|integer',
            'description' => 'required|string',
        ]);

        if ($request->user_id != Auth::user()->id) {
            return redirect()->back()->with('message', "Please do not report as someone else. Try again.");
        }

        $existingReport = Report::where('user_id', $validatedData['user_id'])
            ->where('auction_id', $request->auction_id)
            ->first();

        if ($existingReport) {
            return redirect()->back()->with('message', "You have already reported this auction.");
        }

        Report::create([
            'user_id' => $validatedData['user_id'],
            'auction_id' => $request->auction_id,
            'description' => $validatedData['description'],
        ]);

        return redirect()->back()->with('message', "Thank you for your contribution.");
    }

    public function rateAuction(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        $auction = Auction::find($id);

        if (Auth::user()->id !== $auction->auctionWinner->user_id) {
            return redirect()->back()->with('message', "You cannot rate this auction.");
        }

        $auctionWinner = AuctionWinner::where('auction_id', $id)->first();
        $auctionWinner::where('user_id', Auth::user()->id)
            ->where('auction_id', $id)
            ->update([
                'rating' => $validatedData['rating']
            ]);

        return redirect()->back()->with('message', "Thanks for submitting a rating.");
    }

    public function disableAuction($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        if (Auth::user()->id !== $auction->owner_id) {
            return redirect()->back()->with('message', 'You are not the owner of this auction.');
        }

        $bidCount = $auction->bids()->count();
        if ($bidCount > 0) {
            return redirect()->back()->with('message', 'Cannot disable an auction with bids.');
        }

        $auction->update(['state' => 'disabled']);

        return redirect()->back()->with('message', 'Auction disabled successfully.');
    }

    public static function bidFromAuction($auctionId)
    {

        try {
            $auction = Auction::findOrFail($auctionId);
            $bids = $auction->bids()->orderBy('time', 'desc')->get();
    
            if (!$bids) {
                return response()->json(['error' => 'bids not found'], 404);
            }
            if(!$auction) {
                return response()->json(['error' => 'auction not found'], 404);
            }
            return response()->json($bids);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve info'], 500);
        }
    }
}

