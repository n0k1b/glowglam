@extends('admin.main')

@section('title','Admin | Storefront')

@section('admin_content')

<style>
    #accordion .fa{
        margin-right: 0.5rem;
      	font-size: 24px;
      	font-weight: bold;
        position: relative;
    	top: 2px;
    }
    .card-header:first-child{
        padding:0px 0px 0px 10px
    }
</style>


<div class="container-fluid"><span id="alert_message"></span></div>
<div class="container-fluid mb-3">

        <div class="row">
            <div class="col-4">

        <div id="accordion">

            <!-- General Settings  -->
            <div class="card mb-0">
                <div class="card-header" id="generalSettings">
                    <div class="btn" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="text-bold"><i class="fa fa-angle-right"></i> @lang('file.General Settings')</h5>
                    </div>
                </div>
                <div id="collapse1" class="collapse show" aria-labelledby="generalSettings" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="general-settings-general" data-toggle="list" href="#general" role="tab" aria-controls="home">@lang('file.General')</a>
                            <a class="list-group-item list-group-item-action" id="menus-settings-menus" data-toggle="list" href="#menus" role="tab" aria-controls="messages">@lang('file.Menus')</a>
                            <a class="list-group-item list-group-item-action" id="social-settings-social" data-toggle="list" href="#social_settings" role="tab" aria-controls="social">@lang('file.Social Links')</a>
                            <a class="list-group-item list-group-item-action" id="feature-settings-feature" data-toggle="list" href="#feature" role="tab" aria-controls="settings">@lang('file.Features')</a>
                            <a class="list-group-item list-group-item-action" id="logo-settings-logo" data-toggle="list" href="#logo" role="tab" aria-controls="profile">@lang('file.Logo')</a>
                            <a class="list-group-item list-group-item-action" id="topbanner-settings-topbanner" data-toggle="list" href="#top_banner" role="tab" aria-controls="profile">@lang('file.Top Banner')</a>
                            <a class="list-group-item list-group-item-action" id="footer-settings-footer" data-toggle="list" href="#footer" role="tab" aria-controls="footer">@lang('file.Footer')</a>
                            <a class="list-group-item list-group-item-action" id="newsletter-settings-newsletter" data-toggle="list" href="#newsletter" role="tab" aria-controls="newsletter">@lang('file.Newsletter')</a>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Home Page Sections  -->
             <div class="card">
                <div class="card-header" id="homePageSections">
                    <div class="btn" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="text-bold"><i class="fa fa-angle-right"></i> @lang('file.Home Page Sections')</h5>
                    </div>
                </div>

                <div id="collapse2" class="collapse" aria-labelledby="homePageSections" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action" id="slider_banner_home_page_section" data-toggle="list" href="#slider_banner" role="tab" aria-controls="home">@lang('file.Slider Banners')</a>
                            <a class="list-group-item list-group-item-action" id="three_column_full_width_banners-home_page_section" data-toggle="list" href="#three_column_full_width_banners" role="tab" aria-controls="messages">@lang('file.Three Column Full Width Banners')</a>
                            <a class="list-group-item list-group-item-action" id="product_tabs_one-home_page_section" data-toggle="list" href="#product_tabs_one" role="tab" aria-controls="settings">@lang('file.Product Tabs')</a>
                            <a class="list-group-item list-group-item-action" id="three_column_banners-home_page_section" data-toggle="list" href="#three_column_banners" role="tab" aria-controls="settings">@lang('file.Three Column Banners')</a>
                            <a class="list-group-item list-group-item-action" id="flash_sale_and_vertical_products-home_page_section" data-toggle="list" href="#flash_sale_and_vertical_products" role="tab" aria-controls="profile">@lang('file.Flash Sale & Vertical Products')</a>
                            <a class="list-group-item list-group-item-action" id="two_column_banners-home_page_section" data-toggle="list" href="#two_column_banners" role="tab" aria-controls="newsletter">@lang('file.Two Column Banners')</a>
                            <a class="list-group-item list-group-item-action" id="one_column_banner-home_page_section" data-toggle="list" href="#one_column_banner" role="tab" aria-controls="settings">@lang('file.One Column Banner')</a>
                            <a class="list-group-item list-group-item-action" id="top_brands-home_page_section" data-toggle="list" href="#top_brands" role="tab" aria-controls="profile">@lang('file.Top Brands')</a>
                            <a class="list-group-item list-group-item-action" id="top_categories-home_page_section" data-toggle="list" href="#top_categories" role="tab" aria-controls="profile">@lang('file.Top Categories')</a>
                        </div>
                    </div>
                </div>
             </div>
        </div>


            </div>
            <div class="col-8">
              <div class="tab-content" id="nav-tabContent">

                    <!----------------------------------- General Setting ------------------------------------------>

                    <!-- general -->
                    <!-- setting[0-12] => DB_ROW_ID-[1-13]: -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-settings-general">
                        @include('admin.pages.storefront.general_setting.general')
                    </div>


                    <!-- menus -->
                    <!-- setting[7-13] => DB_ROW_ID-[8-14]: -->
                    <div class="tab-pane fade" id="menus" role="tabpanel" aria-labelledby="menus-settings-menus">
                        @include('admin.pages.storefront.general_setting.menu')
                    </div>


                    <!-- Social Link -->
                    <!-- setting[14-17] => DB_ROW_ID-[15-18]: -->
                    <div class="tab-pane fade" aria-labelledby="social-settings-social" id="social_settings" role="tabpanel">
                        @include('admin.pages.storefront.general_setting.social')
                    </div>


                    <!-- Feature -->
                    <!-- setting[18-33] => DB_ROW_ID-[19-34]: -->
                    <div class="tab-pane fade" aria-labelledby="feature-settings-feature" id="feature" role="tabpanel">
                        @include('admin.pages.storefront.general_setting.feature')
                    </div>


                    <!-- Logo -->
                    <!-- DB_ROW_ID-[35-] => setting[34-] -->
                    <div class="tab-pane fade" aria-labelledby="logo-settings-logo" id="logo" role="tabpanel">
                        @include('admin.pages.storefront.general_setting.logo')
                    </div>

                    <!-- Top Banner -->
                    <!-- DB_ROW_ID-[35-] => setting[34-] -->
                    <div class="tab-pane fade" aria-labelledby="topbanner-settings-topbanner" id="top_banner" role="tabpanel">
                        @include('admin.pages.storefront.general_setting.top-banner')
                    </div>


                    <!-- Footer -->
                    <!-- DB_ROW_ID-[35-37] => setting[34-36] -->
                    <div class="tab-pane fade" aria-labelledby="footer-settings-footer" id="footer">
                        @include('admin.pages.storefront.general_setting.footer')
                    </div>


                    <!-- Newslater -->
                    <!-- DB_ROW_ID-[38] => setting[37] -->
                    <div class="tab-pane fade" aria-labelledby="newsletter-settings-newsletter" id="newsletter">
                        @include('admin.pages.storefront.general_setting.newsletter')
                    </div>


                    <!-- Product Page -->
                    <!-- DB_ROW_ID-[39-41] => setting[38-40] -->
                    <div class="tab-pane fade" aria-labelledby="product_page-settings-product_page" id="product_page">
                        @include('admin.pages.storefront.general_setting.product_page')
                    </div>



                    <!----------------------------------- Home Page Section ------------------------------------------>

                    <!-- Slider Banner -->
                    <!-- DB_ROW_ID-[42-47] => setting[41-46] -->
                    <div class="tab-pane fade" aria-labelledby="slider_banner_home_page_section" id="slider_banner">
                        @include('admin.pages.storefront.home_page_section.slider_banner')
                    </div>

                    <!-- One Column Banner -->
                    <!-- DB_ROW_ID-[48-51] => setting[47-50] -->
                    <div class="tab-pane fade" aria-labelledby="one_column_banner-home_page_section" id="one_column_banner">
                        @include('admin.pages.storefront.home_page_section.one_column_banner')
                    </div>

                    <!-- Two Column Banner -->
                    <!-- DB_ROW_ID-[52-58] => setting[51-57] -->
                    <div class="tab-pane fade" aria-labelledby="two_column_banners-home_page_section" id="two_column_banners">
                        @include('admin.pages.storefront.home_page_section.two_column_banners')
                    </div>

                    <!-- Three Column Banner -->
                    <!-- DB_ROW_ID-[59-68] => setting[58-67] -->
                    <div class="tab-pane fade" aria-labelledby="three_column_banners-home_page_section" id="three_column_banners">
                        @include('admin.pages.storefront.home_page_section.three_column_banners')
                    </div>


                    <!-- Three Column Full Width Banner -->
                    <!-- DB_ROW_ID-[69-79] => setting[68-78] -->
                    <div class="tab-pane fade" aria-labelledby="three_column_full_width_banners-home_page_section" id="three_column_full_width_banners">
                        @include('admin.pages.storefront.home_page_section.three_column_full_width_banners')
                    </div>


                    <!-- Featured Categories -->
                    <!-- DB_ROW_ID-[] => setting[] -->
                    <div class="tab-pane fade" aria-labelledby="featured_categories-home_page_section" id="featured_categories">
                        @include('admin.pages.storefront.home_page_section.featured_categories')
                    </div>

                    <!-- Top Brands -->
                    <!-- DB_ROW_ID-[80-81] => setting[79-80] -->
                    <div class="tab-pane fade" aria-labelledby="top_brands-home_page_section" id="top_brands">
                        @include('admin.pages.storefront.home_page_section.top_brands')
                    </div>

                    <!-- Top Categories -->
                    <div class="tab-pane fade" aria-labelledby="top_categories-home_page_section" id="top_categories">
                        @include('admin.pages.storefront.home_page_section.top_categories')
                    </div>


                    <!-- DB_ROW_ID-[] => setting[] -->
                    <div class="tab-pane fade" aria-labelledby="flash_sale_and_vertical_products-home_page_section" id="flash_sale_and_vertical_products">
                        @include('admin.pages.storefront.home_page_section.flash_sale_and_vertical_products')
                    </div>


                    <!-- Product Tabs One -->
                    <!-- DB_ROW_ID-[82-102] => setting[81-101] -->
                    <div class="tab-pane fade" aria-labelledby="product_tabs_one-home_page_section" id="product_tabs_one">
                        @include('admin.pages.storefront.home_page_section.product_tabs_one')
                    </div>


                    <!-- Product Tabs Two -->
                    <!-- DB_ROW_ID-[103-124] => setting[102-123] -->
                    <div class="tab-pane fade" aria-labelledby="product_tabs_two-home_page_section" id="product_tabs_two">
                        @include('admin.pages.storefront.home_page_section.product_tabs_two')
                    </div>

              </div>
            </div>
          </div>
