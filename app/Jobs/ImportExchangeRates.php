<?php

namespace App\Jobs;

use App\Models\ExchangeRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportExchangeRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = 'https://www.bank.lv/vk/ecb.xml';
        $xml = simplexml_load_file($url);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        $currencies = $array['Currencies']['Currency'];

        $exchangeRates = collect($currencies)->map(function ($attributes) {
            return [
                'symbol' => $attributes['ID'],
                'rate' => $attributes['Rate'],
            ];
        })->push([
            'symbol' => 'EUR',
            'rate' => 1,
        ])->sortBy('symbol');

        // Store exchange rates in the database
        foreach ($exchangeRates as $exchangeRate) {
            ExchangeRate::updateOrCreate(
                ['symbol' => $exchangeRate['symbol']],
                ['rate' => $exchangeRate['rate']]
            );
        }
    }
}
