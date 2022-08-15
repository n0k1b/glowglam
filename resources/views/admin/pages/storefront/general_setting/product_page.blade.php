<div class="card">
    <h3 class="card-header"><b>{{__('Product Page')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="productPageSubmit">
                    @csrf

                    <!-- Product Page Banner -->
                    <!-- DB_ROW_ID-39:  => setting[38] -->
                   <h5>{{__('Product Page Banner')}}</h5><br>
                   @forelse ($storefront_images as $key=> $item)
                        @if ($item->title=='product_page_banner')
                            @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                <img src="{{asset('public/'.$item->image)}}" id="storefrontProductPageImage" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Product-Page" id="storefrontProductPageImage">
                            @endif
                            @break
                        @elseif ($key == ($total_storefront_images-1))
                            <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Product-Page" id="storefrontProductPageImage">
                        @endif
                    @empty
                        <img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Product-Page" id="storefrontProductPageImage">
                    @endforelse
                   <br><br>
                   <input type="file" name="storefront_product_page_image" class="form-control" onchange="showImage(this,'storefrontProductPageImage')">
                   <br><br>


                   <!-- Call to Action URL -->
                   <!-- DB_ROW_ID-40:  => setting[39] -->
                   <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('Call to Action URL')}}</b></label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input type="text" name="storefront_call_action_url" placeholder="Type Copyright Text" class="form-control"
                                value="{{$setting[39]->plain_value}}">
                            </div>
                        </div>
                    </div>
                    <br>


                    <!-- Open in new window -->
                    <!-- DB_ROW_ID-41:  => setting[40] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('Open in new window')}}</b></label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input type="checkbox" @if($setting[40]->plain_value==1) checked @endif value="1" name="storefront_open_new_window"  class="form-check-input">
                                <label class="form-check-label" for="exampleCheck1">{{__('Enable')}}</label>
                              </div>
                        </div>
                    </div>
                    <br>





                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>
