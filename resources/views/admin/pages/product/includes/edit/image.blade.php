<div class="tab-pane fade show" aria-labelledby="product-images" id="images" role="tabpanel">
    <div class="card">
        <h4 class="card-header"><b>{{__('file.Images')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Basic Image')}} </b></label>
                        <div class="col-sm-8">
                            <input type="file" name="base_image" id="baseImage" class="form-control @error('base_image') is-invalid @enderror" onchange="showImage(this,'item_photo')">
                            @if(($product->baseImage!==null) && ($product->baseImage->type=='base'))
                                @if(isset($product->baseImage->image) && Illuminate\Support\Facades\File::exists(public_path($product->baseImage->image)))
                                    <img id="item_photo" src="{{asset('public/'.$product->baseImage->image)}}"  height="100px" width="100px">
                                @else
                                    <img src="https://dummyimage.com/150x150/e5e8ec/e5e8ec&text=Product" width="150"> &nbsp; &nbsp;
                                @endif
                            @else
                                <img src="https://dummyimage.com/150x150/e5e8ec/e5e8ec&text=Product" width="150">
                                    &nbsp; &nbsp;
                            @endif
                            @error('base_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Additional Images')}} </b></label>
                        <div class="col-sm-8">
                            <input type="file" name="additional_images[]" multiple id="multipleImages" class="form-control @error('additional_images') is-invalid @enderror">
                            @if($product->additionalImage!==null)
                                @foreach ($product->additionalImage as $item)
                                    @if(isset($item->image) && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                        <img src="{{asset('public/'.$item->image)}}"  height="100px" width="100px">
                                    @else
                                        <img src="https://dummyimage.com/150x150/e5e8ec/e5e8ec&text=Product" width="150"> &nbsp; &nbsp;
                                    @endif
                                @endforeach
                            @else
                                <img src="https://dummyimage.com/150x150/e5e8ec/e5e8ec&text=Product" width="150"> &nbsp; &nbsp;
                            @endif
                            @error('additional_images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
