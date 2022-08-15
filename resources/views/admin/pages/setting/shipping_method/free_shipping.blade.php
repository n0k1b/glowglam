<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Free Shipping')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="freeShippingSubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="shipping_status" @isset($setting_free_shipping->shipping_status) {{$setting_free_shipping->shipping_status=="1" ? 'checked':''}} @endisset class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable Free Shipping')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Label') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="label" class="form-control" @isset($setting_free_shipping->label) value="{{$setting_free_shipping->label}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Minimum Amount')</b></label>
                        <div class="col-sm-8">
                            <input type="number" min="0" name="minimum_amount" class="form-control" @isset($setting_free_shipping->minimum_amount) value="{{$setting_free_shipping->minimum_amount}}" @endisset>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>


