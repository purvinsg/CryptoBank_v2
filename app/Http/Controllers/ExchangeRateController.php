<?php

namespace App\Http\Controllers;

use App\Jobs\ImportExchangeRates;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExchangeRateController extends Controller
{
    public function index()
    {
        // Start the ImportExchangeRates job
        dispatch(new ImportExchangeRates());

        // Retrieve the exchange rates from the database
        $exchangeRates = ExchangeRate::orderBy('symbol')->get();

        return Inertia::render('ExchangeRateIndex', [
            'exchangeRates' => $exchangeRates,
        ]);
    }
}
