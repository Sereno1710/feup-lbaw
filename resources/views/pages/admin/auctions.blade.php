@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">Auctions</h1>
    <br>
    <table class="min-w-full border-separate">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Owner</th>
                <th class="py-2 px-4 border border-slate-300">Initial Price</th>
                <th class="py-2 px-4 border border-slate-300">Price</th>
                <th class="py-2 px-4 border border-slate-300">State</th>
                <th class="py-2 px-4 border border-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auctions2 as $auction)
            <tr>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{$auction->username }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->state }}</td>
                
                <td class="py-2 px-4 border border-slate-300 flex flex-row">
                    @if ($auction->state == 'pending')
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.approveAuction') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $auction->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Approve</button> 
                    </form>
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.rejectAuction') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $auction->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Reject</button> 
                    </form>
                    @elseif ($auction->state == 'paused')
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.resumeAuction') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $auction->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Resume</button>
                    </form>
                    @elseif ($auction->state == 'active')
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.pauseAuction') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $auction->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Pause</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <h1 class="text-4xl font-bold">Auctions</h1>
    <br>
    <table class="min-w-full border-separate">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Owner</th>
                <th class="py-2 px-4 border border-slate-300">Initial Price</th>
                <th class="py-2 px-4 border border-slate-300">Price</th>
                <th class="py-2 px-4 border border-slate-300">State</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($auctions1 as $auction)
            <tr>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{$auction->username }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $auction->state }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
