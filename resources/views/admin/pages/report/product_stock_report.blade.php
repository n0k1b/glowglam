@extends('admin.main')
@section('title','Report | Products Stock Report')
@section('admin_content')


<section>

    <div class="container-fluid mb-3 ml-3">
        <h2 class="font-weight-bold mt-3">@lang('file.Reports')</h2>
        <br>
    </div>

        <h4 class="mb-3 ml-4">@lang('file.Products Stock Report') </h4>
        <div class="table-responsive ml-3">
            <div class="row">
                <div class="col-md-8">
                    <table id="datatable1" class="table">
                        <thead>
                            <tr>
                                <th class="wd-15p">@lang('file.Product')</th>
                                <th class="wd-15p">@lang('file.Qty')</th>
                                <th class="wd-15p">@lang('file.Stock Availability')</th>
                            </tr>
                        </thead>
                        <tbody id="reportResult">
                            @forelse ($product_stock_reports as $item)
                                <tr>
                                    <td>{{$item->productTranslation->product_name ?? $item->productTranslationEnglish->product_name ?? null}}</td>
                                    <td>{{$item->qty ?? 'No Traking Inventory'}}</td>
                                    <td>{{$item->in_stock==1  ? 'In Stock':'Out Stock'}}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">@lang('file.Filter')</h4>
                            <form action="{{route('admin.reports.product_stock_report')}}" id="filterForm" method="get">

                                <div class="form-group mt-4">
                                    <h5 class="mt-2 card-subtitle mb-2 text-muted">Report Type</h5>
                                    <select name="report_type" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" onchange="location = this.value;">
                                        <option value="{{route('admin.reports.product_stock_report')}}">@lang('file.Product Stock Report')</option>
                                        <option value="{{route('admin.reports.coupon')}}">@lang('file.Coupon Report')</option>
                                        <option value="{{route('admin.reports.customer_orders')}}">@lang('file.Customer Order Report')</option>
                                        <option value="{{route('admin.reports.product_view_report')}}">@lang('file.Product View Report')</option>
                                        <option value="{{route('admin.reports.sales_report')}}">@lang('file.Sales Report')</option>
                                        <option value="{{route('admin.reports.search_report')}}">@lang('file.Search Report')</option>
                                        <option value="{{route('admin.reports.shipping_report')}}">@lang('file.Shpping Report')</option>
                                        <option value="{{route('admin.reports.tax_report')}}">@lang('file.Tax Report')</option>
                                        <option value="{{route('admin.reports.product_purchase_report')}}">@lang('file.Product Purchase Report')</option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="exampleInputEmail1">@lang('file.Quantity Above')</label>
                                    <input type="text" name="quantity_above" class="form-control">
                                </div>

                                <div class="form-group mt-4">
                                    <label for="exampleInputEmail1">@lang('file.Quantity Bellow')</label>
                                    <input type="text" name="quantity_bellow" class="form-control">
                                </div>

                                <div class="form-group mt-4">
                                    <h5 class="mt-4 card-subtitle mb-2 text-muted">@lang('file.Stock Availity')</h5>
                                    <select name="stock_availity" class="form-control">
                                        <option value="">@lang('file.-- Select --')</option>
                                        <option value="1">@lang('file.In Stock')</option>
                                        <option value="0">@lang('file.Out of Stock')</option>
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
    $(function(){
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
                url: "{{route('admin.reports.product_stock_report')}}",
                method: "GET",
                data: $('#filterForm').serialize(),
                success: function (data) {
                    $('#reportResult').html(data);
                }
            });
        });

    });
  </script>
@endsection
