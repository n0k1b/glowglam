<!--Create Modal -->
<div class="modal fade" id="createModalForm" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel"><b>@lang('file.Add New Tax')</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="alertMessage" role="alert"></div>

        <div class="modal-body">
            <form method="POST" id="submitForm" action="{{route('admin.tax.store')}}">
                @csrf

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Tax Class') &nbsp;<span class="text-danger">*</span></b></label>
                            <input type="text" class="col-md-8 form-control" name="tax_class" placeholder="@lang('file.Tax Class')">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Based On') &nbsp;<span class="text-danger">*</span></b></label>
                            <select name="based_on" class="col-md-8 form-control selectpicker">
                                <option value="">{{__('-- Select Type --')}}</option>
                                <option value="shipping_address">@lang('file.Shipping Address')</option>
                                <option value="billing_address">@lang('file.Billing Address')</option>
                                <option value="store_address">@lang('file.Store address')</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Tax Name') &nbsp;<span class="text-danger">*</span></b></label>
                            <input type="text" class="col-md-8 form-control" name="tax_name" placeholder="@lang('file.Tax Name')">
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Country') &nbsp;<span class="text-danger">*</span></b></label>
                            <select name="country" class="col-md-8 form-control selectpicker" data-live-search="true" title='{{__('file.Select Conutry')}}'>
                                @foreach ($countries as $country)
                                    <option value="{{$country->country_name}}">{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.State')</b></label>
                            <input type="text" class="col-md-8 form-control" name="state" placeholder="@lang('file.State')">
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.City')</b></label>
                            <input type="text" class="col-md-8 form-control" name="city" placeholder="@lang('file.City')">
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Zip')</b></label>
                            <input type="text" class="col-md-8 form-control" name="zip" placeholder="@lang('file.Zip')">
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Rate')</b></label>
                            <input type="text" class="col-md-8 form-control" name="rate" placeholder="@lang('file.Rate')">
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Status')</b></label>
                            <div class="col-md-8 form-check">
                                <input class="form-check-input" checked type="checkbox" name="is_active" value="1" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">@lang('file.Enable the Tax')</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <div id="alertMessageBox">
                            <div id="alertMessage" class="text-light"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary" id="save-button">@lang('file.Save')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('file.Close')</button>
                    </div>
                </div>

            </form>
        </div>
      </div>
    </div>
  </div>
