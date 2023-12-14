@extends('layouts.admin')

@section('nav-bar')
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li class="flex items-center border-r border-black pr-8 px-4">
                    <a href="/admin/auctions/active" class="text-black">Active</a>
                </li>
                <li class="flex items-center border-r border-black pr-8">
                    <a href="/admin/auctions/pending" class="text-black">Pending</a>
                </li>
                <li class="flex items-center"> 
                    <a href="/admin/auctions/others" class="text-black font-bold">Others</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-2 flex flex-col overflow-x-auto m-8">
        <h1 class="text-4xl font-bold">Others</h1>
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
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($others as $auction)
                        <tr>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->id }}</td>
                            <td class="py-2 px-4 border border-slate-300"><a href="{{ url('/user/' . $auction->owner_id) }}">{{$auction->username }}</a></td>
                            <td class="py-2 px-4 border border-slate-300"><a href="{{ url('/auction/' . $auction->id) }}">{{ $auction->name }}</a></td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->initial_price }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->price }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $auction->state }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>  
                <div>
                    {{ $others->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection