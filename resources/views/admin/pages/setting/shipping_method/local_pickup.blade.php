<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Local Pickup')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="localPickupSubmit">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1"  name="pickup_status" class="form-check-input" @isset($setting_local_pickup->pickup_status) {{$setting_local_pickup->pickup_status=="1" ? 'checked':''}} @endisset >
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable Local Pickup')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Label') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="label" class="form-control" @isset($setting_local_pickup->pickup_status) value="{{$setting_local_pickup->pickup_status}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Cost') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="number" min="0" name="cost" class="form-control" @isset($setting_local_pickup->cost) value="{{$setting_local_pickup->cost}}" @endisset>
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


