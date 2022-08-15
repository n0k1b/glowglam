<?php

namespace App\Repositories\Currency;

use App\Contracts\Currency\CurrencyContract;
use App\Models\Currency;
use App\Models\SettingCurrency;

class CurrencyRepository implements CurrencyContract
{
    public function getAll(){
        return Currency::select('id','currency_name','currency_code')->get();
    }

    public function storeData($data){
        Currency::create($data);
    }

    public function getById($id){
        return Currency::find($id);
    }

    public function updateDataById($id, $data){
        Currency::whereId($id)->update($data);
    }

    public function delete($id){
        $this->getById($id)->delete();
    }

    public function bulkDelete($ids){
        Currency::whereIn('id',$ids)->delete();
    }

    public function supportedCurrencies(){
        return SettingCurrency::select('supported_currency')->latest()->first();
    }

    public function getCurrencyIdsByName($supported_currencies_name){
        return Currency::whereIn('currency_name',$supported_currencies_name)->get()->pluck('id');
    }

}

