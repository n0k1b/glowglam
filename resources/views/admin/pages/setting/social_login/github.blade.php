<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Github')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="githubSubmit">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.App ID')  <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="github_client_id" value="{{env('GITHUB_CLIENT_ID')}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.App Secret') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="github_client_secret" class="form-control" value="{{env('GITHUB_CLIENT_SECRET')}}">
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