</div>
@endsection


@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            $(document).ready(function(){
                // Add down arrow icon for collapse element which is open by default
                $(".collapse.show").each(function(){
                    $(this).prev(".card-header").find(".fa").addClass("fa-angle-down").removeClass("fa-angle-right");
                });

                // Toggle right and down arrow icon on show hide of collapse element
                $(".collapse").on('show.bs.collapse', function(){
                    $(this).prev(".card-header").find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
                }).on('hide.bs.collapse', function(){
                    $(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
                });
            });


            //----------Insert Data----------------------

            //General
            $('#customColorTheme').empty();
            $('#customColorTheme').hide();
            $('#storefrontThemeColor').change(function(){
                var storefront_theme_color = $('#storefrontThemeColor').val();

                if (storefront_theme_color=='custom_color') {
                    $('#storefrontThemeColor').removeAttr('name');
                    $('#customColorTheme').show();
                    var customColorTheme = $('#customColorTheme').val();
                    $('#storefrontThemeColor').selectpicker('val',customColorTheme);
                    console.log(customColorTheme);
                }else{
                    $('#customColorTheme').hide();
                    $('#customColorTheme').empty();
                }
            });


            //General Submit
            $('#generalSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.general.store'])
            });

            // $('#generalSubmit').on('submit', function (e) {
            //     e.preventDefault();
            //     $.ajax({
            //         url: "{{route('admin.storefront.general.store')}}",
            //         method: "POST",
            //         data: new FormData(this),
            //         contentType: false,
            //         cache: false,
            //         processData: false,
            //         dataType: "json",
            //         success: function (data) {
            //             console.log(data);
            //             let html = '';
            //             if (data.errors) {
            //                 html = '<div class="alert alert-danger">';
            //                 for (let count = 0; count < data.errors.length; count++) {
            //                     html += '<p>' + data.errors[count] + '</p>';
            //                 }
            //                 html += '</div>';
            //                 $('#alert_message').fadeIn("slow");
            //                 $('#error_message').html(html);
            //                 setTimeout(function() {
            //                     $('#alert_message').fadeOut("slow");
            //                 }, 3000);
            //             }
            //             else if(data.success){
            //                 $('#alert_message').fadeIn("slow"); //Check in top in this blade
            //                 $('#alert_message').addClass('alert alert-success').html(data.success);
            //                 setTimeout(function() {
            //                     $('#alert_message').fadeOut("slow");
            //                 }, 3000);
            //             }
            //             $('.save').text('Save');
            //         }
            //     });
            // });

            //Menus
            $('#menuSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.menu.store'])
            });

            //Social Links
            $('#socialLinkSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.menu.store'])
            });

            //Features
            $('#featureSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.feature.store'])
            });


            //Logo
            $('#logoSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.logo.store'])
            });

            //Banner
            $('#topbarBannerSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.topBanner.store'])
            });

            //Footer
            $('#footerSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.footer.store'])
            });


            //Newsletter
            $('#newsletterSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.newletter.store'])
            });


            //Product Page
            $('#productPageSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.product_page.store'])
            });


            //Slider Banner
            $('#sliderBannerSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.slider_banners.store'])
            });


            //One Coulunm Banner
            $('#oneColumnBannerSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.one_column_banner.store'])
            });


            //Two Coulunm Banner
            $('#twoColumnBannersSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.two_column_banners.store'])
            });


            //Three Coulunm Banner
            $('#threeColumnBannersSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.three_column_banners.store'])
            });


            //Three Coulunm Full Width Banner
            $('#threeColumnFullWidthBannersSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.three_column_full_width_banners.store'])
            });


            //Top Brand
            $('#topBrandsSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.top_brands.store'])
            });

            //Top Categories
            $('#topCategoriesSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.top_categories.store'])
            });

            //Top Flash Sale and Verticle Products
            $('#flashSaleAndVerticalProducts').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.flash_sale_and_vertical_products.store'])
            });


            //Product Tabs One
            $('#productTabsOneSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.product_tab_one.store'])
            });


            //Product Tabs Two
            $('#productTabsTwoSubmit').on('submit', function (e) {
                @include('admin.includes.common_js.storefront_submit_js',['route_name'=>'admin.storefront.product_tab_two.store'])
            });

            //Image Show Before Upload End
            function showImage(data, logo){
                if(data.files && data.files[0]){
                    var obj = new FileReader();

                    obj.onload = function(d){
                        var image = document.getElementById(logo);
                        image.src = d.target.result;
                    }
                    obj.readAsDataURL(data.files[0]);
                }
            }


            //Tinymc
            tinymce.init({
                selector: '.text-editor',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                },
                height: 400,

                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                invalid_elements: 'script',
                entity_encoding : "raw",
                /*
                    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                    images_upload_url: 'postAcceptor.php',
                    here we add custom filepicker only to Image dialog
                */
                file_picker_types: 'image',
                /* and here's our custom image picker*/
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    /*
                        Note: In modern browsers input[type="file"] is functional without
                        even adding it to the DOM, but that might not be the case in some older
                        or quirky browsers like IE, so you might want to add it to the DOM
                        just in case, and visually hide it. And do not forget do remove it
                        once you do not need it anymore.
                    */

                    input.onchange = function () {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function () {
                            /*
                                Note: Now we need to register the blob in TinyMCEs image blob
                                registry. In the next release this part hopefully won't be
                                necessary, as we are looking to handle it internally.
                            */
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), {title: file.name});
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },

                plugins: [
                    'advlist autolink lists link image charmap anchor textcolor',
                    'searchreplace',
                    'insertdatetime media table paste wordcount'
                ],
                menubar: '',
                toolbar: 'insertfile | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media | forecolor backcolor | table | removeformat',
                branding: false
            });

        })(jQuery);

        function showImage(data, imgId){
            if(data.files && data.files[0]){
                var obj = new FileReader();
                obj.onload = function(d){
                    var image = document.getElementById(imgId);
                    image.src = d.target.result;
                }
                obj.readAsDataURL(data.files[0]);
            }
        }
    </script>
@endpush
