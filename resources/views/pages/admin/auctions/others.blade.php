@extends('layouts.app')

@section('nav-bar')
    <br>
    <br>
    <br>
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/auctions/active" class="text-black">Active</a>
                </li>
                <li>
                    <a href="/admin/auctions/pending" class="text-black">Pending</a>
                </li>
                <li> 
                    <a href="/admin/auctions/others" class="text-black font-bold">Others</a>
                </li>
            </ul>
        </div>
    </div>
@endsection