@extends('layouts.admin')

@section('nav-bar')
<div class="max-w-screen px-2 py-3 mx-auto">
    <div class="flex items-center">
        <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm py-8">
                <li class="flex items-center border-r border-black pr-8 px-4">
                    <a href="/admin/auctions/active" class="text-black font-bold">Active</a>
                </li>
                <li class="flex items-center border-r border-black pr-8">
                    <a href="/admin/auctions/pending" class="text-black">Pending</a>
                </li>
                <li class="flex items-center"> 
                    <a href="/admin/auctions/others" class="text-black">Others</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
        <h1 class="mx-8 text-4xl font-bold">Active</h1>
        <br>
        <div class="mx-8 overflow-y-auto">
        <div class="lg:flex-col">
            <div class="flex flex-col sm:flex-row md:flex-row lg:flex-col">
                <table class="table-auto text-center" id="auctions_table">
                <thead class="font-bold">
            <tr>
                <th class="p-2 border-b-2 border-slate-300">ID</th> 
                <th class="p-2 border-b-2 border-slate-300">Owner</th>
                <th class="p-2 border-b-2 border-slate-300">Name</th>
                <th class="p-2 border-b-2 border-slate-300">Initial Price</th>
                <th class="p-2 border-b-2 border-slate-300">Price</th>
                <th class="p-2 border-b-2 border-slate-300">State</th>
                <th class="p-2 border-b-2 border-slate-300">Actions</th>
            </tr>
            </thead>
                <tbody>
                @foreach ($active as $auction)
                <tr id="auction_row_{{$auction->id}}">
                    <td class="p-2 border-b-2 border-slate-300">{{ $auction->id }}</td>
                    <td class="p-2 border-b-2 border-slate-300"><a href="{{ url('/user/' . $auction->owner_id) }}">{{$auction->username }}</a></td>
                    <td class="p-2 border-b-2 border-slate-300"><a href="{{ url('/auction/' . $auction->id) }}">{{ $auction->name }}</a></td>
                    <td class="p-2 border-b-2 border-slate-300">{{ $auction->initial_price }}</td>
                    <td class="p-2 border-b-2 border-slate-300">{{ $auction->price }}</td>
                    <td class="p-2 border-b-2 border-slate-300" id="state">{{ $auction->state }}</td>
                    <td class="p-2 border-b-2 border-slate-300 btn">
                    @if ($auction->state == 'paused')
                        <button auction_id="{{ $auction->id }}" class="m-2 py-1 px-2 text-white bg-stone-800 rounded resume-btn" type="button">Resume</button>
                    @elseif ($auction->state == 'active')
                        <button auction_id="{{ $auction->id }}" class="m-2 py-1 px-2 text-white bg-stone-800 rounded pause-btn" type="button">Pause</button>
                    @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
            <div>
                {{ $active->links() }}
            </div>
        </div>
    </div>

@endsection        