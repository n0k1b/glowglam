@extends('admin.main')
@section('title','Report | Coupon')
@section('admin_content')


<section>

    <div class="container-fluid mb-3 ml-3">
        <h2 class="font-weight-bold mt-3">@lang('file.Reports')</h2>
        <br>
    </div>

        <h4 class="mb-3 ml-4">@lang('file.Coupon Report')</h4>
        <div class="table-responsive ml-3">
            <div class="row">
                <div class="col-md-8">
                    <table id="datatable1" class="table">
                        <thead>
                            <tr>
                                <th class="wd-15p">@lang('file.Date')</th>
                                <th class="wd-15p">@lang('file.Coupon Name')</th>
                                <th class="wd-15p">@lang('file.Coupon Code')</th>
                                <th class="wd-15p">@lang('file.Orders')</th>
                                <th class="wd-15p">@lang('file.Total')</th>
                            </tr>
                        </thead>
                        <tbody id="reportResult">
                            @foreach ($coupon_reports as $item)
                                @if ($item->orders->isNotEmpty())
                                    <tr>
                                        <td>
                                            {{date('d M, Y',strtotime($item->orders[0]->date))}} - {{date('d M, Y',strtotime($item->orders[count($item->orders)-1]->date))}}
                                        </td>
                                        <td>{{$item->couponTranslation->coupon_name ?? $item->couponTranslationEnglish->coupon_name ?? null}}</td>
                                        <td>{{$item->coupon_code}}</td>
                                        <td>
                                            {{$item->orders->count()}}
                                        </td>
                                        <td>
                                            @php $total_amount = 0; @endphp
                                            @forelse ($item->orders as $item)
                                                @php   $total_amount += $item->total; @endphp
                                            @empty
                                            @endforelse

                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                {{ number_format((float)$total_amount, env('FORMAT_NUMBER'), '.', '') }} {{env('DEFAULT_CURRENCY_SYMBOL')}}
                                            @else
                                                {{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format((float)$total_amount, env('FORMAT_NUMBER'), '.', '') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">@lang('file.Filter')</h4>
                            <form action="{{route('admin.reports.coupon')}}" id="filterForm" method="get">

                                <div class="form-group mt-4">
                                    <h5 class="mt-2 card-subtitle mb-2 text-muted">@lang('file.Report Type')</h5>
                                    <select class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" onchange="location = this.value;">
                                        <option value="{{route('admin.reports.coupon')}}">@lang('file.Coupon Report')</option>
                                        <option value="{{route('admin.reports.customer_orders')}}">@lang('file.Customer Order Report')</option>
                                        <option value="{{route('admin.reports.product_stock_report')}}">@lang('file.Product Stock Report')</option>
                                        <option value="{{route('admin.reports.product_view_report')}}">@lang('file.Product View Report')</option>
                                        <option value="{{route('admin.reports.sales_report')}}">@lang('file.Sales Report')</option>
                                        <option value="{{route('admin.reports.search_report')}}">@lang('file.Search Report')</option>
                                        <option value="{{route('admin.reports.shipping_report')}}">@lang('file.Shpping Report')</option>
                                        <option value="{{route('admin.reports.tax_report')}}">@lang('file.Tax Report')</option>
                                        <option value="{{route('admin.reports.product_purchase_report')}}">@lang('file.Product Purchase Report')</option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="exampleInputEmail1">@lang('file.Start Date')</label>
                                    <input type="date" class="form-control datepicker" id="exampleInputEmail1" aria-describedby="emailHelp"  name="start_date">
                                </div>

                                <div class="form-group mt-4">
                                    <label for="exampleInputEmail1">@lang('file.End Date')</label>
                                    <input type="date" class="form-control datepicker" id="exampleInputEmail1" aria-describedby="emailHelp"  name="end_date">
                                </div>


                                <div class="form-group mt-4">
                                    <h5 class="mt-4 card-subtitle mb-2 text-muted">@lang('file.Order Status')</h5>
                                    <select name="report_type" class="form-control report_type">
                                        <option value="">-- Select --</option>
                                        <option value="completed">@lang('file.Completed')</option>
                                        <option value="pending">@lang('file.Pending')</option>
                                        <option value="processing">@lang('file.Processing')</option>
                                        <option value="cancaled">@lang('file.Cancaled')</option>
                                        <option value="refund">@lang('file.Refund')</option>
                                        <option value="deliver">@lang('file.Deliver')</option>
                                        <option value="pending_payment">@lang('file.Pending Payment')</option>
                                    </select>
                                </div>

                                <button type="submit" class="mt-4 btn btn-success">@lang('file.Filter')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    (function ($) {
      'use strict';

      $('#datatable1').DataTable({
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
      });

      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

        $("#filterForm").on("submit",function(e){
            e.preventDefault();
            $.ajax({
                url: "{{route('admin.reports.coupon')}}",
                method: "GET",
                data: $('#filterForm').serialize(),
                success: function (data) {
                    $('#reportResult').html(data);
                }
            });
        });

    })(jQuery);
  </script>
@endsection
