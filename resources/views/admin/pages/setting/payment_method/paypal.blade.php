<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Paypal')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="paypalSubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="status" @isset($setting_paypal->status) {{$setting_paypal->status=="1" ? 'checked':''}} @endisset class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable Paypal')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Label') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="label" class="form-control" @isset($setting_paypal->label) value="{{$setting_paypal->label}}" @endisset>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Description') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <textarea name="description" cols="30" rows="10" class="form-control">@isset($setting_paypal->description) {{$setting_paypal->description}} @endisset</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Client ID') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="client_id" class="form-control" @isset($setting_paypal->client_id) value="{{$setting_paypal->client_id}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Secret')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="secret" class="form-control" @isset($setting_paypal->secret) value="{{$setting_paypal->secret}}" @endisset>
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


