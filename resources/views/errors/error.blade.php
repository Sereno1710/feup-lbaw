<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>SoundSello</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="text-stone-800 flex flex-col items-center justify-center">
        <div class="bg-white p-8 rounded text-center">
            <h1 class="text-2xl text-red-500 mb-2">Oops! Something went wrong :(</h1>
            <p class="text-base text-gray-700 mb-4">We're sorry, but it seems there was an error processing your request.
            </p>
            <p class="text-base text-gray-700 mb-8">Please try again later or contact <a href="mailto:support@soundsello.com" class="text-blue-500">support@soundsello.com</a></p>
        </div>
    </div>
</body>
