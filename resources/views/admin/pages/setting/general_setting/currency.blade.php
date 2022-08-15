<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Currency')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="currencySubmit" action="{{route('admin.setting.currency.store_or_update')}}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>{{__('file.Default Currency')}}<span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <select name="default_currency_code" id="defaultCurrencyCode" class="form-control selectpicker" data-live-search="true" title='{{__('file.Select Currency')}}'>
                                @foreach ($currencies as $currency)
                                    <option value="{{$currency->currency_code}}" @if($setting_currency) {{$currency->currency_code==$setting_currency->default_currency_code ? 'selected' : ''}} @endif> {{$currency->currency_name}} ({{$currency->currency_code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Supported Currencies') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <select name="supported_currencies[]" id="supportedCurrencies" class="form-control selectpicker" multiple="multiple" data-live-search="true" title='{{__('file.Select Currency')}}'>
                                @foreach ($currencies as $currency)
                                       <option value="{{$currency->currency_name}}"
                                            @empty(!$selected_currencies)
                                                @forelse ($selected_currencies as $value)
                                                    @if($currency->currency_name == $value)
                                                        selected
                                                    @endif
                                                @empty
                                                @endforelse
                                            @endempty> {{$currency->currency_name}} ({{$currency->currency_code}})
                                        </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Default Currency Symbol') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="default_currency" @isset($setting_currency->default_currency) value="{{$setting_currency->default_currency}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Currency Format') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="prefix" name="currency_format" @if($setting_currency) {{$setting_currency->currency_format=="prefix" ? 'checked':''}} @endif>
                                <label class="form-check-label">@lang('file.Prefix')</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="suffix" name="currency_format" @if($setting_currency) {{$setting_currency->currency_format=="suffix" ? 'checked':''}} @endif>
                                <label class="form-check-label">@lang('file.Suffix')</label>
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

