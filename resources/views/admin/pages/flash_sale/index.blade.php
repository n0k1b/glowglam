@extends('admin.main')
@section('title','Admin | Flash Sale')
@section('admin_content')

<section>
    <div class="container-fluid"><span id="success_alert"></span></div>
    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">@lang('file.Flash Sale')</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        @if (auth()->user()->can('flash_sale-store'))
            <a href="{{route('admin.flash_sale.create')}}" class="btn btn-info">
                <i class="fa fa-plus"></i> {{__('file.Create Flash Sale')}}
            </a>
        @endif
        @if (auth()->user()->can('flash_sale-action'))
            <button type="button" class="btn btn-danger" id="bulk_action">
                <i class="fa fa-minus-circle"></i> {{__('file.Bulk Action')}}
            </button>
        @endif

    </div>
    <div class="table-responsive">
    	<table id="table" class="table ">
    	    <thead>
        	   <tr>
        		    <th class="not-exported"></th>
        		    <th scope="col">{{trans('file.Campaign Name')}}</th>
        		    <th scope="col">{{trans('file.Status')}}</th>
        		    <th scope="col">{{trans('file.Action')}}</th>
        	   </tr>
    	  	</thead>
    	</table>
    </div>
</section>

@include('admin.pages.flash_sale.confirm_modal')

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

                let table = $('#table').DataTable({
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
                        url: "{{ route('admin.flash_sale.index') }}",
                    },
                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'campaign_name',
                            name: 'campaign_name',
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


            //---------- Active -------------
            $(document).on("click",".active",function(e){
                e.preventDefault();
                var id = $(this).data("id");
                var element = this;

                $.ajax({
                    url: "{{route('admin.flash_sale.active')}}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            $('#table').DataTable().ajax.reload();
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
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
                var element = this;
                console.log(id);

                $.ajax({
                    url: "{{route('admin.flash_sale.inactive')}}",
                    type: "GET",
                    data: {id:id},
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            $('#table').DataTable().ajax.reload();
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });

            //Bulk Action
            $("#bulk_action").on("click",function(){
                var idsArray = [];
                let table = $('#table').DataTable();
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
                            url: "{{route('admin.flash_sale.bulk_action')}}",
                            method: "GET",
                            data: {idsArray:idsArray,action_type:action_type},
                            success: function (data) {
                                if(data.success){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#table').DataTable().ajax.reload();
                                    $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                    $('#success_alert').addClass('alert alert-success').html(data.success);
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
                            url: "{{route('admin.flash_sale.bulk_action')}}",
                            method: "GET",
                            data: {idsArray:idsArray,action_type:action_type},
                            success: function (data) {
                                if(data.success){
                                    $('#bulkConfirmModal').modal('hide');
                                    table.rows('.selected').deselect();
                                    $('#table').DataTable().ajax.reload();
                                    $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                    $('#success_alert').addClass('alert alert-success').html(data.success);
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
    </script>
@endpush

