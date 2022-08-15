<?php
namespace App\Services;

use App\Contracts\Currency\CurrencyContract;

class CurrencyService
{
    private $currencyContract;
    public function __construct(CurrencyContract $currencyContract){
        $this->currencyContract = $currencyContract;
    }

    public function getAllCurrency(){
        return $this->currencyContract->getAll();
    }

    protected function supportedCurrencies()
    {
        $setting_currency = $this->currencyContract->supportedCurrencies();
        $supported_currencies = array();
        $supported_currencies = explode(",",$setting_currency->supported_currency);
        return $supported_currencies;
    }

    public function dataTable()
    {
        if (request()->ajax()){
            $currencies = $this->currencyContract->getAll();
            $supported_currencies = $this->supportedCurrencies();

            return datatables()->of($currencies)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('currency_name', function ($row){
                    return $row->currency_name ?? "";
                })
                ->addColumn('currency_code', function ($row){
                    return $row->currency_code ?? "";
                })
                ->addColumn('action', function ($row) use($supported_currencies)
                {
                    $actionBtn = '';
                    if (auth()->user()->can('currency-action')){
                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                            &nbsp; ';

                        if (in_array($row->currency_name, $supported_currencies)){
                            $disabled_check = 'disabled';
                            $title = 'This is in Supported Currency';
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
        $data['currency_name'] = $request->currency_name;
        $data['currency_code'] = $request->currency_code;
        return $data;
    }


    public function storeCurrency($request)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $data  = $this->requestHandleData($request);
            $this->currencyContract->storeData($data);
            return response()->json(['success' => __('Data Successfully Saved')]);
        }
    }

    public function findCurrency($id){
        return $this->currencyContract->getById($id);
    }

    public function updateCurrency($request)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $data  = $this->requestHandleData($request);
            $this->currencyContract->updateDataById($request->currency_id, $data);
            return response()->json(['success' => 'Data Updated Successfully']);
        }
    }

    public function destroy($id)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $this->currencyContract->delete($id);
            return response()->json(['success' => 'Data Deleted Successfully']);
        }
    }

    public function bulkDestroy($idsArray)
    {
        if (request()->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['demo' => 'Disabled for demo !']);
            }
            $supported_currencies_name = $this->supportedCurrencies();
            $data_ids = $this->currencyContract->getCurrencyIdsByName($supported_currencies_name);
            $currency_ids = json_decode($data_ids);
            $ids = [];

            foreach ($idsArray as $value) {
                if (!in_array($value, $currency_ids)){
                    $ids[] = $value;
                }
            }
            $this->currencyContract->bulkDelete($ids);
            return response()->json(['success' => 'Data Deleted Successfully']);
        }
    }
}


?>
