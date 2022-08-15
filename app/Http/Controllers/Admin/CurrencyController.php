<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyStoreRequest;
use App\Http\Requests\Currency\CurrencyUpdateRequest;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private $currencyService;
    public function __construct(CurrencyService $currencyService){
        $this->currencyService = $currencyService;
    }

    public function index(){
        if (auth()->user()->can('currency-view')){
            return view('admin.pages.currency.index');
        }
    }

    public function dataTable(){
        return $this->currencyService->dataTable();
    }

    public function store(CurrencyStoreRequest $request){
        if (auth()->user()->can('currency-store')){
            return $this->currencyService->storeCurrency($request);
        }
    }

    public function edit(Request $request){
        $data = $this->currencyService->findCurrency($request->currency_id);
        return response()->json($data);
    }

    public function update(CurrencyUpdateRequest $request){
        if (auth()->user()->can('currency-edit')){
            return $this->currencyService->updateCurrency($request);
        }
    }

    public function destroy(Request $request){
        if (auth()->user()->can('currency-action')){
            return $this->currencyService->destroy($request->id);
        }
    }

    public function bulkActionDelete(Request $request){
        if (auth()->user()->can('currency-action')){
            return $this->currencyService->bulkDestroy($request->idsArray);
        }
    }
}
