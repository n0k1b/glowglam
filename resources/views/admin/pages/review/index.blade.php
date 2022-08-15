@extends('admin.main')
@section('title','Admin | Review')
@section('admin_content')


<section>
    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">{{__('file.Reviews')}}</h4>
        <div id="alert_message" role="alert"></div>
        <br>
    </div>

    <div class="table-responsive">
    	<table id="reviewListTable" class="table ">
    	    <thead>
        	   <tr>
        		    <th class="not-exported"></th>
        		    <th scope="col">{{trans('file.Product')}}</th>
        		    <th scope="col">{{__('file.Reviewer Name')}}</th>
        		    <th scope="col">{{trans('file.Rating')}}</th>
        		    <th scope="col">{{trans('file.Status')}}</th>
        		    <th scope="col">{{trans('file.Action')}}</th>
        	   </tr>
    	  	</thead>
    	</table>
    </div>
</section>

@include('admin.pages.review.edit_modal')
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

                let table = $('#reviewListTable').DataTable({
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
                        url: "{{ route('admin.review.index') }}",
                    },
                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'product_name',
                            name: 'product_name',
                        },
                        {
                            data: 'reviewer_name',
                            name: 'reviewer_name',
                        },
                        {
                            data: 'rating',
                            name: 'rating',
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render:function (data) {
                                if (data == 'approved') {
                                    return "<span class='p-2 badge badge-success'>Approved</span>";
                                }else{
                                    return "<span class='p-2 badge badge-danger'>Pending</span>";
                                }
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
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

            //---------- Edit -------------
            $(document).on('click', '.edit', function () {
                var rowId = $(this).data("id");
                $('#alert_message').html('');

                $.ajax({
                    url: "{{route('admin.review.edit')}}",
                    type: "GET",
                    data: {rowId:rowId},
                    success: function (data) {
                        $('#reviewId').val(data.review.id);
                        $('#rating').selectpicker('val',data.review.rating);
                        $('#comment').val(data.review.comment);
                        if (data.review.status == 'approved') {
                                $('#status').prop('checked', true);
                        } else {
                            $('#status').prop('checked', false);
                        }
                        $('#editModal').modal('show');
                    }
                });
            });


            //---------- Update -------------
            $("#updateForm").on("submit",function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{route('admin.review.update')}}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        if(data.success){
                            $('#reviewListTable').DataTable().ajax.reload();
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
            
        })(jQuery);
    </script>
@endpush
