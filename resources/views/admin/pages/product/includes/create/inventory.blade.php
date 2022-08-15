    <div class="card">
        <h4 class="card-header"><b>{{__('file.Inventory')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.SKU')}} <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" id="inputEmail3" placeholder="Type SKU" value="{{ old('sku') }}">
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Inventroy Management')}}</b></label>
                        <div class="col-sm-8">
                            <select class="form-control selectpicker" name="manage_stock" id="manageStock">
                                <option value="0" selected>{{__("file.Don't Track Inventory")}}</option>
                                <option value="1">{{__('file.Track Inventory')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row" id="quantityField">

                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Stock Availibility')}}</b></label>
                        <div class="col-sm-8">
                            <select name="in_stock" class="form-control selectpicker">
                                <option value="1" selected>{{__("file.In Stock")}}</option>
                                <option value="0">{{__('file.Out Stock')}}</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
