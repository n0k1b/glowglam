<div class="card">
    <h3 class="card-header p-2"><b>{{__('file.Product Tabs')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="productTabsOneSubmit">
                    @csrf

                    <!-- DB_ROW_ID-80:  => setting[81] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Section Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" @if($setting[81]->plain_value==1) checked @endif value="1" name="storefront_product_tabs_1_section_enabled" class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable product tabs one section')</label>
                            </div>
                        </div>
                    </div>



                     <!-- Tab-1 -->
                     @include('admin.pages.storefront.home_page_section.product_tabs_one.tab1')


                    <!-- Tab-2 -->
                    @include('admin.pages.storefront.home_page_section.product_tabs_one.tab2')


                    <!-- Tab-3 -->
                    @include('admin.pages.storefront.home_page_section.product_tabs_one.tab3')


                    <!-- Tab-3 -->
                    @include('admin.pages.storefront.home_page_section.product_tabs_one.tab4')


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

<script>
    // $('#productField1').empty();

    $(document).ready(function(){
        var check_type1 = @json($setting[83]->plain_value); //tab1
        var check_type2 = @json($setting[88]->plain_value); //tab2
        var check_type3 = @json($setting[93]->plain_value); //tab3
        var check_type4 = @json($setting[98]->plain_value); //tab4
        if (check_type1!='category_products') {
            $('#categoryFeild_1').hide();
        }
        if (check_type2!='category_products') {
            $('#categoryFeild_2').hide();
        }
        if (check_type3!='category_products') {
            $('#categoryFeild_3').hide();
        }
        if (check_type4!='category_products') {
            $('#categoryFeild_4').hide();
        }
    });

    //tab1
    $('#storefrontProductTabs_1_SectionTab_1_ProductType').change(function() {
        var storefrontProductTabs_1_SectionTab_1_ProductType = $('#storefrontProductTabs_1_SectionTab_1_ProductType').val();
        if (storefrontProductTabs_1_SectionTab_1_ProductType=='category_products') {
            $('#productTabsField1').empty();
            $('#categoryFeild_1').show();
        }
        else if (storefrontProductTabs_1_SectionTab_1_ProductType=='custom_products') {
            $('#categoryFeild_1').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="text" name="storefront_product_tabs_1_section_tab_1_products" class="form-control" placeholder="Type Product">';
            data += '</div>';
            $('#productTabsField1').html(data);
        }
        else if (storefrontProductTabs_1_SectionTab_1_ProductType=='latest_products' || storefrontProductTabs_1_SectionTab_1_ProductType=='recently_viewed_products') {
            $('#categoryFeild_1').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="number" min="0" name="storefront_product_tabs_1_section_tab_1_products_limit" class="form-control" placeholder="Type Limit">';
            data += '</div>';
            $('#productTabsField1').html(data);
        }
    });

    //tab2
    $('#storefrontProductTabs_1_SectionTab_2_ProductType').change(function() {
        var storefrontProductTabs_1_SectionTab_2_ProductType = $('#storefrontProductTabs_1_SectionTab_2_ProductType').val();
        if (storefrontProductTabs_1_SectionTab_2_ProductType=='category_products') {
            $('#productTabsField_2').empty();
            $('#categoryFeild_2').show();
        }
        else if (storefrontProductTabs_1_SectionTab_2_ProductType=='custom_products') {
            $('#categoryFeild_2').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="text" name="storefront_product_tabs_1_section_tab_2_products" class="form-control" placeholder="Type Product">';
            data += '</div>';
            $('#productTabsField_2').html(data);
        }
        else if (storefrontProductTabs_1_SectionTab_2_ProductType=='latest_products' || storefrontProductTabs_1_SectionTab_2_ProductType=='recently_viewed_products') {
            $('#categoryFeild_2').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="number" min="0" name="storefront_product_tabs_1_section_tab_2_products_limit" class="form-control" placeholder="Type Limit">';
            data += '</div>';
            $('#productTabsField_2').html(data);
        }
    });

    //tab3
    $('#storefrontProductTabs_1_SectionTab_3_ProductType').change(function() {
        var storefrontProductTabs_1_SectionTab_3_ProductType = $('#storefrontProductTabs_1_SectionTab_3_ProductType').val();
        if (storefrontProductTabs_1_SectionTab_3_ProductType=='category_products') {
            $('#productTabsField_3').empty();
            $('#categoryFeild_3').show();
        }
        else if (storefrontProductTabs_1_SectionTab_3_ProductType=='custom_products') {
            $('#categoryFeild_3').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="text" name="storefront_product_tabs_1_section_tab_3_products" class="form-control" placeholder="Type Product">';
            data += '</div>';
            $('#productTabsField_3').html(data);
        }
        else if (storefrontProductTabs_1_SectionTab_3_ProductType=='latest_products' || storefrontProductTabs_1_SectionTab_3_ProductType=='recently_viewed_products') {
            $('#categoryFeild_3').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="number" min="0" name="storefront_product_tabs_1_section_tab_3_products_limit" class="form-control" placeholder="Type Limit">';
            data += '</div>';
            $('#productTabsField_3').html(data);
        }
    });


    //tab4
    $('#storefrontProductTabs_1_SectionTab_4_ProductType').change(function() {
        var storefrontProductTabs_1_SectionTab_4_ProductType = $('#storefrontProductTabs_1_SectionTab_4_ProductType').val();
        if (storefrontProductTabs_1_SectionTab_4_ProductType=='category_products') {
            $('#productTabsField_4').empty();
            $('#categoryFeild_4').show();
        }
        else if (storefrontProductTabs_1_SectionTab_4_ProductType=='custom_products') {
            $('#categoryFeild_4').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="text" name="storefront_product_tabs_1_section_tab_4_products" class="form-control" placeholder="Type Product">';
            data += '</div>';
            $('#productTabsField_4').html(data);
        }
        else if (storefrontProductTabs_1_SectionTab_4_ProductType=='latest_products' || storefrontProductTabs_1_SectionTab_4_ProductType=='recently_viewed_products') {
            $('#categoryFeild_4').hide();
            data = '<label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>';
            data += '<div class="col-sm-8">';
            data += '<input type="number" min="0" name="storefront_product_tabs_1_section_tab_4_products_limit" class="form-control" placeholder="Type Limit">';
            data += '</div>';
            $('#productTabsField_4').html(data);
        }
    });
</script>



{{-- 01877610063 --}}
