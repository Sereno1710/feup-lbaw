@extends('layouts.app')

@section('content')
<div class="balance-container mx-auto mt-8 p-8 bg-white rounded-lg shadow-md max-w-md">
    <h2 class="text-2xl font-bold mb-4">Your Balance</h2>
    <p class="mb-4">Current Balance: {{ $user->balance }}</p>

    <form method="post" action="{{ route('balance.deposit') }}" class="mb-8">
        @csrf
        <div class="mb-4">
            <label for="deposit_amount" class="block text-sm font-medium text-gray-600">Deposit Amount:</label>
            <input type="number" name="deposit_amount" id="deposit_amount" class="mt-1 p-2 w-full border rounded-md">
            @if ($errors->has('deposit_amount'))
                <span class="error">
                    {{ $errors->first('deposit_amount') }}
                </span>
            @endif
        </div>
        <div class="mb-4">
            <label for="iban_deposit" class="block text-sm font-medium text-gray-600">IBAN:</label>
            <input type="text" name="iban_deposit" id="iban_deposit" class="mt-1 p-2 w-full border rounded-md">
            @if ($errors->has('iban_deposit'))
                <span class="error">
                    Invalid IBAN, please try again
                </span>
            @endif
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Deposit</button>
    </form>

    <form method="post" action="{{ route('balance.withdraw') }}">
        @csrf
        <div class="mb-4">
            <label for="withdraw_amount" class="block text-sm font-medium text-gray-600">Withdraw Amount:</label>
            <input type="number" name="withdraw_amount" id="withdraw_amount" class="mt-1 p-2 w-full border rounded-md">
            @if ($errors->has('withdraw_amount'))
                <span class="error">
                    {{ $errors->first('withdraw_amount') }}
                </span>
            @endif
        </div>
        <div class="mb-4">
            <label for="iban_withdraw" class="block text-sm font-medium text-gray-600">IBAN:</label>
            <input type="text" name="iban_withdraw" id="iban_withdraw" class="mt-1 p-2 w-full border rounded-md">
            @if ($errors->has('iban_withdraw'))
                <span class="error">
                    Invalid IBAN, please try again
                </span>
            @endif
        </div>
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Withdraw</button>
    </form>
</div>
@endsection
