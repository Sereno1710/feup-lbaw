<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages/home');
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