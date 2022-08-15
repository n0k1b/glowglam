@extends('admin.main')
@section('title','Admin | Order')
@section('admin_content')


<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">{{__('Orders')}}</h4>
        <div id="success_alert" role="alert"></div>
        <br>

    </div>
    <div class="table-responsive">
    	<table id="orderTable" class="table ">
    	    <thead>
        	   <tr>
        		    <th class="not-exported"></th>
                    <th scope="col">{{trans('file.Order No')}}</th>
                    <th scope="col">{{trans('file.Status')}}</th>
                    <th scope="col">{{trans('file.Delivery Date')}}</th>
                    <th scope="col">{{trans('file.Delivery Time')}}</th>
        		    <th scope="col">{{trans('file.Customer Name')}}</th>
                    <th scope="col">{{trans('file.Customer Email')}}</th>
        		    <th scope="col">{{trans('file.Total')}}</th>
        		    <th scope="col">{{trans('file.Created')}}</th>
        	   </tr>
    	  	</thead>
    	</table>
    </div>
</section>
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
                    let table = $('#orderTable').DataTable({
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
                            url: "{{ route('admin.order.index') }}",
                        },
                        columns: [
                            {
                                data: null,
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'order_id',
                                name: 'order_id',
                            },
                            {
                                data: 'order_status',
                                name: 'order_status',
                            },
                            {
                                data: 'delivery_date',
                                name: 'delivery_date',
                            },
                            {
                                data: 'delivery_time',
                                name: 'delivery_time',
                            },
                            {
                                data: 'customer_name',
                                name: 'customer_name',
                            },
                            {
                                data: 'customer_email',
                                name: 'customer_email',
                            },
                            {
                                data: 'total',
                                name: 'total',
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                            },
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

                $(document).on('click', '.date_field', function () {
                    $(".update_btn").attr("hidden",true);
                    $(this).siblings('.update_btn').removeAttr('hidden');;
                });

                $(document).on('click', '.update_btn', function () {
                    var rowId = $(this).data("id");
                    var date  = $(this).siblings('.date_field').val();
                    console.log(date);
                    $.ajax({
                        url: "{{route('admin.order.order_date')}}",
                        type: "POST",
                        data: {id:rowId,date:date},
                        success: function (data) {
                            if(data.success){
                                $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                $('#success_alert').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#success_alert').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    })
                });

                $(document).on('click', '.time_field', function () {
                    $(".update_time_btn").attr("hidden",true);
                    $(this).siblings('.update_time_btn').removeAttr('hidden');;
                });

                $(document).on('click', '.update_time_btn', function () {
                    var rowId = $(this).data("id");
                    var time  = $(this).siblings('.time_field').val();
                    $.ajax({
                        url: "{{route('admin.order.delivery_time')}}",
                        type: "POST",
                        data: {id:rowId,time:time},
                        success: function (data) {
                            if(data.success){
                                $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                $('#success_alert').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#success_alert').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    })
                });

                $('.date_field').datepicker().on('changeDate', function (ev) {
                    $('.date_field').Close();
                });

            })(jQuery);
    </script>
@endpush
