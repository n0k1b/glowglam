<?php

namespace App\Traits;
use Illuminate\Support\Facades\Session;
use Image;
use Str;
use Illuminate\Support\Facades\File;

trait imageHandleTrait{

    public function imageStore($image, $directory, $type)
    {
        // $img      = Str::random(10). '.' .'webp';
        $img        = Str::random(10). '.' .$image->getClientOriginalExtension();
        $location = public_path($directory.$img);
        if ($type=='brand') {
            Image::make($image)->encode('jpg', 60)->fit(500,150)->save($location);
        }
        elseif ($type=='header_logo') {
            Image::make($image)->encode('jpg', 60)->fit(280,62)->save($location);
        }
        elseif($type=='store_front_footer')
        {
            Image::make($image)->encode('jpg', 60)->fit(342,30)->save($location);
        }
        elseif($type=='general')
        {
            Image::make($image)->encode('jpg', 60)->save($location);
        }
        elseif($type=='topbar_logo')
        {
            $filename = Str::random(10).'.'.$image->getClientOriginalExtension();
            $image->move(public_path($directory), $filename);
            return $directory.$filename;
        }
        elseif($type=='slider_banner')
        {
            Image::make($image)->encode('jpg', 60)->fit(500,230)->save($location);
        }
        elseif($type=='one_column_banner')
        {
            Image::make($image)->encode('jpg', 60)->fit(1200,270)->save($location);
        }
        elseif($type=='two_column_banners')
        {
            Image::make($image)->encode('jpg', 60)->fit(870,270)->save($location);
        }
        elseif($type=='three_column_banners' || $type=='three_column_full_width_banners')
        {
            Image::make($image)->encode('jpg', 60)->fit(570,230)->save($location);
        }
        elseif($type=='newslatter')
        {
            $img      = 'newslatter'. '.' .'jpg';
            $location = public_path($directory.$img);
            Image::make($image)->encode('jpg', 60)->fit(850,450)->save($location);
        }
        elseif($type=='about_us')
        {
            Image::make($image)->encode('webp', 60)->fit(1920,1240)->save($location);
        }
        else {
            Image::make($image)->encode('jpg', 60)->fit(300,300)->save($location);
        }
        $imageUrl = $directory.$img;
        return $imageUrl;
    }


    public function imageSliderStore($image, $directory,$width, $height)
    {
        $img       = Str::random(10). '.' .$image->getClientOriginalExtension();
        $location  = public_path($directory.$img);
        Image::make($image)->resize($width,$height)->save($location);
        $imageUrl = $directory.$img;

        return $imageUrl;
    }


    //General
    public function previousImageDelete($image_path)
    {
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
    }




}

?>
