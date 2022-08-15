<div class="card">
    <h3 class="card-header p-2"><b>{{__('file.Flash Sale & Vertical Products')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="flashSaleAndVerticalProducts">
                    @csrf

                    <!-- DB_ROW_ID-:131  => setting[130] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('file.Section Status')}}</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" @if($setting[130]->plain_value==1) checked @endif value="1" name="storefront_flash_sale_and_vertical_products_section_enabled" class="form-check-input">
                                <label class="form-check-label" for="exampleCheck1">{{__('file.Flash Sale & Vertical Products')}}</label>
                            </div>
                        </div>
                    </div>

                    <!-- Flash Sale -->
                    <!-- DB_ROW_ID-:  => setting[] -->
                    <h4 class="mt-3 text-bold">{{__('file.Flash Sale')}}</h4><br>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>{{__('file.Title')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="storefront_flash_sale_title" class="form-control" placeholder="{{__('file.Title')}}" value="{{$setting[131]->settingTranslation->value ?? null}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>{{__('file.Active Campaign')}}</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_flash_sale_active_campaign_flash_id" id="" class="form-control">
                                @forelse ($flash_sales as $item)
                                    <option value="{{$item->id}}">{{$item->flashSaleTranslation->campaign_name ?? null}}</option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                    <!-- Vertical Products 1  -->
                    @include('admin.pages.storefront.home_page_section.flash_sale_vertical_product.tab1')

                    <!-- Vertical Products 2  -->
                    @include('admin.pages.storefront.home_page_section.flash_sale_vertical_product.tab2')

                    <!-- Vertical Products 3  -->
                    @include('admin.pages.storefront.home_page_section.flash_sale_vertical_product.tab3')


                    <!-- DB_ROW_ID-:  => setting[] -->
                    <div class="form-group row mt-5">
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

<script type="text/javascript">

        //Vertical Product 1
        $('#storefrontVerticalProduct_1_Type').change(function() {
            console.log('ok');
            var storefrontVerticalProduct_1_Type = $('#storefrontVerticalProduct_1_Type').val();
            if (storefrontVerticalProduct_1_Type=='category_products') {
                $('#verticalCategoryFeild_1').show();
                $('#verticalProductTabsField_1').empty();
            }
            else if (storefrontVerticalProduct_1_Type=='custom_products') {
                $('#verticalCategoryFeild_1').hide();
                data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
                data += '<div class="col-sm-8">';
                data += '<input type="text" name="storefront_vertical_product_1_products" class="form-control" placeholder="Type Product">';
                data += '</div>';
                $('#verticalProductTabsField_1').html(data);
            }
            else if (storefrontVerticalProduct_1_Type=='latest_products' || storefrontVerticalProduct_1_Type=='recently_viewed_products') {
                $('#verticalCategoryFeild_1').hide();
                data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
                data += '<div class="col-sm-8">';
                data += '<input type="number" min="0" name="storefront_vertical_product_1_products_limit" class="form-control" placeholder="Type Limit">';
                data += '</div>';
                $('#verticalProductTabsField_1').html(data);
            }
        });

        //Vertical Product 2
        $('#storefrontVerticalProduct_2_Type').change(function() {
            console.log('ok');
            var storefrontVerticalProduct_2_Type = $('#storefrontVerticalProduct_2_Type').val();
            if (storefrontVerticalProduct_2_Type=='category_products') {
                $('#verticalCategoryFeild_2').show();
                $('#verticalProductTabsField_2').empty();
            }
            else if (storefrontVerticalProduct_2_Type=='custom_products') {
                $('#verticalCategoryFeild_2').hide();
                data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
                data += '<div class="col-sm-8">';
                data += '<input type="text" name="storefront_vertical_product_2_products" class="form-control" placeholder="Type Product">';
                data += '</div>';
                $('#verticalProductTabsField_2').html(data);
            }
            else if (storefrontVerticalProduct_2_Type=='latest_products' || storefrontVerticalProduct_2_Type=='recently_viewed_products') {
                $('#verticalCategoryFeild_2').hide();
                data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
                data += '<div class="col-sm-8">';
                data += '<input type="number" min="0" name="storefront_vertical_product_2_products_limit" class="form-control" placeholder="Type Limit">';
                data += '</div>';
                $('#verticalProductTabsField_2').html(data);
            }
        });

        //Vertical Product 3
        $('#storefrontVerticalProduct_3_Type').change(function() {
            console.log('ok');
            var storefrontVerticalProduct_3_Type = $('#storefrontVerticalProduct_3_Type').val();
            if (storefrontVerticalProduct_3_Type=='category_products') {
                $('#verticalCategoryFeild_3').show();
                $('#verticalProductTabsField_3').empty();
            }
            else if (storefrontVerticalProduct_3_Type=='custom_products') {
                $('#verticalCategoryFeild_3').hide();
                data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
                data += '<div class="col-sm-8">';
                data += '<input type="text" name="storefront_vertical_product_3_products" class="form-control" placeholder="Type Product">';
                data += '</div>';
                $('#verticalProductTabsField_3').html(data);
            }
            else if (storefrontVerticalProduct_3_Type=='latest_products' || storefrontVerticalProduct_3_Type=='recently_viewed_products') {
                $('#verticalCategoryFeild_3').hide();
                data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
                data += '<div class="col-sm-8">';
                data += '<input type="number" min="0" name="storefront_vertical_product_3_products_limit" class="form-control" placeholder="Type Limit">';
                data += '</div>';
                $('#verticalProductTabsField_3').html(data);
            }
        });
</script>
