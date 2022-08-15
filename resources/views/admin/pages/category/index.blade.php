@extends('admin.main')
@section('title','Admin | Category')
@section('admin_content')
<section>

        <div class="container-fluid"><span id="alert_message"></span></div>

        <div class="container-fluid mb-3">
            @if (auth()->user()->can('category-store'))
                <button type="button" class="btn btn-info parent_load" name="create_record" id="create_record">
                    <i class="fa fa-plus"></i> @lang('file.Add Category')
                </button>
            @endif
            @if (auth()->user()->can('category-action'))
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                    <i class="fa fa-minus-circle"></i> @lang('file.Bulk Action')
                </button>
            @endif
        </div>

        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th scope="col">{{__('file.Image')}}</th>
                        <th scope="col">{{__('file.Category Name')}}</th>
                        <th scope="col">@lang('file.Parent')</th>
                        <th scope="col">@lang('file.Status')</th>
                        <th scope="col">@lang('file.Action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

    @include('admin.pages.category.create')
    @include('admin.pages.category.edit_modal')
    @include('admin.includes.confirm_modal')

    @endsection

    @push('scripts')

        <script type="text/javascript">
            (function ($) {
                "use strict";


                $(document).ready(function () {
                    let table_table = $('#dataListTable').DataTable({
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
                            url: "{{ route('admin.category') }}",
                        },

                        columns: [
                            {
                                data: null,
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'category_image',
                                name: 'category_image',
                            },
                            {
                                data: 'category_name',
                                name: 'category_name',
                            },
                            {
                                data: 'parent',
                                name: 'parent',

                            },
                            {
                                data: 'is_active',
                                name: 'is_active',
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
                    new $.fn.dataTable.FixedHeader(table_table);
                });


                $('#create_record').click(function () {
                    $('#formModal').modal('show');
                });

                //----------Insert Data----------------------

                $("#submitButton").on("click",function(e){
                    $('#submitButton').text('Saving ...');
                });

                $('#submitForm').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{route('admin.category.store')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        error: function(response){
                            console.log(response)
                            var dataKeys   = Object.keys(response.responseJSON.errors);
                            var dataValues = Object.values(response.responseJSON.errors);
                            let html = '<div class="alert alert-danger">';
                            for (let count = 0; count < dataValues.length; count++) {
                                html += '<p>' + dataValues[count] + '</p>';
                            }
                            html += '</div>';
                            $('#error_message').fadeIn("slow");
                            $('#error_message').html(html);
                            setTimeout(function() {
                                $('#error_message').fadeOut("slow");
                            }, 3000);
                            $('#submitButton').text('Save');
                        },
                        success: function (response) {
                            console.log(response)
                            $('#dataListTable').DataTable().ajax.reload();
                            $('#submitForm')[0].reset();
                            $("#formModal").modal('hide');
                            $('#alert_message').fadeIn("slow");
                            if (response.demo) {
                                $('#alert_message').addClass('alert alert-danger').html(response.demo);
                            }else{
                                $('#alert_message').addClass('alert alert-success').html(response.success);
                            }
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                            $('#submitButton').text('Save');
                        }
                    });
                });

                $(document).on('click', '.edit', function () {
                    var id = $(this).data("id");
                    $('#alert_message').html('');
                    $.ajax({
                        url: "{{ route('admin.category.edit') }}",
                        type: "GET",
                        data: {category_id:id},
                        success: function (data) {
                            console.log(data);
                            $('#category_id').val(data.category.id);
                            $('#category_translation_id').val(data.categoryTranslation.id);
                            $('#category_name_edit').val(data.categoryTranslation.category_name);
                            $('#description_edit').val(data.category.description);
                            $('#cateogry_icon_edit').val(data.category.icon);
                            $('#parent_id_edit').selectpicker('val', data.category.parent_id);
                            $('#description_position_edit').selectpicker('val', data.category.description_position);
                            if (data.category.top === 1) {
                                $('#top_edit').prop('checked', true);
                            } else {
                                $('#top_edit').prop('checked', false);
                            }
                            if (data.category.is_active === 1) {
                                $('#isActive_edit').prop('checked', true);
                            } else {
                                $('#isActive_edit').prop('checked', false);
                            }
                            $('#editModal').modal('show');
                        }
                    })
                });

                //----------Update Data----------------------

                $("#UpdateButton").on("click",function(e){
                    $('#UpdateButton').text('Updating ...');
                });

                $('#updateForm').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{route('admin.category.update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        error: function(response){
                            console.log(response.responseJSON.errors)
                            var dataKeys   = Object.keys(response.responseJSON.errors);
                            var dataValues = Object.values(response.responseJSON.errors);
                            let html = '<div class="alert alert-danger">';
                            for (let count = 0; count < dataValues.length; count++) {
                                html += '<p>' + dataValues[count] + '</p>';
                            }
                            html += '</div>';
                            $('#error_message_edit').fadeIn("slow");
                            $('#error_message_edit').html(html);
                            setTimeout(function() {
                                $('#error_message_edit').fadeOut("slow");
                            }, 3000);
                            $('#UpdateButton').text('Update');
                        },
                        success: function (data) {
                            console.log(data);
                            let html = '';
                            $('#dataListTable').DataTable().ajax.reload();
                            $('#updateForm')[0].reset();
                            $("#editModal").modal('hide');
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            if (data.demo) {
                                $('#alert_message').addClass('alert alert-danger').html(data.demo);
                            }else{
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                            }
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                            $('#UpdateButton').text('Update');
                        }
                    });
                });


                //Bulk Action
                // $("#bulk_action").on("click",function(){
                //     var idsArray = [];
                //     let table = $('#dataListTable').DataTable();
                //     idsArray = table.rows({selected: true}).ids().toArray();

                //     if(idsArray.length === 0){
                //         alert("Please Select at least one checkbox.");
                //     }else{
                //         $('#bulkConfirmModal').modal('show');
                //         let action_type;

                //         $("#active").on("click",function(){
                //             console.log(idsArray);
                //             action_type = "active";
                //             $.ajax({
                //                 url: "{{route('admin.category.bulk_action')}}",
                //                 method: "GET",
                //                 data: {idsArray:idsArray,action_type:action_type},
                //                 success: function (data) {
                //                     if(data.success){
                //                         $('#bulkConfirmModal').modal('hide');
                //                         table.rows('.selected').deselect();
                //                         $('#dataListTable').DataTable().ajax.reload();
                //                         $('#alert_message').fadeIn("slow"); //Check in top in this blade
                //                         $('#alert_message').addClass('alert alert-success').html(data.success);
                //                         setTimeout(function() {
                //                             $('#alert_message').fadeOut("slow");
                //                         }, 3000);
                //                     }
                //                     else if (data.disabled_demo) {
                //                         $('#alert_message').fadeIn("slow"); //Check in top in this blade
                //                         $('#alert_message').addClass('alert alert-danger').html(data.disabled_demo);
                //                         setTimeout(function() {
                //                             $('#alert_message').fadeOut("slow");
                //                         }, 3000);
                //                     }

                //                 }
                //             });
                //         });
                //         $("#inactive").on("click",function(){
                //             action_type = "inactive";
                //             console.log(idsArray);
                //             $.ajax({
                //                 url: "{{route('admin.category.bulk_action')}}",
                //                 method: "GET",
                //                 data: {idsArray:idsArray,action_type:action_type},
                //                 success: function (data) {
                //                     if(data.success){
                //                         $('#bulkConfirmModal').modal('hide');
                //                         table.rows('.selected').deselect();
                //                         $('#dataListTable').DataTable().ajax.reload();
                //                         $('#alert_message').fadeIn("slow"); //Check in top in this blade
                //                         $('#alert_message').addClass('alert alert-success').html(data.success);
                //                         setTimeout(function() {
                //                             $('#alert_message').fadeOut("slow");
                //                         }, 3000);
                //                     }
                //                     else if (data.disabled_demo) {
                //                         $('#alert_message').fadeIn("slow"); //Check in top in this blade
                //                         $('#alert_message').addClass('alert alert-danger').html(data.disabled_demo);
                //                         setTimeout(function() {
                //                             $('#alert_message').fadeOut("slow");
                //                         }, 3000);
                //                     }
                //                 }
                //             });
                //         });

                //         //Bulk Delete
                //         $("#bulkDelete").on("click",function(){
                //             $.ajax({
                //                 url: "{{route('admin.category.bulk_delete')}}",
                //                 method: "GET",
                //                 data: {idsArray:idsArray},
                //                 success: function (data) {
                //                     console.log(data);
                //                     if(data.success){
                //                         $('#bulkConfirmModal').modal('hide');
                //                         table.rows('.selected').deselect();
                //                         $('#dataListTable').DataTable().ajax.reload();
                //                         $('#alert_message').fadeIn("slow"); //Check in top in this blade
                //                         $('#alert_message').addClass('alert alert-success').html(data.success);
                //                         setTimeout(function() {
                //                             $('#alert_message').fadeOut("slow");
                //                         }, 3000);
                //                     }
                //                     else if (data.disabled_demo) {
                //                         $('#alert_message').fadeIn("slow"); //Check in top in this blade
                //                         $('#alert_message').addClass('alert alert-danger').html(data.disabled_demo);
                //                         setTimeout(function() {
                //                             $('#alert_message').fadeOut("slow");
                //                         }, 3000);
                //                     }
                //                 }
                //             });
                //         });
                //     }
                // });

                //---------- Active ------------
                @include('admin.includes.common_js.active_js',['route_name'=>'admin.category.active'])

                //---------- Inactive ------------
                @include('admin.includes.common_js.inactive_js',['route_name'=>'admin.category.inactive'])

                //---------- Delete ------------
                @include('admin.includes.common_js.delete_js',['route_name'=>'admin.category.delete'])

                //---------- Bulk Action ------------
                @include('admin.includes.common_js.bulk_action_js',['route_name_bulk_active_inactive'=>'admin.category.bulk_action', 'route_name_bulk_delete'=>'admin.category.bulk_delete'])

            })(jQuery);
        </script>

        <!---------- Delete ------------- >
        {{-- @include('admin.includes.delete_js',['route_name'=>'admin.category.delete']) --}}




    @endpush
