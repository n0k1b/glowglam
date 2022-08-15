@extends('admin.main')

@section('title','Admin | Dashboard')

@section('admin_content')
<section>
    <div class="container-fluid"><h3>@lang('file.Welcome Admin') </h3></div>
</section>
<section class="pt-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="icon">
                            <i class="dripicons-graph-line" style="color:#733686;font-size:30px;margin-right:15px"></i>
                        </div>
                        <div>
                            <span class="mb-2">
                                @if(env('CURRENCY_FORMAT')=='suffix')
                                    {{ number_format($orders->where('order_status','completed')->sum('total'), 2)}} {{env('DEFAULT_CURRENCY_SYMBOL')}}
                                @else
                                    {{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format($orders->where('order_status','completed')->sum('total'), 2)}}
                                @endif
                            </span>
                            <h1 class="card-title" style="color: #733686"> <a href="{{route('admin.reports.sales_report')}}"> @lang('file.Total Sales')</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="icon">
                            <i class="dripicons-shopping-bag" style="color:#ff8952;font-size:30px;margin-right:15px"></i>
                        </div>
                        <div>
                            <span class="mb-2">
                                @if($orders)
                                    {{$orders->where('order_status','pending')->count()}}
                                @else
                                    0
                                @endif
                            </span>
                            <h1 class="card-title" style="color: #ff8952"> <a href="{{route('admin.order.index')}}">@lang('file.Pending Orders')</a> </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="icon">
                            <i class="dripicons-archive" style="color:#00c689;font-size:30px;margin-right:15px"></i>
                        </div>
                        <div>
                            <span class="mb-2">
                                {{count($products)}}
                            </span>
                            <h1 class="card-title" style="color: #00c689"><a href="{{route('admin.products.index')}}">@lang('file.Total Products')</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="icon">
                            <i class="dripicons-user-group" style="color:#297ff9;font-size:30px;margin-right:15px"></i>
                        </div>
                        <div>
                            <span class="mb-2">
                                {{$total_customers}}
                            </span>
                            <h1 class="card-title" style="color: #297ff9"> <a href="{{route('admin.user')}}">@lang('file.Total Register Customers')</a></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">@lang('file.Top Brands')</h1>
                                <table class="table">
                                    <tbody>
                                        @forelse ($top_brands as $item)
                                            @if ($item->brand!=null)
                                                <tr>
                                                    @if($item->brand->brand_logo!==null && Illuminate\Support\Facades\File::exists(public_path($item->brand->brand_logo)))
                                                        <td><img src="{{asset('public/'.$item->brand->brand_logo)}}" height="50px" width="50px"></td>
                                                    @else
                                                        <td><img src="https://dummyimage.com/1269x300/e5e8ec/e5e8ec&text=Brand" style="background-size: cover; background-position: center;" height="50px" width="50px"></td>
                                                    @endif
                                                    <td>{{$item->brand->brandTranslation->brand_name ?? $item->brand->brandTranslationEnglish->brand_name ?? null }}</td>
                                                    <td>
                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                            {{ number_format($item->total_amount,'2')}}  {{env('DEFAULT_CURRENCY_SYMBOL')}}
                                                        @else
                                                            {{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format($item->total_amount,'2')}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">@lang('file.Top Categories')</h1>
                                <table class="table">
                                    <tbody>
                                        @forelse ($top_categories as $item)
                                            <tr>
                                                @if($item->category->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->category->image)))
                                                    <td><img src="{{asset('public/'.$item->category->image)}}" height="50px" width="50px"></td>
                                                @else
                                                    <td><img src="https://dummyimage.com/1269x300/e5e8ec/e5e8ec&text=Category" style="background-size: cover; background-position: center;" height="50px" width="50px"></td>
                                                @endif
                                                <td>{{$item->category->catTranslation->category_name ?? $item->category->categoryTranslationDefaultEnglish->category_name ?? null }}</td>
                                                <td>
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format($item->total_amount,'2')}}  {{env('DEFAULT_CURRENCY_SYMBOL')}}
                                                    @else
                                                        {{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format($item->total_amount,'2')}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <h1 class="card-title">@lang('file.Top Products')</h1>

                <div class="row">
                    @forelse ($top_products as $item)
                        <div class="col-md-2">
                            <a href="{{url('product/'.$item->product->slug.'/'. $category_ids[$item->product->id]->category_id)}}" target="__blank">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{asset('public/'.$item->baseImage->image_medium)}}" class="card-img-top">
                                        <span class="card-text mt-3">
                                            @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price<$item->product->price)
                                                @if(env('CURRENCY_FORMAT')=='suffix')
                                                    {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                @else
                                                    @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                @endif

                                                <br>
                                                <del>
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </del>
                                            @else
                                                @if(env('CURRENCY_FORMAT')=='suffix')
                                                    {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                @else
                                                    @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                @endif
                                            @endif
                                        </span>

                                        @php  $product_name = $item->orderProductTranslation->product_name ?? $item->orderProductTranslationEnglish->product_name  @endphp
                                        <p class="card-text mt-2 text-bold">{{ strlen($product_name) > 25 ? substr($product_name,0,25)."..." : $product_name}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="mb-5"></div>
                    @endforelse
                </div>
            </div>


            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="act-title">
                            <h5>@lang('file.Top Browser')</h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('file.BROWSER')</th>
                                    <th>@lang('file.SESSION')</th>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($browsers as $key=>$browser)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$browser['browser']}}</td>
                                    <td>{{$browser['sessions']}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="act-title">
                            <h5>@lang('file.Top Most Visited Pages')</h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('file.URL')</th>
                                    <th>@lang('file.VIEWS')</th>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($topVisitedPages as $key=>$topVisitedPage)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td><a href="{{$topVisitedPage['url']}}">{{$topVisitedPage['pageTitle']}}</a></td>
                                        <td>{{$topVisitedPage['pageViews']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="act-title">
                            <h5>@lang('file.Top Referrers')</h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('file.URL')</th>
                                    <th>@lang('file.VIEWS')</th>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($topReferrers as $topReferrer)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$topReferrer['url']}}</td>
                                        <td>{{$topReferrer['pageViews']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="act-title">
                            <h5>@lang('file.Top User Types')</h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('file.Type')</th>
                                    <th>@lang('file.Session')</th>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($topUserTypes as $toptopUserType)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$toptopUserType['type']}}</td>
                                        <td>{{$toptopUserType['sessions']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                    <h1 class="card-title"><i class="fa fa-shopping-cart"></i> @lang('file.Last 10 Pending Orders')</h1>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">@lang('file.Order ID')</th>
                            <th scope="col">@lang('file.Customer')</th>
                            <th scope="col">@lang('file.Status')</th>
                            <th scope="col">@lang('file.Total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders->where('order_status','pending')->take(10) as $item)
                                <tr>
                                    <th>{{$item->id}}</th>
                                    <td>{{$item->billing_first_name.' '.$item->billing_last_name}}</td>
                                    <td>{{$item->order_status}}</td>
                                    <td>
                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                            {{ number_format($item->total,'2')}}  {{env('DEFAULT_CURRENCY_SYMBOL')}}
                                        @else
                                            {{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format($item->total,'2')}}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h4><i>No order found</i></h4>
                                    </div>
                                </div>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">@lang('file.Page View Statistics')</h1>
                        <canvas id="canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<script>

    var url = "{{route('admin.dashboard.chart')}}";
    var Months = new Array();
    var Labels = new Array();
    var PageViews = new Array();
    var visitors = new Array();
    (function($){
        "use strict";
        $.get(url, function(response){
            response.forEach(function(data){
                const date = new Date(data.date);  // 2009-11-10
                const d = date.getDate();
                const m = date.getMonth()+1;
                const y = date.getFullYear();
                const y1 = new String(y);
                const month = date.toLocaleString('default', { month: 'long' });
                Months.push(d+'-'+m+'-'+y1[2]+y1[3]);
                Labels.push(data.pageTitle);
                PageViews.push(data.pageViews);
                visitors.push(data.visitors);
            });
            var ctx = document.getElementById("canvas").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels:Months,
                    datasets: [
                        {
                        label: 'Page Views',
                        borderColor: '#2f5ec4',
                        data: PageViews,
                        borderWidth: 1
                        },
                        {
                        label: 'Visitors',
                        borderColor: '#FD777B',
                        backgroundColor: '#FD777B50',
                        data: visitors,
                        borderWidth: 1
                        }

                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });
    })(jQuery);




// var url = "{{route('admin.dashboard.chart')}}";
// var Years = new Array();
// var Labels = new Array();
// var Prices = new Array();
// $(document).ready(function(){
//     $.get(url, function(response){
//         response.forEach(function(data){
//             const date = new Date(data.date);  // 2009-11-10
//             const month = date.toLocaleString('default', { month: 'long' });
//             Years.push(month);
//             Labels.push(data.pageTitle);
//             Prices.push(data.pageViews);
//         });
//         var ctx = document.getElementById("canvas").getContext('2d');
//         var myChart = new Chart(ctx, {
//             type: 'line',
//             data: {
//                 labels:Years,
//                 datasets: [{
//                     label: 'Page Views',
//                     data: Prices,
//                     borderWidth: 1
//                 }]
//             },
//             options: {
//                 scales: {
//                     yAxes: [{
//                         ticks: {
//                             beginAtZero:true
//                         }
//                     }]
//                 }
//             }
//         });
//     });
// });
</script>

@endpush


