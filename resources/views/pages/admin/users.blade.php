@extends('layouts.admin')

@section('nav-bar')
<div class="max-w-screen px-2 py-3 mx-auto">
    <div class="flex items-center">
        <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm py-8">
            <li>
                <a href="/admin/users" class="text-black font-bold">Users</a>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content')
    <h1 class="mx-8 text-4xl font-bold">Users</h1>
    <br>
    <div class="mx-8 overflow-y-auto">
        <div id="users_table" class="lg:flex-col">
            <div class="flex flex-col sm:flex-row md:flex-row lg:flex-col">
            <table class="table-auto text-center">
                <thead class="font-bold">
                    <tr>
                        <th class="p-2 border-b-2 border-slate-300">ID</th>
                        <th class="p-2 border-b-2 border-slate-300">Username</th>
                        <th class="p-2 border-b-2 border-slate-300">Name</th>
                        <th class="p-2 border-b-2 border-slate-300">Email</th>
                        <th class="p-2 border-b-2 border-slate-300">Balance</th>
                        <th class="p-2 border-b-2 border-slate-300">Role</th>
                        <th class="p-2 border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr id="user_row_{{ $user->id }}">
                            <td class="p-2 border-b-2 border-slate-300">{{ $user->id }}</td>
                            <td class="p-2 border-b-2 border-slate-300 username">{{ $user->username }}</td>
                            <td class="p-2 border-b-2 border-slate-300 name">{{ $user->name }}</td>
                            <td class="p-2 border-b-2 border-slate-300 email">{{ $user->email }}</td>
                            <td class="p-2 border-b-2 border-slate-300">{{ $user->balance }}</td>
                            <td class="p-2 border-b-2 border-slate-300" id="role">
                                @if ($user->isAdmin())
                                    Admin
                                @elseif ($user->isSystemManager())
                                    System Manager
                                @else
                                    User
                                @endif
                            </td>
                            <td class="p-2 border-b-2 border-slate-300">
                                <div class="flex flex-row justify-center">
                                    @if ($user->isAdmin() or $user->id == Auth::user()->id)
                                        <p class="p-2">None</p>
                                    @elseif ($user->isSystemManager() && !$user->isAdmin())
                                        <button user_id="{{ $user->id }}" name="user_id" role="{{ Auth::user()->isAdmin() ? true : false }}"
                                            class="m-2 py-1 px-2 text-white bg-stone-800 rounded demote-btn" type="button">Demote
                                        </button>
                                    @else
                                        @if(!$user->isAdmin() && !$user->isSystemManager() && Auth::user()->isAdmin() && Auth::user()->isSystemManager())
                                            <button user_id="{{ $user->id }}"
                                                class="m-2 py-1 px-2 text-white bg-stone-800 rounded edit-btn" type="button">
                                                Edit </button>
                                            <button user_id="{{ $user->id }}" user_name="{{ $user->name }}"
                                                class="m-2 py-1 px-2 text-white bg-stone-800 rounded popup-btn" type="button">
                                                Delete
                                            </button>
                                            
                                            @if(!$user->isBanned())
                                                <button user_id="{{ $user->id }}" role="{{ Auth::user()->isAdmin()? true : false }}"
                                                    class="m-2 py-1 px-2 text-white bg-stone-800 rounded promote-btn" type="button">
                                                    Promote
                                                </button>
                                            @endif
                                        @endif
                                        @if($user->isBanned())
                                            <button user_id="{{ $user->id }}"
                                                class="m-2 py-1 px-2 text-white bg-stone-800 rounded unban-btn" type="button">
                                                Unban
                                            </button>
                                        @elseif(!$user->isAdmin() && !$user->isSystemManager())
                                            <button user_id="{{ $user->id }}"
                                                class="m-2 py-1 px-2 text-white bg-stone-800 rounded ban-btn" type="button">Ban
                                            </button>
                                        @endif
                                    @endif
                                </div>
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
    </div>
@endsection
