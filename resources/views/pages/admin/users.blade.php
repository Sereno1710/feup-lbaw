@extends('layouts.admin')

@section('nav-bar')

<div class="max-w-screen px-2 py-3 mx-auto">
        <div class="flex justify-between items-center">
            <form class="p-1 bg-stone-200" action="/users/search" method="GET">
                    <input class="bg-stone-200 outline-none" type="text" name="keyword" placeholder="Search users">
                    <button type="submit">🔎</button>
            </form>
        </div>
</div>
@endsection
@section('content')

        <div class="flex flex-col m-8">
        <h1 class="mx-6 mx-8 text-4xl font-bold">Users</h1>
        <br>
        <div class="mx-6 mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-x-auto" id="users_table">
                <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th class="py-2 px-4 border border-slate-300">ID</th>
                                <th class="py-2 px-4 border border-slate-300">Username</th>
                                <th class="py-2 px-4 border border-slate-300">Name</th>
                                <th class="py-2 px-4 border border-slate-300">Email</th>
                                <th class="py-2 px-4 border border-slate-300">Balance</th>
                                <th class="py-2 px-4 border border-slate-300">Role</th>
                                <th class="py-2 px-4 border border-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr id="user_row_{{ $user->id }}">
                                    <td class="py-2 px-4 border border-slate-300">{{ $user->id }}</td>
                                    <td class="py-2 px-4 border border-slate-300">{{ $user->username }}</td>
                                    <td class="py-2 px-4 border border-slate-300">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border border-slate-300">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border border-slate-300">{{ $user->balance }}</td>
                                    <td class="py-2 px-4 border border-slate-300" id="role">
                                        @if ($user->isAdmin())
                                            Admin
                                        @elseif ($user->isSystemManager())
                                            System Manager
                                        @else
                                            User    
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border border-slate-300 flex flex-row">
                                    @if ($user->isAdmin())
                                        None
                                    @elseif ($user->isSystemManager() && !$user->isAdmin())
                                        <button user_id="{{ $user->id }}" name="user_id"
                                            class="mx-2 p-2 text-white bg-stone-800 rounded demote-btn"
                                            type="button">Demote</button>
                                    @else
                                        @if(!$user->isAdmin() && !$user->isSystemManager() && Auth::user()->isAdmin() && Auth::user()->isSystemManager())
                                            <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded disable-btn" type="button">Disable</button>
                                        @if(!$user->isBanned())
                                                <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded promote-btn" type="button">Promote</button>
                                            @endif
                                        @endif
                                        @if($user->isBanned())
                                            <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded unban-btn" type="button">Unban</button>
                                        @elseif(!$user->isAdmin() && !$user->isSystemManager())
                                            <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded ban-btn" type="button">Ban</button>
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>

@endsection