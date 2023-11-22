<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Auction;

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

    public function search()
    {
        return view('pages/search');
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