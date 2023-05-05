<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyExcRate extends Model
{

    protected $table = 'currency_exc_rate';

    protected $primaryKey = 'id';

    protected $fillable = [
        'from_currency_code',
        'from_currency_name',
        'to_currency_code',
        'to_currency_name',
        'exchange_rate',
        'last_refreshed',
        'time_zone',
        'bid_price',
        'ask_price',
        'updated_at',
    ];

}
