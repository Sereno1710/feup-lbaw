<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\AuctionWinner;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $auctionIds = Auction::where('end_time', '<', now())
                ->where('state', 'active')
                ->pluck('id');

            foreach ($auctionIds as $id) {
                DB::transaction(function () use ($id) {
                    Auction::where('id', $id)->update(['state' => 'finished']);

                    if (Bid::where('auction_id', $id)->exists()) {
                        $winnerUserId = Bid::where('auction_id', $id)
                            ->orderBy('amount', 'desc')
                            ->value('user_id');

                        AuctionWinner::create([
                            'user_id' => $winnerUserId,
                            'auction_id' => $id,
                            'rating' => null,
                        ]);

                        $auction = Auction::findOrFail($id);
                        $ownerId = $auction->owner_id;

                        DB::raw('update "users" set "balance" = balance + (SELECT amount FROM (SELECT user_id, amount FROM bid WHERE auction_id = ? ORDER BY amount DESC LIMIT 1) AS LastBid) wher id = ?', [$id, $ownerId]);
                    }
                });
            }
        })->everyMinute();    
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
