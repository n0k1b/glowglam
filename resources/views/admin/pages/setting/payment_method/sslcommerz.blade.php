<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.SSL Commerz')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="sslComerzSubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="status" {{env('SSL_COMMERZ_STATUS')=="1" ? 'checked':''}} class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable SSL Commerz')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Store ID')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input type="text" name="store_id" value="{{env('STORE_ID')}}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Secret')<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_password" class="form-control" value="{{env('STORE_PASSWORD')}}">
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


