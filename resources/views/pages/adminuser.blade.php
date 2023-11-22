@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<div class="container mx-auto">
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
                    <form class="m-auto max-w-xl text-stone-800" method="POST">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Disable</button> 
                    </form>
                    <form class="m-auto max-w-xl text-stone-800" method="POST">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Promote</button> 
                    </form>
                    <form class="m-auto max-w-xl text-stone-800" method="POST">
                        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Demote</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

