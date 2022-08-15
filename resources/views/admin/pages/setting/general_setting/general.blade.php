<div class="card">
    <h4 class="card-header p-3"><b>@lang('file.General')</b></h4>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="generalSubmit" method="POST">
                    @csrf


                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Supported Countries') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <select name="supported_countries[]" id="supportedCountries" class="form-control selectpicker" multiple="multiple" data-live-search="true" title='{{__('file.Select Conutry')}}'>
                                @foreach ($countries as $country)
                                       <option value="{{$country->country_name}}"
                                            @empty(!$selected_countries)
                                                @forelse ($selected_countries as $value)
                                                    @if($country->country_name == $value)
                                                        selected
                                                    @endif
                                                @empty
                                                @endforelse
                                            @endempty> {{$country->country_name}}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Default Country') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <select name="default_country" id="defaultCountry" class="form-control selectpicker" data-live-search="true" title='{{__('file.Select Conutry')}}'>
                                @foreach ($countries as $country)
                                    <option value="{{$country->country_name}}" @empty(!$setting_general)  {{($country->country_name == $setting_general->default_country) ? "selected" : ''}} @endempty>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Default Timezone') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <select name="default_timezone" id="defaultTimezone" class="form-control selectpicker" data-live-search="true" title='{{__('file.Select Timezone')}}'>
                                @foreach($zones_array as $zone)
                                    <option value="{{$zone['zone']}}" @empty(!$setting_general) {{($zone['zone'] == $setting_general->default_timezone) ? "selected" : ''}} @endempty>{{$zone['diff_from_GMT'] . ' - ' . $zone['zone']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Customer Role') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <select name="customer_role" id="customerRole" class="form-control" title='{{__('file.Select Role')}}'>
                                <option value="customer" @empty(!$setting_general) {{$setting_general->customer_role=="customer" ? "selected" : ''}} @endempty>Customer</option>
                                <option value="admin" @empty(!$setting_general) {{$setting_general->customer_role=="admin" ? "selected" : ''}} @endempty>Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label ml-2"><b>@lang('file.Number Format Type')</b> <br><i>(Ex: 1.00, 1.000, 1.0000)</i> </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="number_format_type"  id="number_format_type" value="2" @if($setting_general && $setting_general->number_format_type!=NULL && $setting_general->number_format_type=="2") checked @endif>
                            <label class="form-check-label" for="number_format_type">
                                @lang('file.2')
                            </label>
                        </div>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="number_format_type" id="number_format_type" value="3" @if($setting_general && $setting_general->number_format_type!=NULL && $setting_general->number_format_type=="3") checked @endif>
                            <label class="form-check-label" for="exampleRadios1">
                                @lang('file.3')
                            </label>
                        </div>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="number_format_type" id="number_format_type" value="4" @if($setting_general && $setting_general->number_format_type!=NULL && $setting_general->number_format_type=="4") checked @endif>
                            <label class="form-check-label" for="exampleRadios1">
                                @lang('file.4')
                            </label>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Reviews & Ratings')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" @empty(!$setting_general) {{$setting_general->reviews_and_ratings =="1" ? "checked" : ''}} @endempty name="reviews_and_ratings" id="reviewsAndRatings" class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Allow customers to give reviews & ratings')</label>
                            </div>
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
