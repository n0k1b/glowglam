<div class="card">
    <h3 class="card-header"><b>{{__('file.Logo')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="logoSubmit" action="{{route('admin.storefront.logo.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Favicon Logo -->
                    <h5 class="text-bold">{{__('Favicon')}}</h5><br>
                    @forelse ($storefront_images as $key => $item)
                        @if ($item->title=='favicon_logo')
                            @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                <img src="{{asset('public/'.$item->image)}}" id="fevicon" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Favicon-Logo" id="fevicon">
                            @endif
                            @break
                        @elseif ($key == ($total_storefront_images-1))
                            <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Favicon-Logo" id="fevicon" height="100px" width="100px">
                        @endif
                    @empty
                        <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Favicon-Logo" id="fevicon" height="100px" width="100px">
                    @endforelse
                    <br><br>
                    <input type="file"   name="image_favicon_logo" id="faviconLogo" class="form-control" onchange="showImage(this,'fevicon')">
                    <input type="hidden" name="title_favicon_logo" value="favicon_logo">
                    <br><br>


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



                    <!-- Header Logo -->
                    <h5 class="text-bold">{{__('file.Header Logo')}}</h5><br>
                    @forelse ($storefront_images as $key=> $item)
                        @if ($item->title=='header_logo')
                            @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                <img src="{{asset('public/'.$item->image)}}" id="header_logo" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Header-Logo" id="header_logo">
                            @endif
                            @break
                        @elseif ($key == ($total_storefront_images-1))
                            <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Header-Logo" id="header_logo">
                        @endif
                    @empty
                        <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Header-Logo" id="header_logo" height="100px" width="100px">
                    @endforelse
                    <br><br>
                    <input type="file"   name="image_header_logo" id="headerLogo" class="form-control" onchange="showImage(this,'header_logo')">
                    <input type="hidden" name="title_header_logo" value="header_logo">
                    <br><br>


                    <!-- Mail Logo -->
                    <h5 class="text-bold">{{__('file.Mail Logo')}}</h5><br>
                    @forelse ($storefront_images as $key=> $item)
                        @if ($item->title=='mail_logo')
                            @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                <img src="{{asset('public/'.$item->image)}}" id="mail_logo" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Mail-Logo" id="mail_logo">
                            @endif
                            @break
                        @elseif ($key == ($total_storefront_images-1))
                            <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Mail-Logo" id="mail_logo">
                        @endif
                    @empty
                        <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Mail-Logo" id="mail_logo">
                    @endforelse
                    <br><br>
                    <input type="file"   name="image_mail_logo" id="mail_logo" class="form-control" onchange="showImage(this,'mail_logo')">
                    <input type="hidden" name="title_mail_logo" value="mail_logo">
                    <br><br>

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
