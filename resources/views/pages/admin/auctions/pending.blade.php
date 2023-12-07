@extends('layouts.app')

@section('nav-bar')
    <br>
    <br>
    <br>
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/auctions/active" class="text-black">Active</a>
                </li>
                <li>
                    <a href="/admin/auctions/pending" class="text-black font-bold">Pending</a>
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
        <h1 class="text-4xl font-bold">Transfers Completed</h1>
        <br>
        <div class="sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">