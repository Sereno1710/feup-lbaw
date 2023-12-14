@extends('layouts.admin')

@section('nav-bar')

<div class="max-w-screen px-2 py-3 mx-auto">
<div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/admin/users" class="text-black font-bold">Users</a>
                </li>
            </ul>
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
                                        <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded popup-btn" type="button" onclick="showDeletePopup({{ $user->id }})">Delete</button>
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

            <div id="over" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-20"></div>
            <div id="disableUser" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-8 rounded-md text-center" id="pop">
                    <p class="text-red-500 mb-4">Are you sure you want to delete this account? This action cannot be reversed.</p>
                    <button id="delete" class="mt-2 p-2 text-white bg-red-500 rounded disable-btn" type="button">Yes.</button>
                    <button class="mt-2 p-2 text-white bg-blue-500 rounded" type="button" onclick="cancelDelete()">Cancel.</button>
                </div>
            </div>
@endsection