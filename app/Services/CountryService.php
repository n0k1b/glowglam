<?php
namespace App\Services;

use App\Contracts\Country\CountryContract;
use App\Models\SettingGeneral;

class CountryService
{
    private $countryContract;
    public function __construct(CountryContract $countryContract){
        $this->countryContract = $countryContract;
    }

    public function getAllCountry(){
        return $this->countryContract->getAll();
    }

    protected function supportedCountries()
    {
        $setting_country = $this->countryContract->supportedCountries();
        $supported_countries = array();
        $supported_countries = explode(",",$setting_country->supported_countries);
        return $supported_countries;
    }

    public function dataTable()
    {
        if (request()->ajax()){
            $currencies = $this->countryContract->getAll();
            $supported_countries = $this->supportedCountries();

            return datatables()->of($currencies)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('country_name', function ($row){
                    return $row->country_name ?? "";
                })
                ->addColumn('country_code', function ($row){
                    return $row->country_code ?? "";
                })
                ->addColumn('action', function ($row) use($supported_countries)
                {
                    $actionBtn = '';
                    if (auth()->user()->can('country-action')){
                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                            &nbsp; ';

                        if (in_array($row->country_name, $supported_countries)){
                            $disabled_check = 'disabled';
                            $title = 'This is in Supported Country';
                        }else {
                            $disabled_check = null;
                            $title = 'Delete';
                        }
                        $actionBtn .= '<button type="button" '.$disabled_check.' title="'.$title.'" class="delete btn btn-danger btn-sm ml-2" title="Edit" data-id="'.$row->id.'"><i class="dripicons-trash"></i></button>
                            &nbsp; ';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    protected function requestHandleData($request)
    {
        $data = [];
        $data['country_name'] = $request->country_name;
        $data['country_code'] = $request->country_code;
        return $data;
    }

    public function storeCountry($request)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $data  = $this->requestHandleData($request);
            $this->countryContract->storeData($data);
            return response()->json(['success' => __('Data Successfully Saved')]);
        }
    }

    public function findCountry($id){
        return $this->countryContract->getById($id);
    }

    public function updateCountry($request)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $data  = $this->requestHandleData($request);
            $this->countryContract->updateDataById($request->country_id, $data);
            return response()->json(['success' => 'Data Updated Successfully']);
        }
    }

    public function destroy($id)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $this->countryContract->delete($id);
            return response()->json(['success' => 'Data Deleted Successfully']);
        }
    }

    public function bulkDestroy($idsArray)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $supported_country_name = $this->supportedCountries();
            $data_ids = $this->countryContract->getCountryIdsByName($supported_country_name);
            $counties_ids = json_decode($data_ids);
            $ids = [];

            foreach ($idsArray as $value) {
                if (!in_array($value, $counties_ids)){
                    $ids[] = $value;
                }
            }
            $this->countryContract->bulkDelete($ids);
            return response()->json(['success' => 'Data Deleted Successfully']);
        }
    }

}


?>
