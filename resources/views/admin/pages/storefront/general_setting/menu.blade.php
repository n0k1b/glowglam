<div class="card">
    <h4 class="card-header"><b>@lang('file.Menus')</b></h4>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="menuSubmit" action="{{route('admin.storefront.menu.store')}}" method="POST">
                    @csrf

                    <!-- setting[8] => DB_ROW_ID-9: storefront_primary_menu -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Primary Menu')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_primary_menu" id="storefront_primary_menu" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Primary Menu')}}'>
                                @foreach ($menus as $item)
                                    @forelse ($item->menuTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[8]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[8]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @endif
                                    @empty
                                    <option value="">{{__('NULL')}}</option>
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- setting[9] => DB_ROW_ID-10: storefront_category_menu -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Category Menu')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_category_menu" id="storefront_category_menu" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category Menu')}}'>
                                @foreach ($menus as $item)
                                    @forelse ($item->menuTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[9]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[9]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @endif
                                    @empty
                                    <option value="">{{__('NULL')}}</option>
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- setting[10] => DB_ROW_ID-11: storefront_footer_menu_title_one -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Footer Menu Title One')</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="storefront_footer_menu_title_one" id="storefront_footer_menu_title_one"  placeholder="@lang('file.Footer Menu Title One')"
                            @forelse ($setting[10]->settingTranslations as $key => $item)
                                @if ($item->locale==$locale)
                                    value="{{$item->value}}" @break
                                @elseif($item->locale=='en')
                                    value="{{$item->value}}" @break
                                @endif
                            @empty
                            @endforelse >
                        </div>
                    </div>

                    <!-- setting[11] => DB_ROW_ID-12: storefront_footer_menu_one -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Footer Menu One')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_footer_menu_one" id="storefront_footer_menu_one" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Footer Menu')}}'>
                                @foreach ($menus as $item)
                                    @forelse ($item->menuTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[11]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[11]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @endif
                                    @empty
                                        <option value="">{{__('NULL')}}</option>
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- setting[12] => DB_ROW_ID-13: storefront_footer_menu_title_two -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Footer Menu Title Two')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="storefront_footer_menu_title_two" id="storefront_footer_menu_title_two" class="form-control"  placeholder="@lang('file.Type Footer Menu Title')"
                            @forelse ($setting[12]->settingTranslations as $key => $item)
                                @if ($item->locale==$locale)
                                    value="{{$item->value}}" @break
                                @elseif($item->locale=='en')
                                    value="{{$item->value}}" @break
                                @endif
                            @empty
                            @endforelse >
                        </div>
                    </div>

                    <!-- setting[13] => DB_ROW_ID-14: storefront_footer_menu_two -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Footer Menu Two')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_footer_menu_two" id="storefront_footer_menu_two" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Footer Menu')}}'>
                                @foreach ($menus as $item)
                                    @forelse ($item->menuTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[13]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[13]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @endif
                                    @empty
                                        <option value="">{{__('NULL')}}</option>
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Footer Menu Three -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Footer Menu Title Three')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="storefront_footer_menu_title_three" id="storefront_footer_menu_title_three" class="form-control"  placeholder="@lang('file.Type Footer Menu Title')"
                            @forelse ($setting[154]->settingTranslations as $key => $item)
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
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Footer Menu Three')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_footer_menu_three" id="storefront_footer_menu_three" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Footer Three')}}'>
                                @foreach ($menus as $item)
                                    @forelse ($item->menuTranslations as $key => $value)
                                        @if ($value->locale==$locale)
                                            <option value="{{$item->id}}" {{ $item->id == $setting[155]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @elseif($value->locale=='en')
                                            <option value="{{$item->id}}" {{ $item->id == $setting[155]->plain_value ? 'selected="selected"' : '' }}>{{$value->menu_name}}</option> @break
                                        @endif
                                    @empty
                                        <option value="">{{__('NULL')}}</option>
                                    @endforelse
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Submit -->
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
