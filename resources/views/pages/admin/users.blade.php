@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<div  class="container mx-auto">
    <div id="admin_section">
    <h1 class="text-4xl font-bold">Admins</h1>
    <br>
    <table class="min-w-full border-separate">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Username</th>
                <th class="py-2 px-4 border border-slate-300">Name</th>
                <th class="py-2 px-4 border border-slate-300">Email</th>
                <th class="py-2 px-4 border border-slate-300">Balance</th>
                <th class="py-2 px-4 border border-slate-300">State</th>
                <th class="py-2 px-4 border border-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr id="admin_row_{{ $admin->id }}">
                <td class="py-2 px-4 border border-slate-300">{{ $admin->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->username }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->name }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->email }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->balance }}</td>
                <td class="py-2 px-4 border border-slate-300">
                        Normal
                </td>
                <td class="py-2 px-4 border border-slate-300 flex flex-row">
                    <form class="m-auto max-w-xl text-stone-800 demote-form"  enctype="multipart/form-data">
                        @csrf
                        <input id="data-user-id" type="hidden" name="user_id" value="{{ $admin->id }}">
                        <button name="user_id" class="mt-2 p-2 text-white bg-stone-800 rounded demote-btn" type="button">Demote</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div id="user_section">
    <h1 class="text-4xl font-bold">Users</h1>
    <br>
    <table class="min-w-full border-separate">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-slate-300">ID</th> 
                <th class="py-2 px-4 border border-slate-300">Username</th>
                <th class="py-2 px-4 border border-slate-300">Name</th>
                <th class="py-2 px-4 border border-slate-300">Email</th>
                <th class="py-2 px-4 border border-slate-300">Balance</th>
                <th class="py-2 px-4 border border-slate-300">State</th>
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
                <td class="py-2 px-4 border border-slate-300">
                    @if ($user->is_anonymizing)
                        Anonymous
                    @else
                        Normal
                    @endif
                </td>
                <td class="py-2 px-4 border border-slate-300 flex flex-row">
                @if (!$user->is_anonymizing)
                    <form class="m-auto max-w-xl text-stone-800 disable-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button name="user_id" class="mt-2 p-2 text-white bg-stone-800 rounded disable-btn" type="button">Disable</button> 
                    </form>
                    @endif

                    <form class="m-auto max-w-xl text-stone-800 promote-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button name="user_id" class="mt-2 p-2 text-white bg-stone-800 rounded promote-btn" type="button">Promote</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


