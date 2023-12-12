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
                    <table class="min-w-full border-seperate">
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
                        <tr>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{$auction->username }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->name }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->state }}</td>
                            <td class="py-2 px-4 border border-slate-300 flex flex-row">
                                <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.auctions.approveAuction') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="id" value="{{ $auction->id }}">
                                    <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Approve</button> 
                                </form>
                                <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.auctions.rejectAuction') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="id" value="{{ $auction->id }}">
                                    <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Reject</button> 
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
    </div>
@endsection