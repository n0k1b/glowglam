@extends('admin.main')
@section('title','Admin | Menus')
@section('admin_content')
<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    <div class="container-fluid mb-3">

		<div class="d-flex">
			<div class="p-2">
				<h2 class="font-weight-bold mt-3">{{trans('file.Menus')}}</h2>
				<div id="alert_message" role="alert"></div>
        		<br>
			</div>
			<div class="ml-auto p-2">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">{{trans('file.Dashboard')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{__('file.Menu')}}</li>
					</ol>
				</nav>
			</div>
		</div>

        @if (auth()->user()->can('menu-store'))
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i> {{trans('file.Add_Menu')}}</button>
        @endif
        @if (auth()->user()->can('menu-action'))
            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                <i class="fa fa-minus-circle"></i> {{trans('file.Bulk Action')}}
            </button>
        @endif
    </div>

    <div class="table-responsive">
    	<table id="data_table_list" class="table ">
    	    <thead>
        	   <tr>
        		    <th class="not-exported"></th>
        		    <th scope="col">{{__('file.Menu Name')}}</th>
        		    <th scope="col">{{__('file.Status')}}</th>
        		    <th scope="col">{{trans('file.action')}}</th>
        	   </tr>
    	  	</thead>
    	</table>
    </div>
</section>

@include('admin.pages.menu.create_modal')
@include('admin.pages.menu.edit_modal')
@include('admin.includes.confirm_modal')

@endsection

@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                let table = $('#data_table_list').DataTable({
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
                        url: "{{ route('admin.menu') }}",
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'menu_name',
                            name: 'menu_name',
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


            //----------Insert Data----------------------
            $("#save-button").on("click",function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{route('admin.menu.store')}}",
                    type: "POST",
                    data: $('#submitForm').serialize(),
                    success: function(data){
                        console.log(data);
                        if (data.errors) {
                            var html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#error_message').html(html);
                            setTimeout(function() {
                                $('#error_message').fadeOut("slow");
                            }, 3000);
                        }
                        else if(data.success){
                            $("#createModalForm").modal('hide');
                            $('#data_table_list').DataTable().ajax.reload();
                            $('#submitForm')[0].reset();
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            $('#alert_message').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                            // ("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                        }
                    }
                });
            });

            //---------- Edit -------------
            $(document).on('click', '.edit', function () {
                var rowId = $(this).data("id");
                $('#success_alert').html('');

                $.ajax({
                    url: "{{route('admin.menu.edit')}}",
                    type: "GET",
                    data: {menu_id:rowId},
                    success: function (data) {
                        console.log(data);

                        $('#menu_id').val(data.menu.id);
                        $('#menu_translation_id').val(data.menuTranslation.id);

                        if (data.menuTranslation.menu_name!=null) {
                            $('#menu_name_edit').val(data.menuTranslation.menu_name);
                        }else{
                            $('#menu_name_edit').empty();
                        }

                        if (data.menu.is_active == 1) {
                                $('#is_active_edit').prop('checked', true);
                        } else {
                            $('#is_active_edit').prop('checked', false);
                        }
                        $('#editModal').modal('show');
                    }
                })
            });


            //---------- Update -------------
            $("#updateForm").on("submit",function(e){
                e.preventDefault();

                // console.log('ok');

                $.ajax({
                    url: "{{route('admin.menu.update')}}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#error_message_edit').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                        else if(data.success){
                            $('#data_table_list').DataTable().ajax.reload();
                            $('#updateForm')[0].reset();
                            $("#editModal").modal('hide');
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            $('#alert_message').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });

            //---------- Active -------------
            $(document).on("click",".active",function(e){
                e.preventDefault();
                var id = $(this).data("id");

                $.ajax({
                    url: "{{route('admin.menu.active')}}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            $('#data_table_list').DataTable().ajax.reload();
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            $('#alert_message').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
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
                    url: "{{route('admin.menu.inactive')}}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            $('#data_table_list').DataTable().ajax.reload();
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            $('#alert_message').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });

            //Bulk Action
            $("#bulk_action").on("click",function(){
                var idsArray = [];
                let table = $('#data_table_list').DataTable();
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
                            url: "{{route('admin.menu.bulk_action')}}",
                            method: "GET",
                            data: {idsArray:idsArray,action_type:action_type},
                            success: function (data) {
                                if(data.success){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#data_table_list').DataTable().ajax.reload();
                                    $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                    $('#alert_message').addClass('alert alert-success').html(data.success);
                                    setTimeout(function() {
                                        $('#alert_message').fadeOut("slow");
                                    }, 3000);
                                }
                            }
                        });
                    });
                    $("#inactive").on("click",function(){
                        action_type = "inactive";
                        console.log(idsArray);
                        $.ajax({
                            url: "{{route('admin.menu.bulk_action')}}",
                            method: "GET",
                            data: {idsArray:idsArray,action_type:action_type},
                            success: function (data) {
                                if(data.success){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#data_table_list').DataTable().ajax.reload();
                                    $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                    $('#alert_message').addClass('alert alert-success').html(data.success);
                                    setTimeout(function() {
                                        $('#alert_message').fadeOut("slow");
                                    }, 3000);
                                }
                            }
                        });
                    });
                }
            });


        })(jQuery);
    </script>
@endpush

