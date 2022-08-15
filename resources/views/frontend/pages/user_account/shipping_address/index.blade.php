@extends('frontend.layouts.master')
@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="page-title">@lang('file.My Account')</h1>
                    <ul>
                        <li><a href="home.html">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.My Account')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->

    @include('frontend.includes.alert_message')

    <!--My account Dashboard starts-->
    <section class="my-account-section">
        <div class="container">
            <div class="row">

                <!-- Profile Common -->
                @include('frontend.pages.user_account.profile_common')


                <div class="col-md-9 tabs style1">
                    <div class="row">

                        <!-- Tab -->
                        @include('frontend.pages.user_account.tab_common')


                        <!-- Create -->
                        @include('frontend.pages.user_account.shipping_address.create')

                        <!-- Error Message -->
                            @include('frontend.includes.error_message')
                        <!-- Error Message -->

                        <!-- Success Message -->
                            @include('frontend.includes.success_message')
                        <!-- Success Message -->


                        <div class="accordion" id="accordionExample">

                            @foreach ($userShippingAddress as $key=>$item)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading_{{$item->id}}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$item->id}}" aria-expanded="true" aria-controls="collapse_{{$item->id}}">@lang('file.Shipping Address') - #{{$key+1}}</button>
                                    </h2>
                                    <div id="collapse_{{$item->id}}" class="accordion-collapse collapse {{$item->is_default==1 ? 'show':''}}" aria-labelledby="heading_{{$item->id}}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <form action="{{route('shipping_addrees.update',$item->id)}}" method="post">
                                                @csrf

                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label><b>* @lang('file.Select Country')</b></label>
                                                        <select class="form-control" name="country">
                                                            <option value="">* @lang('file.Select Country')</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{$country->country_name}}" {{$country->country_name==$item->country ? 'selected':''}}>{{$country->country_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label><b>@lang('file.Street Address')</b></label>
                                                        <input class="form-control" type="text" name="address_1" value="{{$item->address_1}}">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label><b>@lang('file.Apartment, suite, unit etc. (optional)')</b></label>
                                                        <input class="form-control" type="text" name="address_2" value="{{$item->address_2}}">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label><b>@lang('file.City/Town')</b></label>
                                                        <input class="form-control" type="text" name="city" value="{{$item->city}}">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label><b>@lang('file.State')</b></label>
                                                        <input class="form-control" type="text" name="state" value="{{$item->state}}">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label><b>@lang('file.Postcode / Zip')</b></label>
                                                        <input class="form-control" type="text" name="zip_code" value="{{$item->zip_code}}">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <input class="form-check-input" type="radio" name="is_default" value="1" {{$item->is_default==1 ? 'checked':''}}>
                                                        <label class="form-check-label"><b>@lang('file.Default')</b></label>
                                                    </div>
                                                    <div class="col-sm-6 mt-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 mr-2 mt-3">
                                                        <button type="submit" class="btn btn-primary">@lang('file.Update')</button>
                                                        @if ($item->is_default == 1)
                                                            <a href="" class="btn btn-danger" onclick="return confirm('Please at first set a default billing address from any one')">@lang('file.Delete')</a>
                                                        @else
                                                            <a href="{{route('shipping_addrees.delete',$item->id)}}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger">@lang('file.Delete')</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            @endforeach



                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--My account Dashboard ends-->
@endsection
