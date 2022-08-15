<div class="tab-pane fade show" aria-labelledby="product-inventory" id="inventory" role="tabpanel">
    <div class="card">
        <h4 class="card-header"><b>{{__('file.Inventory')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.SKU')}} <span class="text-danger">*</span> </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" id="inputEmail3" value="{{$product->sku}}">
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Inventroy Management')}}</b></label>
                        <div class="col-sm-8">
                            <select class="form-control selectpicker" name="manage_stock" id="manageStock" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Inventory')}}'>
                                <option value="0" @if($product->manage_stock==0) selected @endif>{{__("file.Don't Track Inventory")}}</option>
                                <option value="1" @if($product->manage_stock==1) selected @endif>{{__('file.Track Inventory')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row" id="quantityField">
                        @if ($product->qty)
                            <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Quantity')}} &nbsp;<span class="text-danger">*</span> </b></label>
                            <div class="col-sm-8">
                                <input type="number" min="0" name="qty" id="qty" class="form-control" id="inputEmail3" value="{{$product->qty}}">
                            </div>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Stock Availibility')}}</b></label>
                        <div class="col-sm-8">
                            <select name="in_stock" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Stock')}}'>
                                <option value="1" @if($product->in_stock==1) selected @endif>{{__("file.In Stock")}}</option>
                                <option value="0" @if($product->in_stock==0) selected @endif>{{__('file.Out Stock')}}</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
