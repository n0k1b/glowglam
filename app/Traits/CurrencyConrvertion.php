<?php
namespace App\Traits;

use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Session;

trait CurrencyConrvertion{

    public function CurrencyConvert($main_amount)
    {
        $currency_code = Session::get('currency_code');

        $currencyRate = CurrencyRate::where('currency_code',$currency_code)
                    ->select('currency_code','currency_rate')
                    ->first();

        return $main_amount * $currencyRate->currency_rate;
    }

    public function CurrencySymbol()
    {
        $currency_code = Session::get('currency_code');

        $currencyRate = CurrencyRate::where('currency_code',$currency_code)
                    ->select('currency_code','currency_symbol')
                    ->first();

        return $currencyRate->currency_symbol;
    }

    public function ChangeCurrencyRate()
    {
        $currency_code = Session::get('currency_code');

        $currencyRate = CurrencyRate::where('currency_code',$currency_code)
                    ->select('currency_code','currency_symbol','currency_rate')
                    ->first();

        return $currencyRate->currency_rate;
    }

}
