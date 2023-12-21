<?php

namespace App\Http\Controllers;

use App\Models\AuctionMetaInfoValue;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Auction;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $featuredAuctions = Auction::where('state', 'active')
            ->orderByDesc('price')
            ->take(4)
            ->get();

        return view('pages.home', ['featuredAuctions' => $featuredAuctions]);
    }

    public function search(Request $request)
    {
        $input = $request->input('input');
        $selectedCategories = (array) $request->input('categories', []);
        $metaInfoNames = (array) $request->input('metaInfos', []);
        $metaInfo = [];

        foreach ($metaInfoNames as $metaInfoName) {
            $metaInfo[$metaInfoName] = $request->input('metaInfo' . $metaInfoName, []);
        }

        if (empty($input)) {
            $auctionsQuery = Auction::select('auction.*')->where('state', 'active');

            if (!empty($metaInfo)) {
                $auctionsQuery = $auctionsQuery->join('auctionmetainfovalue', 'auction.id', '=', 'auctionmetainfovalue.auction_id')
                    ->join('metainfovalue', 'auctionmetainfovalue.meta_info_value_id', '=', 'metainfovalue.id')
                    ->join('metainfo', 'metainfovalue.meta_info_name', '=', 'metainfo.name');
            }
            if (!empty($selectedCategories)) {
                $auctionsQuery = $auctionsQuery->whereIn('category', $selectedCategories);
            }

            $auctionsQuery = $auctionsQuery
                ->where(function ($query) use ($metaInfo, &$otherSelected) {
                    foreach ($metaInfo as $metaInfoName => $selectedValues) {
                        if (!empty($selectedValues)) {
                            $query->orWhere(function ($innerQuery) use ($metaInfoName, $selectedValues) {
                                $innerQuery->where('metainfo.name', $metaInfoName)
                                    ->whereIn('metainfovalue.value', $selectedValues);
                            });
                        }
                    }
                });

            $auctionsQuery = $auctionsQuery->get();

            $usersQuery = User::whereRaw("tsvectors @@ to_tsquery('english', '*')")
                ->orderByRaw("ts_rank(tsvectors, to_tsquery('*')) DESC")
                ->get();
        } else {
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $auctionsQuery1 = Auction::select('auction.*')->where('name', 'like', $input)
                ->orWhere('category', 'like', $input)
                ->orWhere('description', 'like', $input)
                ->where('state', 'active')
                ->get();

            $usersQuery1 = User::where('name', 'like', $input)
                ->orWhere('username', 'like', $input)
                ->orWhere('biography', 'like', $input)
                ->where('username', '!=', 'anonymous')
                ->get();

            $auctionsQuery2 = Auction::select('auction.*')->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhereRaw("tsvectors @@ to_tsquery('english', ?)", [$value . ':*'])
                        ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$value . ':*']);
                }
            })->where('state', 'active');

            if (!empty($metaInfo)) {
                $auctionsQuery2 = $auctionsQuery2->join('auctionmetainfovalue', 'auction.id', '=', 'auctionmetainfovalue.auction_id')
                    ->join('metainfovalue', 'auctionmetainfovalue.meta_info_value_id', '=', 'metainfovalue.id')
                    ->join('metainfo', 'metainfovalue.meta_info_name', '=', 'metainfo.name');
            }
            if (!empty($selectedCategories)) {
                $auctionsQuery2 = $auctionsQuery2->whereIn('category', $selectedCategories);
            }

            $auctionsQuery2 = $auctionsQuery2
                ->where(function ($query) use ($metaInfo, &$otherSelected) {
                    foreach ($metaInfo as $metaInfoName => $selectedValues) {
                        if (!empty($selectedValues)) {
                            $query->orWhere(function ($innerQuery) use ($metaInfoName, $selectedValues) {
                                $innerQuery->where('metainfo.name', $metaInfoName)
                                    ->whereIn('metainfovalue.value', $selectedValues);
                            });
                        }
                    }
                });

            $auctionsQuery2 = $auctionsQuery2->get();

            $usersQuery2 = User::where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhereRaw("tsvectors @@ to_tsquery('english', ?)", [$value . ':*'])
                        ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$value . ':*']);
                }
            })->where('username', '!=', 'anonymous')
                ->get();

            $auctionsQuery = $auctionsQuery1->merge($auctionsQuery2);
            $usersQuery = $usersQuery1->merge($usersQuery2);
        }

        // Add a type property to distinguish between users and auctions
        $auctions = $auctionsQuery->map(function ($auction) {
            $auction->type = 'auction';
            return $auction;
        });

        $users = $usersQuery->map(function ($user) {
            $user->type = 'user';
            return $user;
        });

        // Merge the collections
        $merged = $auctions->merge($users);

        $perPage = 12; // Set the number of items per page
        $currentPage = $request->input('page') ?? 1;

        $results = new LengthAwarePaginator(
            $merged->forPage($currentPage, $perPage),
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pages.search', ['results' => $results, 'input' => $input]);
    }

    public function aboutUs()
    {
        return view('pages/aboutus');
    }

    public function faq()
    {
        return view('pages/faq');
    }

    public function termsOfUse()
    {
        return view('pages/termsofuse');
    }

    public function contacts()
    {
        return view('pages/contacts');
    }

    public function privacyPolicy()
    {
        return view('pages/privacypolicy');
    }
}