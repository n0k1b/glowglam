<?php

namespace App\Repositories\Brand;

use App\Contracts\Brand\BrandContract;
use App\Models\Brand;
use App\Traits\ActiveInactiveTrait;

class BrandRepository implements BrandContract
{
    use ActiveInactiveTrait;

    public function getAllBrands(){
        return Brand::orderBy('is_active','DESC')
                ->orderBy('id','DESC')
                ->get()
                ->map->format();
    }

    public function storeBrand($data){
        return Brand::create($data);
    }

    public function getById($id){
        return Brand::find($id);
    }

    public function updateBrandById($id, $data){
        return Brand::whereId($id)->update($data);
    }

    public function active($id){
        return $this->activeData($this->getById($id));
    }

    public function inactive($id){
        return $this->inactiveData($this->getById($id));
    }

    public function bulkAction($type, $ids){
        return $this->bulkActionData($type, Brand::whereIn('id',$ids));
    }
}


