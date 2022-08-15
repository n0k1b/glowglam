<?php

namespace App\Traits;
use Illuminate\Support\Facades\File;


trait DeleteWithFileTrait{

    //This Function will be remove later. and setup all in deleteWithFile() method.
    public function deleteWithImage($model, $image_path)
    {
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
        $model->delete();
        return;
    }

    public function deleteMultipleDataWithImages($model)
    {
        foreach ($model->get() as $item) {
            if (File::exists(public_path($item->image))) {
                File::delete(public_path($item->image));
            }
        }
        $model->delete();
        return;
    }


    //if database column name is image
    public function deleteWithFile($model){
        if (isset($model->image) && File::exists(public_path($model->image))) {
            File::delete(public_path($model->image));
        }
        $model->delete();
    }
}
?>
