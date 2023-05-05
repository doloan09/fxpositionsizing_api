<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyExcRateResource extends JsonResource
{
    public static $wrap = "Realtime Currency Exchange Rate";

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $exc_rate  = number_format($this->exchange_rate, 8);
        $bid_price = number_format($this->bid_price, 8);
        $ask_price = number_format($this->ask_price, 8);

        return [
            "1. From_Currency Code" => $this->from_currency_code,
            "2. From_Currency Name" => $this->from_currency_name,
            "3. To_Currency Code"   => $this->to_currency_code,
            "4. To_Currency Name"   => $this->to_currency_name,
            "5. Exchange Rate"      => "$exc_rate",
            "6. Last Refreshed"     => $this->last_refreshed,
            "7. Time Zone"          => $this->time_zone,
            "8. Bid Price"          => "$bid_price",
            "9. Ask Price"          => "$ask_price",
        ];
    }
}
