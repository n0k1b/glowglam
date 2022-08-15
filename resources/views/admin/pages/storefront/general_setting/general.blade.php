@push('css')
<link rel="preload" href="http://demo.lion-coders.com/soft/sarchholm/css/bootstrap-colorpicker.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link href="http://demo.lion-coders.com/soft/sarchholm/css/bootstrap-colorpicker.css" rel="stylesheet"></noscript>
<style>
    #switcher {list-style: none;margin: 0;padding: 0;overflow: hidden;}#switcher li {float: left;width: 30px;height: 30px;margin: 0 15px 15px 0;border-radius: 3px;}#demo {border-right: 1px solid #d5d5d5;width: 250px;height: 100%;left: -250px;position: fixed;padding: 50px 30px;background-color: #fff;transition: all 0.3s;z-index: 999;}#demo.open {left: 0;}.demo-btn {background-color: #fff;border: 1px solid #d5d5d5;border-left: none;border-bottom-right-radius: 3px;border-top-right-radius: 3px;color: var(--theme-color);font-size: 30px;height: 40px;position: absolute;right: -40px;text-align: center;top: 35%;width: 40px;}
</style>
@endpush
<div class="card">
    <h4 class="card-header"><b>@lang('file.General')</b></h4>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="generalSubmit" action="{{route('admin.storefront.general.store')}}" method="POST">

                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Welcome Text')</b></label>
                        <div class="col-sm-8">
                            <!-- setting[0] => DB_ROW_ID-1: storefront_welcome_text -->
                            <input type="text" name="storefront_welcome_text" id="storefront_welcome_text" class="form-control" id="inputEmail3" placeholder="Type Text"
                            @forelse ($setting[0]->settingTranslations as $key => $item)
                                @if ($item->locale==$locale)
                                    value="{{$item->value}}" @break
                                @elseif($item->locale=='en')
                                    value="{{$item->value}}" @break
                                @endif
                            @empty
                            @endforelse >
                        </div>
                    </div>

                    <!-- setting[1] => DB_ROW_ID-2: storefront_theme_color -->
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Theme Color')</b></label>
                        <div class="col-sm-6">
                            <h6>color Presets</h6>
                            <ul id="switcher">
                                <li class="color-change" data-color="#6449e7" style="background-color:#6449e7"></li>
                                <li class="color-change" data-color="#f51e46" style="background-color:#f51e46"></li>
                                <li class="color-change" data-color="#fa9928" style="background-color:#fa9928"></li>
                                <li class="color-change" data-color="#fd6602" style="background-color:#fd6602"></li>
                                <li class="color-change" data-color="#59b210" style="background-color:#59b210"></li>
                                <li class="color-change" data-color="#ff749f" style="background-color:#ff749f"></li>
                                <li class="color-change" data-color="#f8008c" style="background-color:#f8008c"></li>
                                <li class="color-change" data-color="#6453f7" style="background-color:#6453f7"></li>
                            </ul>

                            <h6>@lang('file.Custom color')</h6>
                            <input type="text" id="color-input-theme" name="storefront_theme_color" class="form-control colorpicker-element" value="{{$setting[1]->plain_value != NULL ? $setting[1]->plain_value : '' }}" data-colorpicker-id="1" data-original-title="" title="">
                        </div>
                    </div>


                    <!-- storefront_navbar_background_color -->
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Nav Background Color')</b></label>
                        <div class="col-sm-6">
                            <h6>color Presets</h6>
                            <ul id="switcher">
                                <li class="color-change" data-color="#6449e7" style="background-color:#6449e7"></li>
                                <li class="color-change" data-color="#f51e46" style="background-color:#f51e46"></li>
                                <li class="color-change" data-color="#fa9928" style="background-color:#fa9928"></li>
                                <li class="color-change" data-color="#fd6602" style="background-color:#fd6602"></li>
                                <li class="color-change" data-color="#59b210" style="background-color:#59b210"></li>
                                <li class="color-change" data-color="#ff749f" style="background-color:#ff749f"></li>
                                <li class="color-change" data-color="#f8008c" style="background-color:#f8008c"></li>
                                <li class="color-change" data-color="#6453f7" style="background-color:#6453f7"></li>
                            </ul>
                            <h6>@lang('file.Custom color')</h6>
                            <input type="text" id="color-input-navbar" name="storefront_navbar_background_color" class="form-control colorpicker-element" value="{{$setting[152]->plain_value != NULL ? $setting[152]->plain_value : '' }}" data-colorpicker-id="1" data-original-title="" title="">
                        </div>
                    </div>

                    <!-- storefront_navbar_background_color -->
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Nav Text Color')</b></label>
                        <div class="col-sm-6">
                            <h6>color Presets</h6>
                            <ul id="switcher">
                                <li class="color-change" data-color="#6449e7" style="background-color:#6449e7"></li>
                                <li class="color-change" data-color="#f51e46" style="background-color:#f51e46"></li>
                                <li class="color-change" data-color="#fa9928" style="background-color:#fa9928"></li>
                                <li class="color-change" data-color="#fd6602" style="background-color:#fd6602"></li>
                                <li class="color-change" data-color="#59b210" style="background-color:#59b210"></li>
                                <li class="color-change" data-color="#ff749f" style="background-color:#ff749f"></li>
                                <li class="color-change" data-color="#f8008c" style="background-color:#f8008c"></li>
                                <li class="color-change" data-color="#6453f7" style="background-color:#6453f7"></li>
                            </ul>
                            <h6>@lang('file.Custom color')</h6>
                            <input type="text" id="color-input-text" name="storefront_nav_text_color" class="form-control colorpicker-element" value="{{$setting[152]->plain_value != NULL ? $setting[152]->plain_value : '' }}" data-colorpicker-id="1" data-original-title="" title="">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Slider Format')</b> <span class="text-danger"></span></label>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="store_front_slider_format" @if($setting[148]->plain_value=='full_width') checked @endif id="slider_format" value="full_width">
                            <label class="form-check-label">{{__('file.Full Width')}}</label>
                        </div>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="store_front_slider_format" @if($setting[148]->plain_value=='half_width') checked @endif id="slider_format" value="half_width">
                            <label class="form-check-label">{{__('file.Half Width')}}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Terms & Condition')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_terms_and_condition_page" id="storefront_terms_and_condition_page" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Terms & Condition')}}'>
                                <option value="{{NULL}}">NONE</option>
                                @foreach ($pages as $item)
                                    @forelse ($item->pageTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[4]->plain_value ? 'selected="selected"' : '' }}>{{$value->page_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[4]->plain_value ? 'selected="selected"' : '' }}>{{$value->page_name}}</option> @break
                                        @endif
                                    @empty
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- setting[5] => DB_ROW_ID-6: storefront_privacy_policy_page -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Privacy Policy Page')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_privacy_policy_page" id="storefront_privacy_policy_page" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Footer Menu')}}'>
                                <option value="{{NULL}}">NONE</option>
                                @foreach ($pages as $item)
                                    @forelse ($item->pageTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[5]->plain_value ? 'selected="selected"' : '' }}>{{$value->page_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[5]->plain_value ? 'selected="selected"' : '' }}>{{$value->page_name}}</option> @break
                                        @endif
                                    @empty
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- setting[6] => DB_ROW_ID-7: storefront_address -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Address')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="storefront_address" id="storefront_address" class="form-control" placeholder="@lang('file.Address')"
                            @forelse ($setting[6]->settingTranslations as $key => $item)
                                @if ($item->locale==$locale)
                                    value="{{$item->value}}" @break
                                @elseif($item->locale=='en')
                                    value="{{$item->value}}" @break
                                @endif
                            @empty
                            @endforelse >
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Shop Page')</b></label>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="checkbox" name="storefront_shop_page_enabled" @if($setting[150]->plain_value==1) checked  @endif value="1">
                            <label class="form-check-label">@lang('file.Enable') @lang('file.Shop Page')</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Brand Page')</b></label>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="checkbox" name="storefront_brand_page_enabled" @if($setting[151]->plain_value==1) checked @endif value="1">
                            <label class="form-check-label">@lang('file.Enable') @lang('file.Brand Page')</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary save">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $('#color-input-theme').colorpicker();
        $('#color-input-navbar').colorpicker();
        $('#color-input-text').colorpicker();
    </script>
@endpush
