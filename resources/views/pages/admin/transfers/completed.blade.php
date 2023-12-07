@extends('layouts.app')

@section('nav-bar')
    <br>
    <br>
    <br>
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/transfers/deposits" class="text-black">Deposits</a>
                </li>
                <li>
                    <a href="/admin/transfers/withdrawals" class="text-black">Withdrawals</a>
                </li>
                <li> 
                    <a href="/admin/transfers/completed" class="text-black font-bold">Transfers Completed</a>
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
        <h1 class="text-4xl font-bold">Transfers Completed</h1>
        <br>
        <div class="sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border border-slate-300">ID</th> 
                                <th class="py-2 px-4 border border-slate-300">Username</th>
                                <th class="py-2 px-4 border border-slate-300">Amount</th>
                                <th class="py-2 px-4 border border-slate-300">State</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($others as $transfer)
                        <tr>
                            <td class="py-2 px-4 border border-slate-300">{{ $transfer->id }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $transfer->username }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $transfer->amount }}</td>
                            <td class="py-2 px-4 border border-slate-300">{{ $transfer->state }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection