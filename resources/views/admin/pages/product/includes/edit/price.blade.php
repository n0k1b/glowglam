<div class="tab-pane fade show" aria-labelledby="product-price" role="tabpanel" id="price">
    <div class="card">
        <h4 class="card-header"><b>@lang('file.Price')</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Price')}} <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="price" id="price" class="form-control" id="inputEmail3" @if(env('FORMAT_NUMBER')) value="{{number_format((float)$product->price, env('FORMAT_NUMBER'), '.', '')}}" @endif>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="special_price" id="specialPrice" class="form-control" id="inputEmail3" @if(env('FORMAT_NUMBER')) value="{{number_format((float)$product->special_price, env('FORMAT_NUMBER'), '.', '')}}" @endif >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price Type')}}</b></label>
                        <div class="col-sm-8">
                            <select name="special_price_type" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Price Type')}}'>
                                <option value="Fixed" @if($product->special_price_type=='Fixed') selected @endif>{{__('Fixed')}}</option>
                                <option value="Parcent" @if($product->special_price_type=='Parcent') selected @endif>{{__('Parcent')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price Start')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="special_price_start" value="{{$product->special_price_start}}" id="specialPriceStart" class="form-control datepicker">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price End')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="special_price_end" value="{{$product->special_price_end}}" id="specialPriceEnd" class="form-control">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
