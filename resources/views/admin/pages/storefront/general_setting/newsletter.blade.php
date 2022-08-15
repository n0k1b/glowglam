<div class="card">
    <h3 class="card-header"><b>{{__('file.Newsletter')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="newsletterSubmit">
                    @csrf

                   <!-- Background Image -->
                   <h5>{{__('Background Image')}}</h5><br>
                   @forelse ($storefront_images as $key=> $item)
                        @if ($item->title=='newsletter_background_image')
                            @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                <img src="{{asset('public/'.$item->image)}}" id="storefrontNewsletterImage" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Newslatter" id="storefrontNewsletterImage">
                            @endif
                            @break
                        @elseif ($key == ($total_storefront_images-1))
                            <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Newslatter" id="storefrontNewsletterImage">
                        @endif
                   @empty
                        <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Newslatter" id="storefrontNewsletterImage">
                   @endforelse
                   <br><br>
                   <input type="file" name="storefront_newsletter_image" class="form-control" onchange="showImage(this,'storefrontNewsletterImage')">
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
