@extends('layouts.admin')

@section('nav-bar')
    <div class="max-w-screen px-2 py-3 mx-auto">


        <div class="flex items-center py-4">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/auctions/active" class="text-black font-bold">Active</a>
                </li>
                <li>
                    <a href="/admin/auctions/pending" class="text-black">Pending</a>
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
        <h1 class="text-4xl font-bold">Active</h1>
        <br>
        <div class="mx-6 mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                <table class="min-w-full border-separate" id="auctions_table">
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
                @foreach ($active as $auction)
                <tr id="auction_row_{{$auction->id}}">
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                    <td class="py-2 px-4 border border-slate-300"><a href="{{ url('/user/' . $auction->owner_id) }}">{{$auction->username }}</a></td>
                    <td class="py-2 px-4 border border-slate-300"><a href="{{ url('/auction/' . $auction->id) }}">{{ $auction->name }}</a></td>
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                    <td class="py-2 px-4 border border-slate-300" id="state">{{ $auction->state }}</td>
                    <td class="py-2 px-4 border border-slate-300 flex flex-row">
                    @if ($auction->state == 'paused')
                        <button auction_id="{{ $auction->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded resume-btn" type="button">Resume</button>
                    @elseif ($auction->state == 'active')
                        <button auction_id="{{ $auction->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded pause-btn" type="button">Pause</button>
                    @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <div>
                {{ $active->links() }}
            </div>
        </div>
    </div>
</div>
@endsection        