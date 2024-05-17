<?php

namespace App\Console\Commands;
use App\Http\Classes\CoinMarketCap\Api;
use App\Models\Currency;
use Illuminate\Console\Command;

class UpdateCourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coinsFiat = Currency::where('type', 'fiat')->get();
        $coinsCrypto = Currency::where('type', 'crypto')->get();
        foreach ($coinsFiat as $coin) {
            $api = new Api('USDT', $coin->symbol);
            $coin->course = $api->getPrice();
            $coin->save();
        }
        foreach ($coinsCrypto as $coin) {
            $api = new Api($coin->symbol, 'USD');
            $coin->course = $api->getPrice();
            $coin->save();
        }
    }
}
