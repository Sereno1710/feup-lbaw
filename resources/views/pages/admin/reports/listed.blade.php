@extends('layouts.admin')

@section('nav-bar')
<div class="max-w-screen px-2 py-3 mx-auto">
    <div class="flex items-center">
        <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm py-8">
                <li class="flex items-center border-r border-black pr-8 px-4">
                    <a href="/admin/reports/listed" class="text-black font-bold">Listed</a>
                </li>
                <li class="flex items-center">
                    <a href="/admin/reports/reviewed" class="text-black">Reviewed</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<h1 class="mx-8 text-4xl font-bold">Listed</h1>
    <br>
    <div class="mx-8 overflow-y-auto">
        <div class="lg:flex-col">
            <div class="flex flex-col sm:flex-row md:flex-row lg:flex-col">
            <table class="table-auto text-center" id="report_table">
                <thead class="font-bold">
                            <tr>
                                <th class="p-2 border-b-2 border-slate-300">Username</th>
                                <th class="p-2 border-b-2 border-slate-300">Auction</th>
                                <th class="p-2 border-b-2 border-slate-300">Description</th>
                                <th class="p-2 border-b-2 border-slate-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($listed as $report)
                        <tr id="report_row_{{ $report->user_id}}_{{ $report->auction_id}}">
                            <td class="p-2 border-b-2 border-slate-300"><a href="{{ url('/user/' . $report->user_id) }}">{{ $report->username }}</a></td>
                            <td class="p-2 border-b-2 border-slate-300"><a href="{{ url('/auction/' . $report->auction_id) }}" >{{ $report->name }}</a></td>
                            <td class="p-2 border-b-2 border-slate-300">{{ $report->description }}</td>
                            <td class="p-2 border-b-2 border-slate-300">
                            <button auction_id="{{ $report->auction_id }}" user_id="{{ $report->user_id}}" class="m-2 py-1 px-2 text-white bg-stone-800 rounded relevant-btn" type="button">Relevant</button>
                            <button auction_id="{{ $report->auction_id }}" user_id="{{ $report->user_id}}" class="m-2 py-1 px-2 text-white bg-stone-800 rounded irrelevant-btn" type="button">Irrelevant</button>
                            </td>   
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                <div>
                    {{ $listed->links() }}
                </div>
            </div>
        </div>
@endsection