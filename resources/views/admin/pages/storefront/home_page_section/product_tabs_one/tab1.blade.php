                    <h4 class="mt-3 text-bold">{{__('file.Tab - 1')}}</h4><br>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Title')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="storefront_product_tabs_1_section_tab_1_title" class="form-control" placeholder="@lang('file.Title')"
                            @forelse ($setting[82]->settingTranslations as $key => $item)
                                @if ($item->locale==$locale)
                                    value="{{$item->value}}" @break
                                @elseif($item->locale=='en')
                                    value="{{$item->value}}" @break
                                @endif
                            @empty
                            @endforelse >
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Type')</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_product_tabs_1_section_tab_1_product_type" id="storefrontProductTabs_1_SectionTab_1_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="">@lang('file.-- Select Type --')</option>
                                <option value="{{__('category_products')}}" selected>{{__('Category Products')}}</option>
                            </select>
                        </div>
                    </div>
                    @if ((!empty($setting[83]->plain_value)) && ($setting[83]->plain_value == 'category_products'))
                        <div class="form-group row" id="categoryFeild_1">
                            <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
                            <div class="col-sm-8">
                                <select name="storefront_product_tabs_1_section_tab_1_category_id" id="storefrontProductTabs_1_SectionTab_1_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                                    @foreach ($categories as $item)
                                        @forelse ($item->categoryTranslation as $key => $value)
                                            @if ($value->local==$locale)
                                                <option value="{{$item->id}}" {{ $setting[84]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                                            @elseif($value->local=='en')
                                                <option value="{{$item->id}}" {{ $setting[84]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                                            @endif
                                        @empty
                                            <option value="">{{__('NULL')}}</option>
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="form-group row" id="categoryFeild_1">
                            <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
                            <div class="col-sm-8">
                                <select name="storefront_product_tabs_1_section_tab_1_category_id" id="storefrontProductTabs_1_SectionTab_1_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                                    @foreach ($categories as $item)
                                        @forelse ($item->categoryTranslation as $key => $value)
                                            @if ($value->local==$locale)
                                                <option value="{{$item->id}}" {{ $setting[84]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                                            @elseif($value->local=='en')
                                                <option value="{{$item->id}}" {{ $setting[84]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                                            @endif
                                        @empty
                                            <option value="">{{__('NULL')}}</option>
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row" id="productTabsField1">
                        @if ((!empty($setting[83]->plain_value)) && ($setting[83]->plain_value == 'custom_products'))
                            <label class="col-sm-4 col-form-label"><b> {{__('file.Products')}}</b></label>
                            <div class="col-sm-8">
                                <input type="text" name="storefront_product_tabs_1_section_tab_1_products" value="{{$setting[85]->plain_value}}" class="form-control">
                            </div>
                        @elseif((!empty($setting[83]->plain_value)) && (($setting[83]->plain_value == 'latest_products') || ($setting[83]->plain_value == 'recently_viewed_products')))
                            <label class="col-sm-4 col-form-label"><b> {{__('file.Products Limit')}}</b></label>
                            <div class="col-sm-8">
                                <input type="text" name="storefront_product_tabs_1_section_tab_1_products_limit" value="{{$setting[86]->plain_value}}" class="form-control">
                            </div>
                        @endif
                    </div>
