@extends('layouts.app')

@section('nav-bar')
    <br>
    <br>
    <br>
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
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
    <br>
    <br>
    <br>
    <br>
    <div class="mx-2 flex flex-col overflow-x-auto">
        <h1 class="text-4xl font-bold">Active</h1>
        <br>
        <div class="sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
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
                @foreach ($active as $auction)
                <tr>
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                    <td class="py-2 px-4 border border-slate-300">{{$auction->username }}</td>
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                    <td class="py-2 px-4 border border-slate-300">{{ $auction->state }}</td>
                    <td class="py-2 px-4 border border-slate-300 flex flex-row">
                    @if ($auction->state == 'paused')
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
            </div>
        </div>
    </div>
</div>
@endsection        