@extends('admin.main')
@section('title','Admin | Slider')
@section('admin_content')
@push('css')
<link rel="preload" href="http://demo.lion-coders.com/soft/sarchholm/css/bootstrap-colorpicker.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link href="http://demo.lion-coders.com/soft/sarchholm/css/bootstrap-colorpicker.css" rel="stylesheet"></noscript>
<style>
    #switcher {list-style: none;margin: 0;padding: 0;overflow: hidden;}#switcher li {float: left;width: 30px;height: 30px;margin: 0 15px 15px 0;border-radius: 3px;}#demo {border-right: 1px solid #d5d5d5;width: 250px;height: 100%;left: -250px;position: fixed;padding: 50px 30px;background-color: #fff;transition: all 0.3s;z-index: 999;}#demo.open {left: 0;}.demo-btn {background-color: #fff;border: 1px solid #d5d5d5;border-left: none;border-bottom-right-radius: 3px;border-top-right-radius: 3px;color: var(--theme-color);font-size: 30px;height: 40px;position: absolute;right: -40px;text-align: center;top: 35%;width: 40px;}
</style>
@endpush
<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">@lang('file.Slider')</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__('file.Add New Slide')}}</button>
        <button type="button" class="btn btn-danger" id="bulk_action">
            <i class="fa fa-minus-circle"></i> {{trans('file.Bulk Action')}}
        </button>
    </div>
    <div class="table-responsive">
    	<table id="slider_table" class="table">
    	    <thead>
        	   <tr>
                    <th class="not-exported"></th>
                    <th scope="col">{{__('file.Image')}}</th>
                    <th scope="col">{{__('file.Title')}}</th>
                    <th scope="col">{{__('file.Subtitle')}}</th>
                    <th scope="col">{{__('file.Type')}}</th>
                    <th scope="col">{{__('file.Text Alignment')}}</th>
                    <th scope="col">{{__('file.Text Color Code')}}</th>
                    <th scope="col">{{__('file.Status')}}</th>
                    <th scope="col">{{trans('file.action')}}</th>
        	   </tr>
            </thead>
    	</table>
    </div>
</section>

@include('admin.pages.slider.create')
@include('admin.pages.slider.edit')
@include('admin.includes.confirm_modal')


@endsection


