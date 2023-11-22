@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">Deposits</h1>
    <br>
    <table class="min-w-full border-separate">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">User_ID</th>
                <th class="py-2 px-4 border border-slate-300">Amount</th>
                <th class="py-2 px-4 border border-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deposits as $deposit)
            <tr>
                <td class="py-2 px-4 border border-slate-300">{{ $deposit->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $deposit->username}}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $deposit->amount }}</td>
                <td class="py-2 px-4 border border-slate-300">
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.approve') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $deposit->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Approve</button> 
                    </form>
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.reject') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $deposit->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Reject</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h1 class="text-4xl font-bold">Withdrawals</h1>
    <br>
    <table class="min-w-full border-separate">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Username</th>
                <th class="py-2 px-4 border border-slate-300">Balance</th>
                <th class="py-2 px-4 border border-slate-300">Actions</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawals as $withdrawal)
            <tr>
                <td class="py-2 px-4 border border-slate-300">{{ $withdrawal->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $withdrawal->username }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $withdrawal->amount }}</td>
                <td class="py-2 px-4 border border-slate-300">
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.approve') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Approve</button> 
                    </form>
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.reject') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Reject</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h1 class="text-4xl font-bold">Transfers Completed</h1>
    <br>
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