<!-- Button trigger modal -->
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-primary  mb-5" data-bs-toggle="modal" data-bs-target="#createShippingAddress">@lang('file.Create')</button>
    </div>
</div>


<!-- Vertically centered modal -->
<div class="modal fade" id="createShippingAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('file.Create Shipping Address')</h5> &nbsp; <small><i>[Your last record act as a default shipping address]</i></small>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('shipping_addrees.store')}}" method="post">
                @csrf

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <select class="form-control" name="country">
                                <option value="">* @lang('file.Select Country')</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->country_name}}">{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input class="form-control" type="text" name="address_1" placeholder="@lang('file.Street Address')">
                        </div>

                        <div class="col-md-6">
                            <input class="form-control" type="text" name="address_2" placeholder="@lang('file.Apartment, suite, unit etc. (optional)')">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="city" placeholder="@lang('file.City/Town')">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="state" placeholder="@lang('file.State')">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="zip_code" placeholder="@lang('file.Postcode / Zip')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('file.Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('file.Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
