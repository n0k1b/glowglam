<h4 class="mt-3 text-bold">{{__('file.Vertical Products 1')}}</h4><br>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>{{__('file.Title')}}</b></label>
    <div class="col-sm-8">
        <input type="text" name="storefront_vertical_product_1_title" class="form-control" placeholder="{{__('file.Title')}}" value="{{$setting[133]->settingTranslation->value ?? null}}" >
    </div>
</div>
<div class="form-group row d-none">
    <label class="col-sm-4 col-form-label"><b>@lang('file.Type')</b></label>
    <div class="col-sm-8">
        <select name="storefront_vertical_product_1_type" id="storefrontVerticalProduct_1_Type" class="form-control" data-live-search="true" data-live-search-style="begins">
            <option value="">@lang('file.-- Select Type --')</option>
            <option value="{{__('category_products')}}" selected  {{ $setting[134]->plain_value == 'category_products' ? 'selected="selected"' : '' }}>{{__('Category Products')}}</option>
            <option value="{{__('custom_products')}}" {{ $setting[134]->plain_value == 'custom_products' ? 'selected="selected"' : '' }}>{{__('Custom Products')}}</option>
            <option value="{{__('latest_products')}}" {{ $setting[134]->plain_value == 'latest_products' ? 'selected="selected"' : '' }}>{{__('Latest Products')}}</option>
            <option value="{{__('recently_viewed_products')}}" {{ $setting[134]->plain_value == 'recently_viewed_products' ? 'selected="selected"' : '' }}>{{__('Recently Viewed Products')}}</option>
        </select>
    </div>
</div>
@if ((!empty($setting[134]->plain_value)) && ($setting[134]->plain_value == 'category_products'))
    <div class="form-group row" id="verticalCategoryFeild_1">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <select name="storefront_vertical_product_1_category_id" id="storefrontVerticalProduct_1_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                <option value="NULL">@lang('file.NULL')</option>
                @foreach ($categories as $item)
                    <option value="{{$item->id}}" {{ $setting[135]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$item->catTranslation->category_name ?? null}}</option>
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row" id="verticalCategoryFeild_1">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <select name="storefront_vertical_product_1_category_id" id="storefrontVerticalProduct_1_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                <option value="NULL">@lang('file.NULL')</option>
                @foreach ($categories as $item)
                    <option value="{{$item->id}}" {{ $setting[135]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$item->catTranslation->category_name ?? null}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row" id="verticalProductTabsField_1">
    @if ((!empty($setting[134]->plain_value)) && ($setting[134]->plain_value == 'custom_products'))
        <label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>
        <div class="col-sm-8">
            <input type="text" name="storefront_vertical_product_1_products" value="{{$setting[136]->plain_value}}" class="form-control">
        </div>
    @elseif((!empty($setting[134]->plain_value)) && (($setting[134]->plain_value == 'latest_products') || ($setting[134]->plain_value == 'recently_viewed_products')))
        <label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>
        <div class="col-sm-8">
            <input type="text" name="storefront_vertical_product_1_products_limit" value="{{$setting[137]->plain_value}}" class="form-control">
        </div>
    @endif
</div>
