<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Google')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="googleSubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="status" @if($setting_google) {{$setting_google->status=="1" ? 'checked':''}} @endif class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable Google Login')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Client ID') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="client_id" class="form-control" @isset($setting_google->client_id) value="{{$setting_google->client_id}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Client Secret') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="client_secret" class="form-control" @isset($setting_google->client_secret) value="{{$setting_google->client_secret}}" @endisset>
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


