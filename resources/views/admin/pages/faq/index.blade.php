@extends('admin.main')
@section('title','Admin | Faq ')
@section('admin_content')

<section>
    <div class="container-fluid"><span id="alert_message"></span></div>
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">{{__('FAQ')}}</h4>
        <br>
        <button type="button" class="btn btn-info" name="formModal" data-toggle="modal" data-target="#formModal">
            <i class="fa fa-plus"></i> {{__('file.Add FAQ')}}
        </button>
        <button type="button" class="btn btn-danger" id="bulk_action">
            <i class="fa fa-minus-circle"></i> {{trans('file.Bulk Action')}}
        </button>
    </div>

    <div class="table-responsive">
        <table id="dataListTable" class="table ">
    	    <thead>
        	   <tr>
                    <th class="not-exported"></th>
                    <th scope="col">{{trans('file.Type')}}</th>
                    <th scope="col">{{trans('file.Title')}}</th>
                    <th scope="col">{{trans('file.Description')}}</th>
                    <th scope="col">{{trans('file.Status')}}</th>
                    <th scope="col">{{trans('file.action')}}</th>
        	   </tr>
    	  	</thead>
    	</table>
    </div>
</section>

@include('admin.pages.faq.create_modal')
@include('admin.pages.faq.edit_modal')
@include('admin.includes.confirm_modal')

@endsection

@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

                $(document).ready(function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let table = $('#dataListTable').DataTable({
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
                            url: "{{ route('admin.faq.index') }}",
                        },
                        columns: [
                            {
                                data: null,
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'type',
                                name: 'type',
                            },
                            {
                                data: 'title',
                                name: 'title',
                            },
                            {
                                data: 'description',
                                name: 'description',
                            },
                            {
                                data: 'is_active',
                                name: 'is_active',
                                render:function (data) {
                                    if (data == 1) {
                                        return "<span class='p-2 badge badge-success'>Active</span>";
                                    }else{
                                        return "<span class='p-2 badge badge-warning'>Inactive</span>";
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

                $('#submitForm').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.faq.store')}}",
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
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#error_message').fadeIn("slow");
                                $('#error_message').html(html);
                                setTimeout(function() {
                                    $('#error_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#dataListTable').DataTable().ajax.reload();
                                $('#submitForm')[0].reset();
                                $("#formModal").modal('hide');
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            $('.save').text('Save');
                        }
                    });
                });

                //---------- Show data by id-------------
                $(document).on('click', '.edit', function () {
                    var id = $(this).data("id");
                    $.ajax({
                        url: "{{route('admin.faq.edit')}}",
                        type: "GET",
                        data: {faq_id:id},
                        success: function (data) {
                            console.log(data.faqTranslation.id);
                            $('#faqId').val(id);
                            $('#faqTranslationId').val(data.faqTranslation.id);
                            $('#faqTypeId').selectpicker('val', data.faq.faq_type_id);
                            $('#title').val(data.faqTranslation.title);
                            $('#description').val(data.faqTranslation.description);
                            if (data.faq.is_active == 1) {
                                $('#isActive').prop('checked', true);
                            }else {
                                $('#isActive').prop('checked', false);
                            }
                            $('#editFormModal').modal('show');
                        }
                    })
                });

                $('#updateButton').on('click', function (e) {
                    $('#updateButton').text('Updating...');
                });

                //----Update -----
                $('#updateForm').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.faq.update')}}",
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
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#error_message_edit').fadeIn("slow");
                                $('#error_message_edit').html(html);
                                setTimeout(function() {
                                    $('#error_message_edit').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#dataListTable').DataTable().ajax.reload();
                                $('#updateForm')[0].reset();
                                $("#editFormModal").modal('hide');
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            $('#updateButton').text('Update');
                        }
                    });
                });


                //---------- Active -------------
                $(document).on("click",".active",function(e){
                    e.preventDefault();
                    var id = $(this).data("id");
                    var element = this;
                    $.ajax({
                        url: "{{route('admin.faq.active')}}",
                        type: "GET",
                        data: {id:id},
                        success: function(data){
                            console.log(data);
                            if (data.errors) {
                                $('#dataListTable').DataTable().ajax.reload();
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').addClass('alert alert-danger').html(data.errors);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#dataListTable').DataTable().ajax.reload();
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
                    var element = this;
                    $.ajax({
                        url: "{{route('admin.faq.inactive')}}",
                        type: "GET",
                        data: {id:id},
                        success: function(data){
                            console.log(data);
                            if (data.errors) {
                                $('#dataListTable').DataTable().ajax.reload();
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').addClass('alert alert-danger').html(data.errors);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#dataListTable').DataTable().ajax.reload();
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });

                //---------- Delete -------------
                $(document).on("click",".delete",function(e){
                    e.preventDefault();
                    let id = $(this).data("id");

                    if (!confirm('Are you sure you want to continue?')) {
                        alert(false);
                    }else{
                        $.ajax({
                            url: "{{route('admin.faq.delete')}}",
                            type: "GET",
                            data: {id:id},
                            success: function(data){
                                $('#alert_message').fadeIn("slow");
                                if (data.errors) {
                                    $('#dataListTable').DataTable().ajax.reload();
                                    $('#alert_message').addClass('alert alert-danger').html(data.errors);
                                }
                                else if(data.success){
                                    $('#dataListTable').DataTable().ajax.reload();
                                    $('#alert_message').addClass('alert alert-success').html(data.success);
                                }
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        });
                    }
                });

                //---------- Bulk Action ------------
                $("#bulk_action").on("click",function(){
                    var idsArray = [];
                    let table = $('#dataListTable').DataTable();
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
                                url: "{{route('admin.faq.bulk_action')}}",
                                method: "GET",
                                data: {idsArray:idsArray,action_type:action_type},
                                success: function (data) {
                                    $('#bulkConfirmModal').modal('hide');
                                    if (data.errors) {
                                        $('#dataListTable').DataTable().ajax.reload();
                                        $('#alert_message').fadeIn("slow");
                                        $('#alert_message').addClass('alert alert-danger').html(data.errors);
                                        setTimeout(function() {
                                            $('#alert_message').fadeOut("slow");
                                        }, 3000);
                                    }
                                    else if(data.success){
                                        table.rows('.selected').deselect();
                                        $('#dataListTable').DataTable().ajax.reload();
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
                                url: "{{route('admin.faq.bulk_action')}}",
                                method: "GET",
                                data: {idsArray:idsArray,action_type:action_type},
                                success: function (data) {
                                    $('#bulkConfirmModal').modal('hide');
                                    if (data.errors) {
                                        $('#dataListTable').DataTable().ajax.reload();
                                        $('#alert_message').fadeIn("slow");
                                        $('#alert_message').addClass('alert alert-danger').html(data.errors);
                                        setTimeout(function() {
                                            $('#alert_message').fadeOut("slow");
                                        }, 3000);
                                    }
                                    else if(data.success){
                                        table.rows('.selected').deselect();
                                        $('#dataListTable').DataTable().ajax.reload();
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

