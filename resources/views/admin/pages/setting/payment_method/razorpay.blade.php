<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Razorpay')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="razorpaySubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="status" {{env('RAZORPAY_STATUS')=="1" ? 'checked':''}} class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Razorpay')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Razorpay Key')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input type="text" name="razorpay_key" value="{{env('RAZORPAY_KEY')}}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Razorpay Secret')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="razorpay_secret" class="form-control" value="{{env('RAZORPAY_SECRET')}}">
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


