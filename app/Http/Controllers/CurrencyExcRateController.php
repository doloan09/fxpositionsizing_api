<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyExcRateResource;
use App\Models\CurrencyExcRate;
use Illuminate\Http\Request;

class CurrencyExcRateController extends Controller
{
    public function getRate(Request $request)
    {
        $from_currency = $request->get('from_currency');
        $to_currency   = $request->get('to_currency');
        $apikey        = $request->get('apikey');

        if ($apikey === env('API_KEY')){
            $item = CurrencyExcRate::query()->where('from_currency_code', $from_currency)->where('to_currency_code', $to_currency)->first();

            return new CurrencyExcRateResource($item);
        }

        return abort(403);
    }

    public function updateRate()
    {
        $url = env('URL_ALPHA_VANTAGE');
        $apikey = env('API_KEY');
        $arr_currency_main = ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'CHF']; //'USDJPY', 'EURJPY', 'GBPJPY', 'AUDJPY', 'CADJPY', 'CHFJPY'
        $arr_currency = ['EUR', 'GBP', 'AUD', 'CAD']; //'EURUSD', 'GBPUSD', 'AUDUSD', 'CADUSD'

        foreach ($arr_currency_main as $item){
            $url .= '&from_currency=' . $item . '&to_currency=JPY&apikey=' . $apikey;
            $json = file_get_contents($url);
            $data = json_decode($json,true);

            if ($data){
                $data_currency['from_currency_code'] = $data["Realtime Currency Exchange Rate"]["1. From_Currency Code"];
                $data_currency['from_currency_name'] = $data["Realtime Currency Exchange Rate"]["2. From_Currency Name"];
                $data_currency['to_currency_code']   = $data["Realtime Currency Exchange Rate"]["3. To_Currency Code"];
                $data_currency['to_currency_name']   = $data["Realtime Currency Exchange Rate"]["4. To_Currency Name"];
                $data_currency['exchange_rate']      = $data["Realtime Currency Exchange Rate"]["5. Exchange Rate"];
                $data_currency['last_refreshed']     = $data["Realtime Currency Exchange Rate"]["6. Last Refreshed"];
                $data_currency['time_zone']          = $data["Realtime Currency Exchange Rate"]["7. Time Zone"];
                $data_currency['bid_price']          = $data["Realtime Currency Exchange Rate"]["8. Bid Price"];
                $data_currency['ask_price']          = $data["Realtime Currency Exchange Rate"]["9. Ask Price"];

                CurrencyExcRate::query()->updateOrCreate([
                    'from_currency_code' => $data_currency['from_currency_code'],
                    'to_currency_code' => $data_currency['to_currency_code'],
                ], $data_currency);

                if ($item === 'USD'){
                    foreach ($arr_currency as $i){
                        $data_currency['from_currency_code'] = $i;
                        $data_currency['from_currency_name'] = $i;
                        $data_currency['to_currency_code'] = 'USD';
                        $data_currency['to_currency_name'] = 'United States Dollar';

                        CurrencyExcRate::query()->updateOrCreate([
                            'from_currency_code' => $data_currency['from_currency_code'],
                            'to_currency_code' => $data_currency['to_currency_code'],
                        ], $data_currency);
                    }
                }elseif ($item === 'CHF'){  //USDCHF
                    $data_currency['from_currency_code'] = 'USD';
                    $data_currency['from_currency_name'] = 'United States Dollar';
                    $data_currency['to_currency_code'] = 'CHF';
                    $data_currency['to_currency_name'] = 'Swiss Franc';

                    CurrencyExcRate::query()->updateOrCreate([
                        'from_currency_code' => $data_currency['from_currency_code'],
                        'to_currency_code' => $data_currency['to_currency_code'],
                    ], $data_currency);
                }
            }

            sleep(30);
        }

        return response()->json(['status' => 200]);
    }
}
