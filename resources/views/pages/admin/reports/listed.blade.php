@extends('layouts.admin')

@section('nav-bar')
    <div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
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
    <div class="mx-2 flex flex-col overflow-x-auto m-8">
        <h1 class="text-4xl font-bold">Reviewed Reports</h1>
        <br>
        <div class="mx-6 mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate" id="report_table">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border border-slate-300">Username</th>
                                <th class="py-2 px-4 border border-slate-300">Auction</th>
                                <th class="py-2 px-4 border border-slate-300">Description</th>
                                <th class="py-2 px-4 border boder-slate-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($listed as $report)
                        <tr id="report_row_{{ $report->user_id}}_{{ $report->auction_id}}">
                            <td class="py-2 px-4 border border-slate-300"><a href="{{ url('/user/' . $report->user_id) }}">{{ $report->username }}</a></td>
                            <td class="py-2 px-4 border border-slate-300"><a href="{{ url('/auction/' . $report->auction_id) }}" >{{ $report->name }}</a></td>
                            <td class="py-2 px-4 border border-slate-300">{{ $report->description }}</td>
                            <td class="py-2 px-4 border boder-slate-300">
                            <button auction_id="{{ $report->auction_id }}" user_id="{{ $report->user_id}}" class="mx-2 p-2 text-white bg-stone-800 rounded relevant-btn" type="button">Relevant</button>
                            <button auction_id="{{ $report->auction_id }}" user_id="{{ $report->user_id}}" class="mx-2 p-2 text-white bg-stone-800 rounded irrelevant-btn" type="button">Irrelevant</button>
                            </td>   
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $listed->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection