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
        $keyword = $request->input('keyword');

        $auctionsQuery = Auction::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword . ':*'])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$keyword])
            ->get();

        $usersQuery = User::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword . ':*'])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$keyword])
            ->get();

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

        return view('pages.search', ['results' => $results, 'keyword' => $keyword]);
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