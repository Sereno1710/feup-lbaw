@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/MEGGAEROR') }}" class="text-blue-500 hover:underline">Auctions</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">Auction Name</span>
    </div>
    <div class="bg-stone-500 m-2 p-4 flex flex-col items-center rounded-lg shadow-lg">
        <div class="w-full px-4 py-1 flex flex-row items-end justify-between border-b-2 border-stone-400">
            <h2 class="text-3xl">Auction Name</h2>
            <div>
                <button>Report</button>
                <button>Follow</button>
            </div>
        </div>
        <div class="mt-4 w-full flex flex-row items-start justify-evenly">
            <img class="m-4" src="https://picsum.photos/250" alt="auctionphoto">
            <table class="table-fixed w-full text-left ">
                <tr class="border-b border-stone-400">
                    <th class="border-r border-stone-400">
                        <h3 class="mx-2 my-1">Auction Description</h3>
                    </th>
                    <th>
                        <h3 class="mx-2 my-1">Bidding History</h3>
                    </th>
                </tr>
                <tr>
                    <td class="border-r border-stone-400">
                        <div class="m-2">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at turpis et nibh mattis
                                faucibus
                                ac
                                eget
                                nunc. Maecenas dignissim molestie euismod. Suspendisse potenti. Etiam varius semper arcu,
                                accumsan
                                finibus neque ullamcorper eget. Curabitur dictum est non quam dapibus commodo. Quisque sed
                                sollicitudin
                                mi, ac molestie sapien.</p>
                            <p> Auction Owner: Maluco</p>
                        </div>
                    </td>
                    <td>
                        <div class="m-2 flex flex-col">
                            <?php for ($i = 0; $i < 3; $i++): ?>
                            @include('partials.bid')
                            <?php endfor; ?>
                            <p> Auction started at X euros.</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="w-full flex flex-row items-start justify-between">
            <div class="flex flex-col">
                <h3>Details</h3>
                <div class="grid grid-cols-3">
                    <?php for ($i = 0; $i < 8; $i++): ?>
                    @include('partials.tag')
                    <?php endfor; ?>
                </div>
            </div>
            <div class="flex flex-col">
                <p><span class="font-bold">Current price:</span> $42 000</p>
                <input class="p-1 bg-stone-200 outline-none rounded-t-lg" type="number" min="1" step=".01" name="ammount" placeholder="Bid ammount">
                <button class="p-1 bg-stone-800 text-white rounded-b-lg" type="submit">Bid</button>
            </div>
        </div>
        <div>
            <p>Time remaining: 1000</p>
        </div>
    </div>
@endsection
