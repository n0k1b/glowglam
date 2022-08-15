<div class="card">
    <h3 class="card-header"><b>{{__('file.Slider Banners')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="sliderBannerSubmit" action="{{route('admin.storefront.slider_banners.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Banner 1 -->
                    <!-- DB_ROW_ID-42-44:  => setting[41-43] -->
                    <h5 class="text-bold">{{__('file.Banner 1')}}</h5><br>
                    <div class="row">
                        <div class="col-md-6">
                            @forelse ($storefront_images as $key=> $item)
                                @if ($item->title=='slider_banner_1')
                                    @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                        <img src="{{asset('public/'.$item->image)}}" id="storefrontSliderBannerImage_1" height="100px" width="100px">
                                    @else
                                        <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-1" id="storefrontSliderBannerImage_1">
                                    @endif
                                    @break
                                @elseif ($key == ($total_storefront_images-1))
                                    <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-1" id="storefrontSliderBannerImage_1">
                                @endif
                            @empty
                                <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-1" id="storefrontSliderBannerImage_1">
                            @endforelse
                            <br><br>
                            <input type="file" name="storefront_slider_banner_1_image" class="form-control" onchange="showImage(this,'storefrontSliderBannerImage_1')">
                        </div>

                        <div class="col-md-6">
                            {{-- New Added --}}
                            <label class="col-form-label"><b>{{__('file.Title')}}</b></label>
                            <input type="text" name="storefront_slider_banner_1_title" placeholder="{{__('file.Title')}}" class="form-control"
                                @forelse ($setting[124]->settingTranslations as $key => $item)
                                    @if ($item->locale==$locale)
                                        value="{{$item->value}}" @break
                                    @elseif($item->locale=='en')
                                        value="{{$item->value}}" @break
                                    @endif
                                @empty
                                @endforelse >
                            <br>

                            <label class="col-form-label"><b>{{__('file.Call to Action URL')}}</b></label>
                            <input type="text" name="storefront_slider_banner_1_call_to_action_url" placeholder="{{__('file.Call to Action URL')}}" class="form-control"
                                value="{{$setting[42]->plain_value}}">
                            <br><br>

                            <input type="checkbox" class="m-1" @if($setting[43]->plain_value==1) checked @endif value="1" name="storefront_slider_banner_1_open_in_new_window">
                            <label for="inputEmail3" class="ml-2 p-0 col-form-label"><b>{{__('file.Open in new window')}}</b></label>
                        </div>
                    </div>

                    <br><br><br>

                    <!-- Banner 2 -->
                    <!-- DB_ROW_ID-45-47:  => setting[44-46] -->
                    <h5 class="text-bold">{{__('file.Banner 2')}}</h5><br>
                    <div class="row">
                        <div class="col-md-6">
                            @forelse ($storefront_images as $key=> $item)
                                @if ($item->title=='slider_banner_2')
                                    @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                        <img src="{{asset('public/'.$item->image)}}" id="storefrontSliderBannerImage_2" height="100px" width="100px">
                                    @else
                                        <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-2" id="storefrontSliderBannerImage_2">
                                    @endif
                                    @break
                                @elseif ($key == ($total_storefront_images-1))
                                    <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-2" id="storefrontSliderBannerImage_2">
                                @endif
                            @empty
                                <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-2" id="storefrontSliderBannerImage_2">
                            @endforelse
                            <br><br>
                            <input type="file" name="storefront_slider_banner_2_image" class="form-control" onchange="showImage(this,'storefrontSliderBannerImage_2')">
                        </div>

                        <div class="col-md-6">
                            {{-- New Added --}}
                            <label class="col-form-label"><b>{{__('file.Title')}}</b></label>
                            <input type="text" name="storefront_slider_banner_2_title" placeholder="{{__('file.Title')}}" class="form-control"
                                @forelse ($setting[125]->settingTranslations as $key => $item)
                                    @if ($item->locale==$locale)
                                        value="{{$item->value}}" @break
                                    @elseif($item->locale=='en')
                                        value="{{$item->value}}" @break
                                    @endif
                                @empty
                                @endforelse >
                            <br>
                            <label class="col-form-label"><b>{{__('file.Call to Action URL')}}</b></label>
                            <input type="text" name="storefront_slider_banner_2_call_to_action_url" placeholder="{{__('file.Call to Action URL')}}" class="form-control"
                                value="{{$setting[45]->plain_value}}">
                            <br><br>
                            <input type="checkbox" class="m-1" @if($setting[46]->plain_value==1) checked @endif value="1" name="storefront_slider_banner_2_open_in_new_window">
                            <label for="inputEmail3" class="ml-2 p-0 col-form-label"><b>{{__('file.Open in new window')}}</b></label>
                        </div>
                    </div>
                    <br><br><br>

                    <!-- Banner 3 -->
                    <!-- DB_ROW_ID-45-47:  => setting[44-46] -->
                    <h5 class="text-bold">{{__('file.Banner 3')}}</h5><br>
                    <div class="row">
                        <div class="col-md-6">
                            @forelse ($storefront_images as $key=> $item)
                                @if ($item->title=='slider_banner_3')
                                    @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                        <img src="{{asset('public/'.$item->image)}}" id="storefrontSliderBannerImage_3" height="100px" width="100px">
                                    @else
                                        <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-3" id="storefrontSliderBannerImage_3">
                                    @endif
                                    @break
                                @elseif ($key == ($total_storefront_images-1))
                                    <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-3" id="storefrontSliderBannerImage_3">
                                @endif
                            @empty
                                <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner-3" id="storefrontSliderBannerImage_3">
                            @endforelse
                            <br><br>
                            <input type="file" name="storefront_slider_banner_3_image" class="form-control" onchange="showImage(this,'storefrontSliderBannerImage_3')">
                        </div>

                        <div class="col-md-6">
                            {{-- New Added --}}
                            <label class="col-form-label"><b>{{__('file.Title')}}</b></label>
                            <input type="text" name="storefront_slider_banner_3_title" placeholder="Type the Title" class="form-control"
                                @forelse ($setting[127]->settingTranslations as $key => $item)
                                    @if ($item->locale==$locale)
                                        value="{{$item->value}}" @break
                                    @elseif($item->locale=='en')
                                        value="{{$item->value}}" @break
                                    @endif
                                @empty
                                @endforelse >
                            <br>
                            <label class="col-form-label"><b>{{__('file.Call to Action URL')}}</b></label>
                            <input type="text" name="storefront_slider_banner_3_call_to_action_url" placeholder="{{__('file.Call to Action URL')}}" class="form-control"
                                value="{{$setting[128]->plain_value}}">
                            <br><br>
                            <input type="checkbox" class="m-1" @if($setting[129]->plain_value==1) checked @endif value="1" name="storefront_slider_banner_3_open_in_new_window">
                            <label for="inputEmail3" class="ml-2 p-0 col-form-label"><b>{{__('file.Open in new window')}}</b></label>
                        </div>
                    </div>


                    <div class="form-group row mt-5">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary save">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>