@push('scripts')

    <script src="http://demo.lion-coders.com/soft/sarchholm/js/bootstrap-colorpicker.js"></script>
    <script>
        (function ($) {
            "use strict";

            $('#color-input,#textColor').colorpicker({

            });

        })(jQuery);

    </script>
    <script type="text/javascript">
        (function ($) {
            "use strict";


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                let table = $('#slider_table').DataTable({
                    initComplete: function () {
                        this.api().columns([1]).every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                                $('select').selectpicker('refresh');
                            });
                        });
                    },
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.slider') }}",
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'slider_image',
                            name: 'slider_image',
                        },
                        {
                            data: 'slider_title',
                            name: 'slider_title',
                        },
                        {
                            data: 'slider_subtitle',
                            name: 'slider_subtitle',
                        },
                        {
                            data: 'type',
                            name: 'type',
                        },
                        {
                            data: 'text_alignment',
                            name: 'text_alignment',
                        },
                        {
                            data: 'text_color_code',
                            name: 'text_color_code',
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render:function (data) {
                                if (data == 1) {
                                    return "<span class='p-2 badge badge-success'>Active</span>";
                                }else{
                                    return "<span class='p-2 badge badge-danger'>Inactive</span>";
                                }
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                        }
                    ],


                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ {{__("records per page")}}',
                        "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                        "search": '{{trans("file.Search")}}',
                        'paginate': {
                            'previous': '{{trans("file.Previous")}}',
                            'next': '{{trans("file.Next")}}'
                        }
                    },
                    'columnDefs': [
                        {
                            "orderable": false,
                            'targets': [0],
                        },
                        {
                            'render': function (data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                            },
                            'targets': [0]
                        }
                    ],


                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    dom: '<"row"lfB>rtip',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
                new $.fn.dataTable.FixedHeader(table);
            });

            //Field Change for Type
            $('#type').change(function() {
                var type = $('#type').val();

                if (type=='category') {
                    $('#changeLabelTextByType').text('Category');
                }else{
                    $('#changeLabelTextByType').text('URL');
                }

                if (type){
                    $.get("{{route('admin.menu.menu_item.data-fetch-by-type')}}",{type:type}, function (data) {
                        console.log(data)
                    $('#dependancyType').empty().html(data);
                    });
                }
            });

            //Field Change for Type Edit
            $('#typeEdit').change(function() {
                let type_edit = $('#typeEdit').val();
                if (type_edit){
                    $.get("{{route('admin.menu.menu_item.data-fetch-by-type')}}",{type:type_edit}, function (data) {
                        if (type_edit=='category') {
                            $('#dependancyTypeForCategoryEdit').addClass('d-none');
                            $('#url_edit').addClass('d-none');

                            $('#changeLabelTextByTypeEdit').text('Category');
                            $('#dependancyTypeEdit').empty().html(data);
                        }else{
                            $('#dependancyTypeForCategoryEdit').addClass('d-none');
                            $('#url_edit').addClass('d-none');

                            $('#changeLabelTextByTypeEdit').text('URL');
                            $('#dependancyTypeEdit').empty().html(data);
                        }
                    });
                }
            });


            //----------Insert Data----------------------
            $("#submitForm").on("submit",function(e){
                e.preventDefault();

                var formData = new FormData(this); //For Image always use this method

                $.ajax({
                    url: "{{route('admin.slider.store')}}",
                    type: "POST",
                    data: formData,
                    contentType: false, //That means we send mulitpart/data
                    processData: false, //deafult value is true- that means pass data as object/string. false is opposite.
                    success: function(data){
                        console.log(data);
                        if (data.errors) {
                            $("#alertMessage").empty().addClass('alert alert-danger').html(data.errors)
                            setTimeout(function() {
                                $('#alertMessage').fadeOut("slow");
                            }, 3000);
                            $('#save').text('Save');
                        }
                        else if(data.success){
                            $("#createModalForm").modal('hide');
                            $('#slider_table').DataTable().ajax.reload();
                            $('#submitForm')[0].reset();
                            $('select').selectpicker('refresh');
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                            $("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                            $('#save').text('Save');
                        }
                    }
                });
            });

            // ------------ Edit ------------------
            $(document).on("click",".edit",function(e){
                e.preventDefault();
                var sliderId = $(this).data("id");
                var element = this;

                $.ajax({
                    url: "{{route('admin.slider.edit')}}",
                    type: "GET",
                    data: {slider_id:sliderId},
                    success: function(data){
                        $('#sliderId').val(data.slider.id);
                        $('#sliderTitleEdit').val(data.sliderTranslation.slider_title);
                        $('#sliderSubtitleEdit').val(data.sliderTranslation.slider_subtitle);
                        $('#typeEdit').selectpicker('val',data.slider.type);
                        $('#textAlignment').selectpicker('val',data.slider.text_alignment);
                        $('#sliderTranslationId').val(data.sliderTranslation.id);
                        $('#textColor').val(data.slider.text_color);

                        if (data.slider.type=='category') {
                            $('#url_edit').addClass('d-none');
                            $('#changeLabelTextByTypeEdit').text('Category');
                            $('#category_id_edit').selectpicker('val',data.slider.category_id);
                        }
                        else if(data.slider.type=='url'){
                            $('#dependancyTypeForCategoryEdit').addClass('d-none');
                            $('#changeLabelTextByTypeEdit').text('URL');
                            $('#url_edit').val(data.slider.url);
                        }

                        if (data.slider_image) {
                            var imageUrl = data.slider_image;
                        }
                        $('#item_image').attr('src',imageUrl);

                        if (data.slider.is_active==1) {
                            $('#isActiveEdit').attr('checked', true)
                        }else{
                            $('#isActiveEdit').attr('checked', false)
                        }
                        $('#targetEdit').selectpicker('val',data.slider.target);
                        $('#EditformModal').modal('show');
                    }
                });
            });

            //----------Update Data----------------------
            $("#updatetForm").on("submit",function(e){
                e.preventDefault();

                $("#update").on("click",function(e){
                    $('#update').text('Updating ...');
                });

                var formData = new FormData(this); //For Image always use this method
                $.ajax({
                    url: "{{route('admin.slider.update')}}",
                    type: "POST",
                    data: formData,
                    contentType: false, //That means we send mulitpart/data
                    processData: false, //deafult value is true- that means pass data as object/string. false is opposite.
                    success: function(data){
                        console.log(data);
                        if (data.errors) {
                            $("#alertMessageEdit").empty().addClass('alert alert-danger').html(data.errors)
                            setTimeout(function() {
                                $('#alertMessageEdit').fadeOut("slow");
                            }, 3000);
                            $('#update').text('Update');
                        }
                        else if(data.success){
                            $("#EditformModal").modal('hide');
                            $('#slider_table').DataTable().ajax.reload();
                            $('#updatetForm')[0].reset();
                            $('select').selectpicker('refresh');
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                            $("#alertMessageEdit").empty();
                            $('#update').text('Update');
                        }
                    }
                });
            });


            //---------- Active -------------
            $(document).on("click",".active",function(e){
                e.preventDefault();
                var id = $(this).data("id");

                $.ajax({
                    url: "{{route('admin.slider.active')}}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            $('#slider_table').DataTable().ajax.reload();
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                        else if(data.errors){
                            $('#slider_table').DataTable().ajax.reload();
                            $('#success_alert').fadeIn("slow");
                            $('#success_alert').addClass('alert alert-danger').html(data.errors);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });


            //---------- Inactive -------------
            $(document).on("click",".inactive",function(e){
                e.preventDefault();
                var id = $(this).data("id");

                $.ajax({
                    url: "{{route('admin.slider.inactive')}}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            $('#slider_table').DataTable().ajax.reload();
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                        else if(data.errors){
                            $('#slider_table').DataTable().ajax.reload();
                            $('#success_alert').fadeIn("slow");
                            $('#success_alert').addClass('alert alert-danger').html(data.errors);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });

            //---------- Delete -------------
            $(document).on("click",".delete",function(e){
                e.preventDefault();
                var slider_id = $(this).data("id");

                if (!confirm('Are you sure you want to continue?')) {
                    alert(false);
                }else{
                    $.ajax({
                        url: "{{route('cartpro.delete')}}",
                        type: "GET",
                        data: {slider_id:slider_id},
                        success: function(data){
                            console.log(data);
                            if(data.success){
                                $('#slider_table').DataTable().ajax.reload();
                                $('#success_alert').fadeIn("slow");
                                $('#success_alert').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#success_alert').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.errors){
                                $('#slider_table').DataTable().ajax.reload();
                                $('#success_alert').fadeIn("slow");
                                $('#success_alert').addClass('alert alert-danger').html(data.errors);
                                setTimeout(function() {
                                    $('#success_alert').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                }
            });


            //Bulk Action
            $("#bulk_action").on("click",function(){
                var idsArray = [];
                let table = $('#slider_table').DataTable();
                idsArray = table.rows({selected: true}).ids().toArray();

                if(idsArray.length === 0){
                    alert("Please Select at least one checkbox.");
                }else{
                    $('#bulkConfirmModal').modal('show');
                    let action_type;

                    $("#active").on("click",function(){
                        console.log(idsArray);
                        action_type = "active";
                        $.ajax({
                            url: "{{route('admin.slider.bulk_action')}}",
                            method: "GET",
                            data: {idsArray:idsArray,action_type:action_type},
                            success: function (data) {
                                if(data.success){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#slider_table').DataTable().ajax.reload();
                                    $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                    $('#success_alert').addClass('alert alert-success').html(data.success);
                                    setTimeout(function() {
                                        $('#success_alert').fadeOut("slow");
                                    }, 3000);
                                }
                                else if(data.errors){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#slider_table').DataTable().ajax.reload();
                                    $('#success_alert').fadeIn("slow");
                                    $('#success_alert').addClass('alert alert-danger').html(data.errors);
                                    setTimeout(function() {
                                        $('#success_alert').fadeOut("slow");
                                    }, 3000);
                                }
                            }
                        });
                    });
                    $("#inactive").on("click",function(){
                        action_type = "inactive";
                        console.log(idsArray);
                        $.ajax({
                            url: "{{route('admin.slider.bulk_action')}}",
                            method: "GET",
                            data: {idsArray:idsArray,action_type:action_type},
                            success: function (data) {
                                if(data.success){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#slider_table').DataTable().ajax.reload();
                                    $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                    $('#success_alert').addClass('alert alert-success').html(data.success);
                                    setTimeout(function() {
                                        $('#success_alert').fadeOut("slow");
                                    }, 3000);
                                }
                                else if(data.errors){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#slider_table').DataTable().ajax.reload();
                                    $('#success_alert').fadeIn("slow");
                                    $('#success_alert').addClass('alert alert-danger').html(data.errors);
                                    setTimeout(function() {
                                        $('#success_alert').fadeOut("slow");
                                    }, 3000);
                                }
                            }
                        });
                    });
                }
            });
        })(jQuery);

        //Image Show Before Upload End
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


