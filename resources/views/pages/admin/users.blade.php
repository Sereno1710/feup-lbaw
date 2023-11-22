@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">Admins</h1>
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
            <tr>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->id }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->username }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->name }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->email }}</td>
                <td class="py-2 px-4 border border-slate-300">{{ $admin->balance }}</td>
                <td class="py-2 px-4 border border-slate-300">
                        Normal
                </td>
                <td class="py-2 px-4 border border-slate-300">
                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.demote') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" value="{{ $admin->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Demote</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h1 class="text-4xl font-bold">Users</h1>
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
            <tr>
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
                <td class="py-2 px-4 border border-slate-300">
                    @if (!$user->is_anonymizing)
                        <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.disable') }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Disable</button> 
                        </form>
                    @endif

                    <form class="m-auto max-w-xl text-stone-800" method="POST" action="{{ route('admin.promote') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Promote</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

