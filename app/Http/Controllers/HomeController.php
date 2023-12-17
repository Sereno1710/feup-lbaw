<?php

namespace App\Http\Controllers;

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

        if (empty($input)) {
            $auctionsQuery = Auction::whereRaw("tsvectors @@ to_tsquery('english', '*')")
                ->orderByRaw("ts_rank(tsvectors, to_tsquery('*')) DESC")
                ->get();

            $usersQuery = User::whereRaw("tsvectors @@ to_tsquery('english', '*')")
                ->orderByRaw("ts_rank(tsvectors, to_tsquery('*')) DESC")
                ->get();
        } else {
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);

            $auctionsQuery1 = Auction::where('name', 'like', $input)
                ->orWhere('category', 'like', $input)
                ->orWhere('description', 'like', $input)
                ->where('state', 'active')
                ->get();

            $usersQuery1 = User::where('name', 'like', $input)
                ->orWhere('username', 'like', $input)
                ->orWhere('biography', 'like', $input)
                ->where('username', '!=', 'anonymous')
                ->get();

            $auctionsQuery2 = Auction::where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhereRaw("tsvectors @@ to_tsquery('english', ?)", [$value . ':*'])
                        ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$value . ':*']);
                }
            })->where('state', 'active')
                ->get();

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

        if ($request->ajax()) {
            return response()->json(['results' => $results, 'input' => $input]);
        } else {
            return view('pages.search', ['results' => $results, 'input' => $input]);
        }
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