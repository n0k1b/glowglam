<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Paystack')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="paystackSubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="status" {{env('PAYSTACK_STATUS')=="1" ? 'checked':''}} class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Paystack')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Paystack Public Key')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input type="text" name="paystack_public_key" value="{{env('PAYSTACK_PUBLIC_KEY')}}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Paystack Secret Key')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="paystack_secret_key" class="form-control" value="{{env('PAYSTACK_SECRET_KEY')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Merchant Email')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="merchant_email" class="form-control" value="{{env('MERCHANT_EMAIL')}}">
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


