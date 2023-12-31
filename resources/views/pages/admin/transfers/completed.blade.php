@extends('layouts.admin')

@section('nav-bar')
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li class="flex items-center border-r border-black pr-8 px-4">
                    <a href="/admin/transfers/withdrawals" class="text-black">Withdrawals</a>
                </li>
                <li class="flex items-center">
                    <a href="/admin/transfers/completed" class="text-black font-bold">Transfers Completed</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-2 flex flex-col overflow-x-auto m-8">
        <h1 class="text-4xl font-bold">Transfers Completed</h1>
        <br>
        <div class="mx-6 mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate">
                        <thead>
                            <tr>
                                <th class="p-2 border-b-2 border-slate-300">ID</th> 
                                <th class="p-2 border-b-2 border-slate-300">Username</th>
                                <th class="p-2 border-b-2 border-slate-300">Amount</th>
                                <th class="p-2 border-b-2 border-slate-300">State</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($others as $transfer)
                        <tr>
                            <td class="p-2 border-b-2 border-slate-300">{{ $transfer->id }}</td>
                            <td class="p-2 border-b-2 border-slate-300">{{ $transfer->username }}</td>
                            <td class="p-2 border-b-2 border-slate-300">{{ $transfer->amount }}</td>
                            <td class="p-2 border-b-2 border-slate-300">{{ $transfer->state }}</td>
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