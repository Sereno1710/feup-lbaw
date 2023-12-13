@extends('layouts.admin')

@section('nav-bar')
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex justify-between items-center">
                    <form class="p-1 bg-stone-200 rounded-lg" action="/auction/search" method="GET">
                        <input class="bg-stone-200 outline-none" type="text" name="keyword" placeholder="Search auctions">
                        <button type="submit">🔎</button>
                    </form>
        </div>
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/auctions/active" class="text-black">Active</a>
                </li>
                <li>
                    <a href="/admin/auctions/pending" class="text-black font-bold">Pending</a>
                </li>
                <li> 
                    <a href="/admin/auctions/others" class="text-black ">Others</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-2 flex flex-col overflow-x-auto m-8">
        <h1 class="text-4xl font-bold">Pending Auctions</h1>
        <br>
        <div class="mx-6 mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-seperate" id="auctions_table">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border border-slate-300">ID</th> 
                                <th class="py-2 px-4 border border-slate-300">Owner</th>
                                <th class="py-2 px-4 border border-slate-300">Name</th>
                                <th class="py-2 px-4 border border-slate-300">Initial Price</th>
                                <th class="py-2 px-4 border border-slate-300">Price</th>
                                <th class="py-2 px-4 border border-slate-300">State</th>
                                <th class="py-2 px-4 border border-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($pending as $auction)
                        <tr id="auction_row_{{$auction->id}}">
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{$auction->username }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->name }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->state }}</td>
                            <td class="py-2 px-4 border border-slate-300 flex flex-row">
                            <button auction_id="{{ $auction->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded approve-btn" type="button">Approve</button>
                            <button auction_id="{{ $auction->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded reject-btn" type="button">Reject</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>  
                <div>
                    {{ $pending->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection