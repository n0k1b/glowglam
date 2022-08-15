@extends('admin.main')
@section('title','Admin | Brand')
@section('admin_content')
<section>

    <div class="container-fluid"><span id="alert_message"></span></div>

    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">@lang('file.Brand')</h4>
        <br>

        @if (auth()->user()->can('brand-store'))
            <button type="button" class="btn btn-info" name="create_record" id="create_record">
                <i class="fa fa-plus"></i> @lang('file.Add Brand')
            </button>
        @endif
        @if (auth()->user()->can('brand-action'))
            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                <i class="fa fa-minus-circle"></i> {{trans('file.Bulk_Action')}}
            </button>
        @endif

    </div>
    <div class="table-responsive">
    	<table id="dataListTable" class="table ">
    	    <thead>
        	   <tr>
        		    <th class="not-exported"></th>
                    <th scope="col">@lang('file.Logo')</th>
        		    <th scope="col">@lang('file.Brand Name')</th>
        		    <th scope="col">@lang('file.Status')</th>
        		    <th scope="col">@lang('file.Action')</th>
        	   </tr>
    	  	</thead>
    	</table>
    </div>

</section>

@include('admin.pages.brand.create')
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
                        url: "{{ route('admin.brand') }}",
                    },
                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'brand_logo',
                            name: 'brand_logo',
                        },
                        {
                            data: 'brand_name',
                            name: 'brand_name',
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render:function (data) {
                                if (data== 1) {
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
                            // 'targets': [0, 3],
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
            $("#submitButton").on("click",function(e){
                $('#submitButton').text('Saving ...');
            });

            $("#submitForm").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{route('admin.brand.store')}}",
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
                    success: function (data) {
                        $('#dataListTable').DataTable().ajax.reload();
                        $('#submitForm')[0].reset();
                        $("#formModal").modal('hide');
                        $('#alert_message').fadeIn("slow");
                        if (data.demo) {
                            $('#alert_message').addClass('alert alert-danger').html(data.demo);
                        }else{
                            $('#alert_message').addClass('alert alert-success').html(data.success);
                        }
                        setTimeout(function() {
                            $('#alert_message').fadeOut("slow");
                        }, 3000);
                        $('#submitButton').text('Save');
                    }
                });
            });

            $('#create_record').click(function () {
                $('#action_button').val('{{trans("file.Add")}}');
                $('#action').val('{{trans("file.Add")}}');
                $('#formModal').modal('show');
            });

            //---------- Active ------------
            @include('admin.includes.common_js.active_js',['route_name'=>'admin.brand.active'])

            //---------- Inactive ------------
            @include('admin.includes.common_js.inactive_js',['route_name'=>'admin.brand.inactive'])

            //---------- Bulk Action ------------
            @include('admin.includes.common_js.bulk_action_js',['route_name_bulk_active_inactive'=>'admin.brand.bulk_action'])

        })(jQuery);
    </script>
@endpush
