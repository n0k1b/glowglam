<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryStoreRequest;
use App\Http\Requests\Country\CountryUpdateRequest;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private $countryService;
    public function __construct(CountryService $countryService){
        $this->countryService = $countryService;
    }

    public function index(){
        if (auth()->user()->can('country-view')){
            return view('admin.pages.country.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function dataTable(){
        return $this->countryService->dataTable();
    }

    public function store(CountryStoreRequest $request){
        if (auth()->user()->can('country-store')){
            return $this->countryService->storeCountry($request);
        }
    }

    public function edit(Request $request){
        $data = $this->countryService->findCountry($request->country_id);
        return response()->json($data);
    }

    public function update(CountryUpdateRequest $request){
        if (auth()->user()->can('country-edit')){
            return $this->countryService->updateCountry($request);
        }
    }

    public function destroy(Request $request){
        if (auth()->user()->can('country-action')){
            return $this->countryService->destroy($request->id);
        }
    }

    public function bulkActionDelete(Request $request){
        if (auth()->user()->can('country-action')){
            return $this->countryService->bulkDestroy($request->idsArray);
        }
    }
}
