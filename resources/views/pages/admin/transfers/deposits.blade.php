@extends('layouts.app')

@section('nav-bar')
    <br>
    <br>
    <br>
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/transfers/deposits" class="text-black font-bold">Deposits</a>
                </li>
                <li>
                    <a href="/admin/transfers/withdrawals" class="text-black ">Withdrawals</a>
                </li>
                <li> 
                    <a href="/admin/transfers/completed" class="text-black ">Transfers Completed</a>
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
    <h1 class="text-4xl font-bold">Deposits</h1>    
    <br>
    <div class="mx-6 mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium dark:border-neutral-500">
                    <tr>
                        <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Username</th>
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
                <td class="py-2 px-4 border border-slate-300 flex flex-row">
                    <form class="m-auto text-stone-800" method="POST" action="{{ route('admin.approve') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $deposit->id }}">
                        <input type="hidden" name="view" value="deposits">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Approve</button> 
                    </form>
                    <form class="m-auto text-stone-800" method="POST" action="{{ route('admin.reject') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $deposit->id }}">
                        <input type="hidden" name="view" value="deposits">
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