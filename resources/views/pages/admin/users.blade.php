@extends('layouts.app')


@section('content')
    <br>
    <br>
    <br>
    <br>
    <h1 class="mx-2 text-4xl font-bold">Users</h1>
<div class="mx-2 flex flex-col overflow-x-auto">
  <div class="sm:-mx-6 lg:-mx-8">
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
                                @else
                                    User
                                @endif
                            </td>
                            <td class="py-2 px-4 border border-slate-300 flex flex-row">
                            @if ($user->isAdmin())
                                <button user_id="{{ $user->id }}" name="user_id"
                                    class="mx-2 p-2 text-white bg-stone-800 rounded demote-btn"
                                    type="button">Demote</button>
                            @else
                                <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded disable-btn" type="button">Disable</button>
                                    
                                <button user_id="{{ $user->id }}" class="mx-2 p-2 text-white bg-stone-800 rounded promote-btn" type="button">Promote</button>
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
