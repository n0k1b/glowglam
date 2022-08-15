@extends('admin.main')
@section('title','Admin | Flash Sale | Edit')
@section('admin_content')

<section>
    <div class="container-fluid"><span id="form_result"></span></div>
    @include('admin.includes.alert_message')

    <!-- Error Message -->
    @include('admin.includes.error_message')
    <!-- Error Message -->

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3"><a class="btn btn-sm btn-default mr-1" href="{{route('admin.flash_sale.index')}}"><i class="dripicons-arrow-thin-left"></i></a> @lang('file.Edit Flash Sale')</h4>
        <div id="success_alert" role="alert"></div>
        <br>
    </div>

    <div class="container-fluid">
        <form action="{{route('admin.flash_sale.update',$flashSale->id)}}" id="submitForm" method="POST">
            @csrf
            <input type="hidden" name="flash_sale_id" value="{{$flashSale->id}}">

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-bold">@lang('file.Campaign Name') <span class="text-danger">*</span></label>

                                @if ($flashSale->flashSaleTranslation!=NULL)
                                    <input type="text" required name="campaign_name" class="form-control" value="{{$flashSale->flashSaleTranslation->campaign_name}}">
                                    <input type="hidden" name="flash_sale_translation_id" value="{{$flashSale->flashSaleTranslation->id ??$flashSale->flashSaleTranslationEnglish->id }}">
                                @else
                                    <input type="text" required name="campaign_name" class="form-control" placeholder="@lang('file.Campaign Name')">
                                @endif
                            </div>
                            <div class="variants">

                            @foreach ($flashSale->flashSaleProducts as $flahSaleProduct)
                                <div class="row">
                                    <div class="col-10">
                                        <h5><i class="dripicons-view-apps" aria-hidden="true"></i> @lang('file.Flash Sale Product')</h5>
                                    </div>
                                    <div class="col-2">
                                        <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label><b>@lang('file.Product Name') <span class="text-danger">*</span></b></label>
                                            <select name="product_id[]" required class="form-control @error('product_id') is-invalid @enderror selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Product')}}'>
                                                @forelse ($products as $item)
                                                    <option value="{{$item->id}}" @if($item->id == $flahSaleProduct->product_id) selected @endif>{{$item->productTranslation->product_name ?? $item->productTranslationEnglish->product_name ?? null}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('product_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mt-2 form-row">
                                            <div class="form-group col-md-4">
                                                <label class="text-bold">@lang('file.End Date') <span class="text-danger">*</span></label>
                                                <input type="date" required name="end_date[]" value="{{$flahSaleProduct->end_date}}" class="form-control @error('end_date') is-invalid @enderror" >
                                                @error('end_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-bold">@lang('file.Price') <span class="text-danger">*</span></label>
                                                <input type="text" required name="price[]" value="{{$flahSaleProduct->price}}" class="form-control @error('price') is-invalid @enderror" placeholder="@lang('file.Price')">
                                                @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-bold">@lang('file.Quantity') <span class="text-danger">*</span></label>
                                                <input type="number" required min="0" name="qty[]" value="{{$flahSaleProduct->qty}}" class="form-control @error('qty') is-invalid @enderror" placeholder="@lang('file.Quantity')">
                                                @error('qty')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                            </div>
                            <span class="btn btn-link add-more" id="addMore"><i class="dripicons-plus"></i> Add More</span>
                            <br><br>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="text-bold">@lang('file.Status')</span></label>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="is_active" value='1' @if($flashSale->is_active==1) checked @endif id="isActive">
                                    <span>{{__('file.Active')}}</span>
                                </div>
                            </div>
                            <br><br>
                            <div class="d-flex justify-content-start">
                                <button type="submit" class="btn btn-success btn-block">{{__('file.Update')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

</section>

@endsection

@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            $(document).on('click', '#addMore', function(){

                var html = '<div class="row">'+
                    '<div class="col-10">'+
                        '<h5><i class="dripicons-view-apps" aria-hidden="true"></i> @lang("file.Flash Sale Product")</h5>'+
                    '</div>'+
                    '<div class="col-2">'+
                        '<span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>'+
                    '</div>'+

                    '<div class="col-md-12">'+
                        '<div class="form-group">'+
                            '<label><b>Product Name <span class="text-danger">*</span></b></label>'+
                            '<select name="product_id[]" required class="form-control">'+
                                '<option value="">Select Product</option>'+
                                    '@forelse ($products as $item)'+
                                        '<option value="{{$item->id}}" @if($item->id == $flahSaleProduct->product_id) selected @endif>{{$item->productTranslation->product_name ?? $item->productTranslationEnglish->product_name ?? null}}</option>'+
                                    '@empty'+
                                    '@endforelse'+
                            '</select>'+
                            '@error("product_id")'+
                                '<div class="text-danger">{{ $message }}</div>'+
                            '@enderror'+
                        '</div>'+

                        '<div class="mt-2 form-row">'+
                            '<div class="form-group col-md-4">'+
                                '<label class="text-bold">End Date <span class="text-danger">*</span></label>'+
                                '<input type="date" required name="end_date[]" id="end_date" class="form-control @error("end_date") is-invalid @enderror" placeholder="Date">'+
                                '@error("end_date")'+
                                    '<div class="text-danger">{{ $message }}</div>'+
                                '@enderror'+
                            '</div>'+
                            '<div class="form-group col-md-4">'+
                                '<label class="text-bold">Price <span class="text-danger">*</span></label>'+
                                '<input type="text" required name="price[]" class="form-control @error("price") is-invalid @enderror" placeholder="Price">'+
                                '@error("price")'+
                                    '<div class="text-danger">{{ $message }}</div>'+
                            ' @enderror'+
                            '</div>'+
                            '<div class="form-group col-md-4">'+
                                '<label class="text-bold">Quantity <span class="text-danger">*</span></label>'+
                                '<input type="text" required name="qty[]" class="form-control @error("qty") is-invalid @enderror" placeholder="Quantity">'+
                                '@error("qty")'+
                                    '<div class="text-danger">{{ $message }}</div>'+
                                '@enderror'+
                            '</div>'+
                    ' </div>'+
                    '</div>'+
                '</div><hr>';

                console.log(html);
                var rand = Math.floor(Math.random() * 90000) + 10000;
                $('.variants').append(html);
            })

            $(document).on('click', '.del-row', function(){
                $(this).parent().parent().html('');
            })

            $(document).ready(function(){
                $(".mul-select").select2({
                        placeholder: "Select Category", //placeholder
                        tags: true,
                        tokenSeparators: ['/',',',';'," "]
                });
            })


        })(jQuery);
    </script>
@endpush


