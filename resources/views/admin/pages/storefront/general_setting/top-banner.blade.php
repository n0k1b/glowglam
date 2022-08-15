<div class="card">
    <h3 class="card-header"><b>{{__('file.Top Banner')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="topbarBannerSubmit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Topbar Image -->
                    <h5 class="text-bold">@lang('file.Topbar Logo')</h5><br>
                    @forelse ($storefront_images as $key => $item)
                        @if ($item->title=='topbar_logo')
                            @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                <img src="{{asset('public/'.$item->image)}}" id="topbar_logo" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Favicon-Logo" id="topbar_logo">
                            @endif
                            @break
                        @elseif ($key == ($total_storefront_images-1))
                            <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Favicon-Logo" id="topbar_logo" height="100px" width="100px">
                        @endif
                    @empty
                        <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Favicon-Logo" id="topbar_logo" height="100px" width="100px">
                    @endforelse
                    <br><br>
                    <input type="file"   name="image_topbar_logo" id="topbar_logo" class="form-control" onchange="showImage(this,'topbar_logo')">
                    <input type="hidden" name="title_topbar_logo" value="topbar_logo">
                    <br><br>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Section Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" {{env('TOPBAR_BANNER_ENABLED')!=null ? 'checked':''}} name="storefront_topbar_banner_enabled" class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable Topbar Banner')</label>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
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
