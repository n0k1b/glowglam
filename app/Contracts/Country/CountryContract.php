<?php

namespace App\Contracts\Country;

interface CountryContract
{
    public function getAll();

    public function supportedCountries();

    public function storeData($data);

    public function getById($id);

    public function updateDataById($id, $data);

    public function delete($id);

    public function getCountryIdsByName($supported_countries_name);

    public function bulkDelete($ids);

}

?>
