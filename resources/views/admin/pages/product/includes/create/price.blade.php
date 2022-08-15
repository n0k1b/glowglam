    <div class="card">
        <h4 class="card-header"><b>@lang('file.Price')</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Price')}} <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" id="inputEmail3" placeholder="Type Product Price" value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="special_price" id="specialPrice" class="form-control @error('special_price') is-invalid @enderror" id="inputEmail3" placeholder="Type Special Price" value="{{ old('special_price') }}">
                            @error('special_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price Type')}}</b></label>
                        <div class="col-sm-8">
                            <select name="special_price_type" class="form-control selectpicker" title='{{__('Select Price Type')}}'>
                                <option value="Fixed">{{__('file.Fixed')}}</option>
                                <option value="Parcent">{{__('file.Parcent')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price Start')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="special_price_start" id="specialPriceStart" class="form-control datepicker  @error('special_price_start') is-invalid @enderror" value="{{ old('special_price_start') }}">
                            @error('special_price_start')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Special Price End')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="special_price_end" id="specialPriceEnd" class="form-control @error('special_price_end') is-invalid @enderror"  value="{{ old('special_price_end') }}">
                            @error('special_price_end')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
