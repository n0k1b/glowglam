@extends('admin.main')
@section('title','Admin | Permission')
@section('admin_content')

<link rel="stylesheet" href="{{asset('public/css/kendo.default.v2.min.css')}}" type="text/css">
<script type="text/javascript" src="{{asset('public/js/kendo.all.min.js')}}"></script>


<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <span id="form_result_permission"></span>

                <h1 class="text-center mt-2">{{$role->name}}</h1>
                <p>{{__('file.You can assign permission for this role')}}</p>

                <div id="all_resources">
                    <div class="demo-section k-content">

                        <h4>{{__('file.Select modules')}}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="treeview1"></div>
                            </div>
                            <div class="col-md-4">
                                <div  id="treeview2"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="treeview3"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mt-5">
                    <div class="col-md-6 offset-md-3 mt-5">
                        <input id="role_id" type="hidden" name="role_id" value={{$role->id}}>
                        <button class="btn btn-primary btn-block" id="set_permission_btn" type="submit" class="roles-btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            var checkedNodes;


            $(document).ready(function () {

                $("ul#setting").siblings('a').attr('aria-expanded', 'true');
                $("ul#setting").addClass("show");
                $("ul#setting #role-menu").addClass("active");

                var target = '{{route('permissionDetails',$role->id)}}';
                $.ajax({
                    type: "GET",
                    url: target,
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);

                        $("#treeview1").empty();
                        $("#treeview1").kendoTreeView({
                            checkboxes: {
                                checkChildren: true
                            },
                            check: onCheck,
                            dataSource: [
                                {
                                    id: 'product',
                                    text: "{{trans('Product')}}",
                                    expanded: true,
                                    checked: ($.inArray('product', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'category',
                                            text: '{{__('Category')}}',
                                            expanded: true,
                                            checked: ($.inArray('category', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'category-view',
                                                    text: '{{__('Category View')}}',
                                                    checked: ($.inArray('category-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'category-store',
                                                    text: '{{__('Category Store')}}',
                                                    checked: ($.inArray('category-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'category-edit',
                                                    text: '{{__('Category Edit')}}',
                                                    checked: ($.inArray('category-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'category-action',
                                                    text: '{{__('Category Action')}}',
                                                    checked: ($.inArray('category-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                        {
                                            id: 'brand',
                                            text: '{{__('Brand')}}',
                                            expanded: true,
                                            checked: ($.inArray('brand', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'brand-view',
                                                    text: '{{__('Brand View')}}',
                                                    checked: ($.inArray('brand-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'brand-store',
                                                    text: '{{__('Brand Store')}}',
                                                    checked: ($.inArray('brand-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'brand-edit',
                                                    text: '{{__('Brand Edit')}}',
                                                    checked: ($.inArray('brand-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'brand-action',
                                                    text: '{{__('Brand Action')}}',
                                                    checked: ($.inArray('brand-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                        {
                                            id: 'attribute_set',
                                            text: '{{trans('Attribute Set')}}',
                                            expanded: true,
                                            checked: ($.inArray('attribute_set', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'attribute_set-view',
                                                    text: '{{__('Attribute Set View')}}',
                                                    checked: ($.inArray('attribute_set-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'attribute_set-store',
                                                    text: '{{__('Attribute Set Store')}}',
                                                    checked: ($.inArray('attribute_set-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'attribute_set-edit',
                                                    text: '{{__('Attribute Set Edit')}}',
                                                    checked: ($.inArray('attribute_set-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'attribute_set-action',
                                                    text: '{{__('Attribute Set Action')}}',
                                                    checked: ($.inArray('attribute_set-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                        {
                                            id: 'attribute',
                                            text: '{{trans('Attribute')}}',
                                            expanded: true,
                                            checked: ($.inArray('attribute', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'attribute-view',
                                                    text: '{{__('Attribute View')}}',
                                                    checked: ($.inArray('attribute-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'attribute-store',
                                                    text: '{{__('Attribute Store')}}',
                                                    checked: ($.inArray('attribute-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'attribute-edit',
                                                    text: '{{__('Attribute Edit')}}',
                                                    checked: ($.inArray('attribute-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'attribute-action',
                                                    text: '{{__('Attribute Action')}}',
                                                    checked: ($.inArray('attribute-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                        {
                                            id: 'tag',
                                            text: '{{trans('Tag')}}',
                                            expanded: true,
                                            checked: ($.inArray('tag', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'tag-view',
                                                    text: '{{__('Tag View')}}',
                                                    checked: ($.inArray('tag-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'tag-store',
                                                    text: '{{__('Tag Store')}}',
                                                    checked: ($.inArray('tag-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'tag-edit',
                                                    text: '{{__('Tag Edit')}}',
                                                    checked: ($.inArray('tag-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'tag-action',
                                                    text: '{{__('Tag Action')}}',
                                                    checked: ($.inArray('tag-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                        {
                                            id: 'catalog',
                                            text: '{{trans('Catalog')}}',
                                            expanded: true,
                                            checked: ($.inArray('catalog', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'product-view',
                                                    text: '{{__('Product View')}}',
                                                    checked: ($.inArray('product-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'product-store',
                                                    text: '{{__('Product Store')}}',
                                                    checked: ($.inArray('product-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'product-edit',
                                                    text: '{{__('Product Edit')}}',
                                                    checked: ($.inArray('product-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'product-action',
                                                    text: '{{__('Product Action')}}',
                                                    checked: ($.inArray('product-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                    ],
                                },
                            ]
                        });

                        $("#treeview2").empty();
                        $("#treeview2").kendoTreeView({
                            checkboxes: {
                                checkChildren: true
                            },
                            check: onCheck,
                            dataSource: [
                                {
                                    id: 'flash_sale',
                                    text: "{{trans('Flash Sale')}}",
                                    expanded: true,
                                    checked: ($.inArray('flash_sale', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'flash_sale-view',
                                            text: '{{__('Flash Sale View')}}',
                                            checked: ($.inArray('flash_sale-view', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'flash_sale-store',
                                            text: '{{__('Flash Sale Store')}}',
                                            checked: ($.inArray('flash_sale-store', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'flash_sale-edit',
                                            text: '{{__('Flash Sale Edit')}}',
                                            checked: ($.inArray('flash_sale-edit', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'flash_sale-action',
                                            text: '{{__('Flash Sale Action')}}',
                                            checked: ($.inArray('flash_sale-action', result) >= 0) ? true : false
                                        },
                                    ],
                                },
                                {
                                    id: 'coupon',
                                    text: "{{trans('Coupon')}}",
                                    expanded: true,
                                    checked: ($.inArray('coupon', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'coupon-view',
                                            text: '{{__('Coupon View')}}',
                                            checked: ($.inArray('coupon-view', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'coupon-store',
                                            text: '{{__('Coupon Store')}}',
                                            checked: ($.inArray('coupon-store', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'coupon-edit',
                                            text: '{{__('Coupon Edit')}}',
                                            checked: ($.inArray('coupon-edit', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'coupon-action',
                                            text: '{{__('Coupon Action')}}',
                                            checked: ($.inArray('coupon-action', result) >= 0) ? true : false
                                        },
                                    ],
                                },
                                {
                                    id: 'page',
                                    text: "{{trans('Page')}}",
                                    expanded: true,
                                    checked: ($.inArray('page', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'page-view',
                                            text: '{{__('Page View')}}',
                                            checked: ($.inArray('page-view', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'page-store',
                                            text: '{{__('Page Store')}}',
                                            checked: ($.inArray('page-store', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'page-edit',
                                            text: '{{__('Page Edit')}}',
                                            checked: ($.inArray('page-edit', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'page-action',
                                            text: '{{__('Page Action')}}',
                                            checked: ($.inArray('page-action', result) >= 0) ? true : false
                                        },
                                    ],
                                },
                                {
                                    id: 'menu',
                                    text: "{{trans('Menu')}}",
                                    expanded: true,
                                    checked: ($.inArray('menu', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'menu-view',
                                            text: '{{__('Menu View')}}',
                                            checked: ($.inArray('menu-view', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'menu-store',
                                            text: '{{__('Menu Store')}}',
                                            checked: ($.inArray('menu-store', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'menu-edit',
                                            text: '{{__('Menu Edit')}}',
                                            checked: ($.inArray('menu-edit', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'menu-action',
                                            text: '{{__('Menu Action')}}',
                                            checked: ($.inArray('menu-action', result) >= 0) ? true : false
                                        },
                                    ],
                                },
                                {
                                    id: 'menu_item',
                                    text: "{{trans('Menu Item')}}",
                                    expanded: true,
                                    checked: ($.inArray('menu_item', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'menu_item-view',
                                            text: '{{__('Menu Item View')}}',
                                            checked: ($.inArray('menu_item-view', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'menu_item-store',
                                            text: '{{__('Menu Item Store')}}',
                                            checked: ($.inArray('menu_item-store', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'menu_item-edit',
                                            text: '{{__('Menu Item Edit')}}',
                                            checked: ($.inArray('menu_item-edit', result) >= 0) ? true : false
                                        },
                                        {
                                            id: 'menu_item-action',
                                            text: '{{__('Menu Item  Action')}}',
                                            checked: ($.inArray('menu_item-action', result) >= 0) ? true : false
                                        },
                                    ],
                                },
                                {
                                    id: 'users_and_roles',
                                    text: "{{trans('User And Role')}}",
                                    expanded: true,
                                    checked: ($.inArray('users_and_roles', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'user',
                                            text: '{{__('User')}}',
                                            expanded: true,
                                            checked: ($.inArray('user', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'user-view',
                                                    text: '{{__('User View')}}',
                                                    checked: ($.inArray('user-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'user-store',
                                                    text: '{{__('User Store')}}',
                                                    checked: ($.inArray('user-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'user-edit',
                                                    text: '{{__('User Edit')}}',
                                                    checked: ($.inArray('user-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'user-action',
                                                    text: '{{__('User  Action')}}',
                                                    checked: ($.inArray('user-action', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                        {
                                            id: 'role',
                                            text: '{{__('Role')}}',
                                            expanded: true,
                                            checked: ($.inArray('role', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'role-view',
                                                    text: '{{__('Role View')}}',
                                                    checked: ($.inArray('role-view', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'role-store',
                                                    text: '{{__('Role Store')}}',
                                                    checked: ($.inArray('role-store', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'role-edit',
                                                    text: '{{__('Role Edit')}}',
                                                    checked: ($.inArray('role-edit', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'role-action',
                                                    text: '{{__('Role Action')}}',
                                                    checked: ($.inArray('role-action', result) >= 0) ? true : false
                                                },
                                                {
                                                    id: 'set_permission',
                                                    text: '{{__('Set Permission')}}',
                                                    checked: ($.inArray('set_permission', result) >= 0) ? true : false
                                                },
                                            ],
                                        },
                                    ],
                                },
                            ]
                        });

                        $("#treeview3").empty();
                        $("#treeview3").kendoTreeView({
                            checkboxes: {
                                checkChildren: true
                            },
                            check: onCheck,
                            dataSource: [
                                {
                                    id: 'appearance',
                                    text: "{{trans('Appearance')}}",
                                    expanded: true,
                                    checked: ($.inArray('appearance', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'store_front',
                                            text: '{{__('Store Front')}}',
                                            checked: ($.inArray('store_front', result) >= 0) ? true : false,
                                        },
                                    ],
                                },
                                {
                                    id: 'site-setting',
                                    text: "{{trans('Site Setting')}}",
                                    expanded: true,
                                    checked: ($.inArray('site-setting', result) >= 0) ? true : false,
                                    items: [
                                        {
                                            id: 'setting',
                                            text: '{{__('Setting')}}',
                                            checked: ($.inArray('setting', result) >= 0) ? true : false,
                                        },
                                        {
                                            id: 'country',
                                            text: '{{__('Country')}}',
                                            expanded: true,
                                            checked: ($.inArray('country', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'country-view',
                                                    text: '{{__('Country View')}}',
                                                    checked: ($.inArray('country-view', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'country-store',
                                                    text: '{{__('Country Store')}}',
                                                    checked: ($.inArray('country-store', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'country-edit',
                                                    text: '{{__('Country Edit')}}',
                                                    checked: ($.inArray('country-edit', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'country-action',
                                                    text: '{{__('Country Action')}}',
                                                    checked: ($.inArray('country-action', result) >= 0) ? true : false,
                                                },
                                            ]
                                        },
                                        {
                                            id: 'currency',
                                            text: '{{__('Currency')}}',
                                            expanded: true,
                                            checked: ($.inArray('currency', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'currency-view',
                                                    text: '{{__('Currency View')}}',
                                                    checked: ($.inArray('currency-view', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'currency-store',
                                                    text: '{{__('Currency Store')}}',
                                                    checked: ($.inArray('currency-store', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'currency-edit',
                                                    text: '{{__('Currency Edit')}}',
                                                    checked: ($.inArray('currency-edit', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'currency-action',
                                                    text: '{{__('Currency Action')}}',
                                                    checked: ($.inArray('currency-action', result) >= 0) ? true : false,
                                                },
                                            ]
                                        },
                                        {
                                            id: 'locale',
                                            text: '{{__('Locale')}}',
                                            expanded: true,
                                            checked: ($.inArray('locale', result) >= 0) ? true : false,
                                            items: [
                                                {
                                                    id: 'locale-view',
                                                    text: '{{__('Locale View')}}',
                                                    checked: ($.inArray('locale-view', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'locale-store',
                                                    text: '{{__('Locale Store')}}',
                                                    checked: ($.inArray('locale-store', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'locale-edit',
                                                    text: '{{__('Locale Edit')}}',
                                                    checked: ($.inArray('locale-edit', result) >= 0) ? true : false,
                                                },
                                                {
                                                    id: 'locale-action',
                                                    text: '{{__('Locale Action')}}',
                                                    checked: ($.inArray('locale-action', result) >= 0) ? true : false,
                                                },
                                            ]
                                        },
                                    ],
                                },
                            ]
                        });

                        // function that gathers IDs of checked nodes
                        function checkedNodeIds(nodes, checkedNodes) {

                            for (var i = 0; i < nodes.length; i++) {
                                if (nodes[i].checked) {
                                    getParentIds(nodes[i], checkedNodes);
                                    checkedNodes.push(nodes[i].id);
                                }

                                if (nodes[i].hasChildren) {
                                    checkedNodeIds(nodes[i].children.view(), checkedNodes);
                                }
                            }
                        }

                        function getParentIds(node, checkedNodes) {
                            if (node.parent() && node.parent().parent() && checkedNodes.indexOf(node.parent().parent().id) == -1) {
                                getParentIds(node.parent().parent(), checkedNodes);
                                checkedNodes.push(node.parent().parent().id);
                            }
                        }

                        // show checked node IDs on datasource change
                        function onCheck() {
                            checkedNodes = [];
                            var treeView1 = $('#treeview1').data("kendoTreeView"),
                                message;
                            var treeView2 = $('#treeview2').data("kendoTreeView"),
                                message;
                            var treeView3 = $('#treeview3').data("kendoTreeView"),
                                message;

                            //console.log(treeView.dataSource.view());
                            //console.log(checkedNodes);

                            checkedNodeIds(treeView1.dataSource.view(), checkedNodes);
                            checkedNodeIds(treeView2.dataSource.view(), checkedNodes);
                            checkedNodeIds(treeView3.dataSource.view(), checkedNodes);
                        }

                    }
                });


                $('#set_permission_btn').on('click', function () {

                    if (checkedNodes) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-T{{trans('file.OK')}}EN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var target = '{{route('set_permission')}}';

                        $.ajax({
                            type: 'POST',
                            url: target,
                            data: {
                                checkedId: checkedNodes,
                                roleId: "{{ $role->id}}",
                            },
                            success: function (data) {
                                console.log(data);
                                var html = '';
                                if (data.errors) {
                                    html = '<div class="alert alert-danger">';
                                    for (var count = 0; count < data.errors.length; count++) {
                                        html += '<p>' + data.errors[count] + '</p>';
                                    }
                                    html += '</div>';
                                }
                                if (data.success) {
                                    html = '<div class="alert alert-success">' + data.success + '</div>';
                                }
                                if (data.error) {
                                    html = '<div class="alert alert-danger">' + data.error + '</div>';
                                }
                                $('#form_result_permission').html(html).slideDown(100).delay(3000).slideUp(100);
                            }
                        });
                    } else {
                        alert('{{__('Please select atleast one checkbox')}}');
                    }


                });

            });
        })(jQuery);
    </script>
@endpush



