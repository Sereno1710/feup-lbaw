@extends('layouts.admin')

@section('nav-bar')

    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm ">
                <li class="flex items-center border-r border-black pr-8 px-4">
                    <a href="/admin/transfers/withdrawals" class="text-black font-bold">Withdrawals</a>
                </li>
                <li class="flex items-center">
                    <a href="/admin/transfers/completed" class="text-black ">Transfers Completed</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')

    <div class="mx-2 flex flex-col overflow-x-auto m-8">
    <h1 class="text-4xl font-bold">Withdrawals</h1>
    <br>
    <div class="mx-6 mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            <table id="transfers_table" class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium dark:border-neutral-500">
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Username</th>
                <th class="py-2 px-4 border border-slate-300">Balance</th>
                <th class="py-2 px-4 border border-slate-300">Actions</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawals as $withdrawal)
            <tr id="transfer_row_{{$withdrawal->id}}">
                <td class="py-2 px-4 border border-slate-300">{{ $withdrawal->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $withdrawal->username }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $withdrawal->amount }}</td>
                <td class="py-2 px-4 border border-slate-300 flex flex-row">
                    <button transfer_id="{{ $withdrawal->id }}" view="withdrawals" class="mx-2 p-2 text-white bg-stone-800 rounded approve-btn" type="button">Approve</button>
                    <button transfer_id="{{ $withdrawal->id }}" view="withdrawals" class="mx-2 p-2 text-white bg-stone-800 rounded reject-btn" type="button">Reject</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div>
        {{ $withdrawals->links() }}
    </div>
</div>
</div>
</div>
@endsection
