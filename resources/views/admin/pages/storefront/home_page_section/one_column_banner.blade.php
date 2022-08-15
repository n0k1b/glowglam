<div class="card">
    <h3 class="card-header"><b>{{__('file.One Column Banner')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="oneColumnBannerSubmit">
                    @csrf

                    <!-- DB_ROW_ID-48:  => setting[47] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Section Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" @if($setting[47]->plain_value==1) checked @endif value="1" name="storefront_one_column_banner_enabled" class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable one column banner section')</label>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Banner -->
                    <!-- DB_ROW_ID-49-51:  => setting[48-50] -->
                    <h5 class="text-bold">{{__('file.Banner')}}</h5><br>
                    <div class="row">
                        <div class="col-md-6">
                            @forelse ($storefront_images as $key=> $item)
                                @if ($item->title=='one_column_banner_image')
                                    @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                        <img src="{{asset('public/'.$item->image)}}" id="storefrontOneColumnBannerImage" height="100px" width="100px">
                                    @else
                                        <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner" id="storefrontOneColumnBannerImage">
                                    @endif
                                    @break
                                @elseif ($key == ($total_storefront_images-1))
                                    <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner" id="storefrontOneColumnBannerImage">
                                @endif
                            @empty
                                <img src="https://dummyimage.com/100x100/cccccc/666666&text=Banner" id="storefrontOneColumnBannerImage">
                            @endforelse
                            <br><br>
                            <input type="file" name="storefront_one_column_banner_image" class="form-control" onchange="showImage(this,'storefrontOneColumnBannerImage')">
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label"><b>{{__('file.Call to Action URL')}}</b></label>
                            <input type="text" name="storefront_one_column_banner_call_to_action_url" placeholder="@lang('file.Type URL')" class="form-control"
                                value="{{$setting[49]->plain_value}}">
                            <br><br>
                            <input type="checkbox" class="m-1" @if($setting[50]->plain_value==1) checked @endif value="1" name="storefront_one_column_banner_open_in_new_window">
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
