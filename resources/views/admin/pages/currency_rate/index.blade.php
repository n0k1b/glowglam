@extends('admin.main')
@section('title','Admin | Currency')
@section('admin_content')

<section>
    <div class="container-fluid"><span id="alert_message"></span></div>

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">{{__('file.Currency Rates')}}</h4>
        <br>
    </div>

    <div class="table-responsive">
        <table id="data_list_table" class="table ">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th scope="col">{{trans('file.Currency')}}</th>
                     <th scope="col">{{trans('file.Code')}}</th>
                    <th scope="col">{{trans('file.Symbol')}}</th>
                    <th scope="col">{{trans('file.Rate')}}</th>
                    <th scope="col">{{trans('file.Action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>


<!--Edit Modal -->
<div class="modal fade" id="EditformModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel"><b>@lang('file.Edit Tax')</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="alertMessageEdit" role="alert"></div>

        <div class="modal-body">
            <form method="POST" id="updateForm" action="">
                @csrf

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Rate')</label>
                            <input type="text" class="col-md-8 form-control" name="currency_rate" id="currency_rate">
                            <input type="hidden" class="col-md-8 form-control" name="id" id="id">
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Symbol')</label>
                            <input type="text" class="col-md-8 form-control" name="currency_symbol" id="currency_symbol">
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <div id="alertMessageBox">
                            <div id="alertMessage" class="text-light"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary" id="save-button">@lang('file.Update')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('file.Close')</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @push('scripts')
    <script type="text/javascript">
        (function ($) {
          "use strict";

            $(document).ready(function () {

                let table = $('#data_list_table').DataTable({
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
                        url: "{{ route('admin.currency_rate.index') }}",
                    },
                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'currency_name',
                            name: 'currency_name',
                        },
                        {
                            data: 'currency_code',
                            name: 'currency_code',
                        },
                        {
                            data: 'currency_symbol',
                            name: 'currency_symbol',
                        },
                        {
                            data: 'currency_rate',
                            name: 'currency_rate',
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

            // ------------ Edit ------------------
            $(document).on("click",".edit",function(e){
                e.preventDefault();
                var currencyRateId = $(this).data("id");
                var currency_symbol = $('#currency_symbol').val();

                $.ajax({
                    url: "{{route('admin.currency_rate.edit')}}",
                    type: "GET",
                    data: {currency_rate_id:currencyRateId,currency_symbol:currency_symbol},
                    success: function(data){
                        $('#currency_rate').val(data.currency_rate);
                        $('#currency_symbol').val(data.currency_symbol);
                        $('#id').val(data.id);
                        $('#EditformModal').modal('show');
                    }
                });
            });

            //----------Update Data----------------------
            $("#updateForm").on("submit",function(e){
                e.preventDefault();

                var formData = new FormData(this); //For Image always use this method

                $.ajax({
                    url: "{{route('admin.currency_rate.update')}}",
                    type: "POST",
                    data: formData,
                    contentType: false, //That means we send mulitpart/data
                    processData: false, //deafult value is true- that means pass data as object/string. false is opposite.
                    success: function(data){
                        console.log(data);
                        if (data.errors) {
                            $("#alertMessageEdit").addClass('bg-danger text-center text-light p-1').html(data.errors) //Check in create modal
                        }
                        else if(data.success){
                            $("#EditformModal").modal('hide');
                            $('#data_list_table').DataTable().ajax.reload();
                            $('#updatetForm')[0].reset();
                            $('select').selectpicker('refresh');
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                            ("#alertMessageEdit").removeClass('bg-danger text-center text-light p-1');
                        }
                    }
                });
            });


            })(jQuery);
        </script>
    @endpush

