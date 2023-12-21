@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/auctions') }}" class="text-blue-500 hover:underline">Auctions</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">{{ $auction->name }}</span>
    </div>

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10" onclick="closeAllPopUps()"></div>

    <div class=" m-2 p-4 flex flex-col items-center rounded-lg text-stone-600 bg-white shadow-lg">
        @if (session('message'))
            <div class="w-full p-3 mb-1 text-stone-800 bg-stone-300 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
        <div class="w-full px-4 py-1 flex flex-row items-end justify-between border-b-2 border-stone-400">
            <div class="flex flex-row items-end">
                <h2 class="text-3xl">{{ $auction->name }}</h2>
                <p class="text-sm mx-5"> STATUS: {{ $auction->state }}</p>
            </div>
            @if (Auth::check() &&
                    Auth::user()->id === $auction->owner_id &&
                    $auction->state === 'active' &&
                    $auction->bids->count() === 0)
                <form method="POST" action="{{ url('/auction/' . $auction->id . '/disable') }}">
                    @csrf
                    <button type="submit" class="text-white text-sm bg-red-500 p-2 rounded-lg">Disable
                        Auction</button>
                </form>
            @endif
            @if (Auth::check() && Auth::user()->id !== $auction->owner_id)
                <div class="flex flex-row items-end">
                    <div title="Follow" class=" hover:cursor-pointer">
                        @if (Auth::user()->followedAuctions->contains($auction))
                            <img id="follow_icon" class="h-[2.5rem]" src="{{ asset('images/icons/full_heart.png') }}"
                                alt="Full Heart Icon" data-action="unfollow" data-user-id={{ Auth::user()->id }}
                                data-auction-id="{{ $auction->id }}">
                        @else
                            <img id="follow_icon" class="h-[2.5rem]" src="{{ asset('images/icons/empty_heart.png') }}"
                                alt="Empty Heart Icon" data-action="follow" data-user-id={{ Auth::user()->id }}
                                data-auction-id="{{ $auction->id }}">
                        @endif
                    </div>
                    <div title="Report" class="ml-2 hover:cursor-pointer" onclick="showReportPopup()">
                        <img id="report_icon" class="h-[2.5rem]" src="{{ asset('images/icons/full_warning.png') }}"
                            alt="Report Icon">
                    </div>

                </div>
            @endif
        </div>
        <div class="mt-4 w-full flex flex-row items-center justify-evenly">
            @php
                $auctionImagePaths = $auction->auctionImagePaths();
            @endphp

            <div class="swiper mySwiper max-w-[24rem] max-h-[16rem]">
                <div class="swiper-wrapper">
                    @foreach ($auctionImagePaths as $imagePath)
                        <div class="swiper-slide">
                            <img src="{{ asset($imagePath) }}" alt="Auction Image"
                                class="m-4 max-w-[24rem] max-h-[16rem] object-contain">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>

            </div>
            @if (Auth::check() && Auth::user()->id !== $auction->owner_id && $auction->state === 'active')
                <div class="bg-stone-200 m-2 p-4 flex flex-col rounded-lg">
                    <p><span class="font-bold">Current price:</span>{{ $auction->price }}</p>
                    <form class="flex flex-col" method="POST" action="{{ url('/auction/' . $auction->id . '/bid') }}">
                        @csrf
                        <input class="p-1 bg-stone-50 outline-none rounded-t-lg" type="number" min="1"
                            step=".01" name="amount" placeholder="Bid amount">
                        <button class="p-1 bg-stone-800 text-white rounded-b-lg" type="submit">Bid</button>
                        @if (session('error'))
                            <div class="text-sm text-red-800">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>
            @else
                @if (Auth::check() &&
                        $auction->auctionWinner &&
                        !$auction->auctionWinner->rating &&
                        Auth::user()->id === $auction->auctionWinner->user_id)
                    <div class="bg-stone-200 m-2 p-4 flex flex-col rounded-lg">
                        <form class="flex flex-col" method="POST"
                            action="{{ url('/auction/' . $auction->id . '/rate') }}">
                            @csrf
                            <div class="mb-2">
                                <label for="rating" class="text-stone-700 mx-1">Rate the seller (1-5)</label>
                                <input type="number" name="rating" id="sellerRating" min="1" max="5"
                                    class="mx-1 p-2 border rounded-md outline-none" required>
                            </div>
                            <button class="p-2 bg-stone-800 text-white rounded-md" type="submit">Submit Rating</button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
        <div class="mb-4 w-full flex flex-row items-start justify-between">

            <table class="table-fixed w-full text-left ">
                <tr class="border-b border-stone-300">
                    <th class="border-r border-stone-300">
                        <h3 class="mx-2 my-1">Auction Description</h3>
                    </th>
                    <th>
                        <div class="flex flex-row justify-between items-end">
                            <h3 class="mx-2 my-1">Bidding History</h3>
                            @if ($auction->bids->count() > 1)
                                <button class="text-sm text-stone-500 underline" onclick="showBidsPopup()">View full
                                    history</button>
                            @endif
                        </div>
                    </th>
                </tr>
                <tr>
                    <td class="border-r border-stone-300">
                        <div class="m-2">
                            <p>{{ $auction->description }}</p>
                            <br>
                            <p>Auction Owner: <a  href="{{ url('/user/' . $auction->owner_id) }}"> {{ $auction->owner->name }} </a> </p>
                            @if (count($auction->tags) > 0)
                                <div class="my-2 grid grid-cols-3">
                                    @foreach ($auction->tags as $tag)
                                        @include('partials.tag', ['tag' => $tag])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="m-2 flex flex-col">
                            @foreach ($bids as $bid)
                                @include('partials.bidpreview', ['bid' => $bid])
                            @endforeach
                            <p>Auction started at {{ $auction->initial_price }} euros.</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <p><span class="auction-remaining-time"></span></p>
            <span class="auction-end-time" hidden>{{ $auction->end_time }}</span>
            <span class="auction-status" hidden>{{ $auction->state }}</span>
        </div>
    </div>

    <div>
        @if ($auction->comments->count() > 0 || (Auth::check() && $auction->state === 'active'))
            <h3 class="mt-4 text-xl font-bold">Comments</h3>
        @endif
        @if (Auth::check() && $auction->state === 'active')
            <form class ="w-2/5 my-2 p-2 flex flex-col items-start border" method="POST"
                action="{{ url('/auction/' . $auction->id . '/comment/create') }}">
                @csrf
                <textarea name="message" class="w-full p-2 border rounded resize-none" placeholder="Add a comment" required></textarea>
                <button type="submit"
                    class="bg-stone-800 text-white p-1.5 mt-2 rounded text-xs self-end">Comment</button>
            </form>
        @endif
        @if ($auction->comments->count() > 0)
            @foreach ($auction->comments as $comment)
                <div class="mb-2">
                    @include('partials.comment', ['comment' => $comment])
                </div>
            @endforeach
        @endif
    </div>


    @if ($auction->state === 'approved' && Auth::user()->id === $auction->owner_id)
        <form class="my-8 mx-auto p-8 max-w-xl flex flex-col text-stone-800 bg-stone-200 shadow-lg" method="POST"
            action="{{ url('/auction/' . $auction->id . '/start') }}" enctype="multipart/form-data">
            @csrf

            <h2 class="mb-2 font-bold text-2xl">Start Auction</h2>

            <input class="p-2 bg-stone-50 outline-none rounded-lg" type="number" min="1" step=".01"
                name="days" placeholder="Number of days">

            <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Start</button>
        </form>
    @endif
    @if (Auth::check())
        <form id="reportAuction" method="POST" action="{{ url('/auction/' . $auction->id . '/report') }}"
            enctype="multipart/form-data"
            class="hidden min-w-[32rem] flex-col fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 rounded-lg items-center justify-center">
            @csrf

            <h2 class="font-bold text-3xl text-center self-start">Report Auction</h2>

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <label class="w-full mt-4 text-l text-left" for="description">Please describe the issue you found</label>
            <textarea class="w-full p-4 mb-4 border border-stone-400 rounded resize-none" id="description" name="description"
                rows="6" required></textarea>


            <div class="flex flex-row">
                <button class="mx-2 px-3 py-2 text-white bg-stone-800 rounded" type="sumbit">Submit Report</button>
                <button class="mx-2 px-3 py-2 text-stone-500 bg-white border-stone-500 border rounded" type="button"
                    onclick="cancelReport()">Cancel</button>
            </div>
        </form>
    @endif

    <div id="bidsPopup"
        class="hidden fixed flex-col top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 rounded-lg items-center justify-center w-[40rem]">
        <h2 class="mb-2 font-bold text-3xl text-center self-start">Bidding History</h2>
        <div class="w-full px-2 flex flex-col max-h-[42vh] overflow-y-auto items-center">
            @foreach ($auction->bids as $bid)
                @include('partials.bidpublic', ['bid' => $bid])
            @endforeach
        </div>
        <button class="mt-2 mx-2 px-3 py-2 text-stone-500 bg-white border-stone-500 border rounded"
            onclick="closeBidsPopup()">Close</button>
    </div>



    <script>
        function showReportPopup() {
            document.getElementById('overlay').classList.remove('hidden');
            reportAuction = document.getElementById('reportAuction');
            reportAuction.classList.remove('hidden');
            reportAuction.classList.add('flex');
        }

        function cancelReport() {
            reportAuction = document.getElementById('reportAuction');
            if (reportAuction && reportAuction.classList.contains('flex')) {
                document.getElementById('overlay').classList.add('hidden');
                reportAuction.classList.remove('flex');
                reportAuction.classList.add('hidden');
            }
        }

        function showDeletePopup() {
            document.getElementById('overlay').classList.remove('hidden');
            deleteConfirmation = document.getElementById('deleteConfirmation');
            deleteConfirmation.classList.remove('hidden');
            deleteConfirmation.classList.add('flex');
        }

        function cancelDelete() {
            deleteConfirmation = document.getElementById('deleteConfirmation');
            if (deleteConfirmation && deleteConfirmation.classList.contains('flex')) {
                document.getElementById('overlay').classList.add('hidden');
                deleteConfirmation.classList.remove('flex');
                deleteConfirmation.classList.add('hidden');
            }
        }

        function showBidsPopup() {
            document.getElementById('overlay').classList.remove('hidden');
            bidsPopup = document.getElementById('bidsPopup');
            bidsPopup.classList.remove('hidden');
            bidsPopup.classList.add('flex');
        }

        function closeBidsPopup() {
            bidsPopup = document.getElementById('bidsPopup');
            if (bidsPopup && bidsPopup.classList.contains('flex')) {
                document.getElementById('overlay').classList.add('hidden');
                bidsPopup.classList.remove('flex');
                bidsPopup.classList.add('hidden');
            }
        }

        function closeAllPopUps() {
            cancelReport()
            cancelDelete()
            closeBidsPopup()
        }
    </script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #A9A9A9;
            margin-left: 10px;
            margin-right: -5px;
        }

        .swiper-pagination {
            margin-left: 15px;
            margin-bottom: -9px;
        }

        .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            display: inline-block;
            margin: 0 5px;
            background-color: #ccc;
            border-radius: 50%;
            opacity: 0.8;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background-color: #333;
            opacity: 1;
        }
    </style>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
@endsection
