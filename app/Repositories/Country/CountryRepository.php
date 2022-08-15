<?php

namespace App\Repositories\Country;

use App\Contracts\Country\CountryContract;
use App\Models\Country;
use App\Models\SettingGeneral;

class CountryRepository implements CountryContract
{

    public function getAll(){
        return Country::select('id','country_code','country_name')->orderByDesc('id')->get();
    }

    public function supportedCountries(){
        return SettingGeneral::select('supported_countries')->latest()->first();
    }

    public function storeData($data){
        Country::create($data);
    }

    public function getById($id){
        return Country::find($id);
    }

    public function updateDataById($id, $data){
        Country::whereId($id)->update($data);
    }

    public function delete($id){
        $this->getById($id)->delete();
    }

    public function getCountryIdsByName($supported_countries_name){
        return Country::whereIn('country_name',$supported_countries_name)->get()->pluck('id');
    }

    public function bulkDelete($ids){
        Country::whereIn('id',$ids)->delete();
    }




}

