@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<div class="mx-8 my-4 flex flex-row items-center p-4 rounded-lg bg-stone-300">
    <div class="w-screen justify-between grid grid-cols-1 sm:grid-cols-4 md:grid-cols-2 gap-8">
        <div class="bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-row justify-between items-center">
            <h4 class="font-bold text-xl">Users</h4>
            <a class= "mx-4" href="{{ url('/admin/users') }}">View All</a>
        </div>
        <div class="bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-row justify-between items-center">
            <h4 class="font-bold text-xl">Transfers</h4>
            <a class= "mx-4" href="{{ url('/admin/transfers/deposits') }}">View All</a>
        </div>
        <div class="bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-row justify-between items-center">
            <h4 class="font-bold text-xl">Auctions</h4>
            <a class= "mx-4" href="{{ url('/admin/auctions') }}">View All</a>
        </div>
    </div>
</div>