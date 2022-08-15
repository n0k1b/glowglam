<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Store')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="storeSubmit" method="POST" action="{{route('admin.setting.store.store_or_update')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Store Name') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_name" @empty(!$setting_store) value="{{$setting_store->store_name}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Store Tagline')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_tagline" @empty(!$setting_store) value="{{$setting_store->store_tagline}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store Email') <span class="text-danger">*</span> </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_email" @empty(!$setting_store) value="{{$setting_store->store_email}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store Phone') <span class="text-danger">*</span> </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_phone" @empty(!$setting_store) value="{{$setting_store->store_phone}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store Address 1') </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_address_1" @empty(!$setting_store) value="{{$setting_store->store_address_1}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store Address 2') </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_address_2" @empty(!$setting_store) value="{{$setting_store->store_address_2}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store City')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_city" @empty(!$setting_store) value="{{$setting_store->store_city}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store Country')</b></label>
                        <div class="col-sm-8">
                            <select name="store_country" class="form-control selectpicker" data-live-search="true" title='{{__('Select Conutry')}}'>
                                @foreach ($countries as $country)
                                    <option value="{{$country->country_name}}" @empty(!$setting_store)  {{($country->country_name == $setting_store->store_country) ? "selected" : ''}} @endempty>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Store Zip')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="store_zip" @empty(!$setting_store) value="{{$setting_store->store_zip}}" @endempty class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Get In Touch')</b></label>
                        <div class="col-sm-8">
                            <textarea name="get_in_touch" cols="30" rows="5" class="form-control">@if($setting_store) {{$setting_store->get_in_touch}} @endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Admin Logo')</b></label>

                        <div class="col-sm-8">
                            <div class="d-flex justify-content-between">
                                @if($setting_store->admin_logo!==null && Illuminate\Support\Facades\File::exists(public_path($setting_store->admin_logo)))
                                    <div><img src="{{asset('public/'.$setting_store->admin_logo)}}" id="admin_logo" width="100px" height="100px"></div>
                                @else
                                    <div><img src="https://dummyimage.com/100x100/000000/0f6954.png&text=Admin-Logo"  height="100px" width="100px"></div>
                                @endif
                            </div>
                            <div>
                                <input type="file" id="admin_logo" name="admin_logo" class="form-control" onchange="showImage(this,'admin_logo')">
                            </div>

                        </div>
                    </div>
                    <br>

                    <div class="variants">
                        <label class="text-bold">{{__('file.Setup Schedule')}}</label>

                        @forelse ($schedules as $item)
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input type="text" name="schedule[]" value="{{$item}}" class="form-control" placeholder="{{__('Ex: Mon-Thursday - 9.00 - 17:00')}}">
                                </div>
                                <div class="col-2">
                                    <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                                </div>
                            </div>
                        @empty
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input type="text" name="schedule[]" class="form-control" placeholder="{{__('Ex: Mon-Thursday - 9.00 - 17:00')}}">
                                </div>
                                <div class="col-2">
                                    <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                                </div>
                            </div>
                        @endforelse

                    </div>
                    <span class="btn btn-link add-more" id="addMore"><i class="dripicons-plus"></i> @lang('Add More')</span>
                    <br><br>


                    <!-- Privacy Settings -->

                    {{-- <h3 class="text-bold">@lang('file.Privacy Settings')</h3><br>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Hide Store Phone')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="hide_store_phone" @empty(!$setting_store) {{$setting_store->hide_store_phone =="1" ? "checked" : ''}} @endempty class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Hide store phone from the storefront')</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Hide Store Email')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="hide_store_email" @empty(!$setting_store) {{$setting_store->hide_store_email =="1" ? "checked" : ''}} @endempty class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Hide store email from the storefront')</label>
                            </div>
                        </div>
                    </div> --}}



                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            //Image Show Before Upload End
            function showImage(data, logo){
                if(data.files && data.files[0]){
                    var obj = new FileReader();

                    obj.onload = function(d){
                        var image = document.getElementById(logo);
                        image.src = d.target.result;
                    }
                    obj.readAsDataURL(data.files[0]);
                }
            }


            //Add More
            $(document).on('click', '#addMore', function(){
                console.log('ok');
                var rand = Math.floor(Math.random() * 90000) + 10000;
                $('.variants').append('<div class="row"><div class="col-6 form-group"><input type="text" name="schedule[]" required class="form-control" placeholder="{{__('Ex: Mon-Thursday - 9.00 - 17.00')}}"></div><div class="col-2"><span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span></div></div></div>');
            })

            $(document).on('click', '.del-row', function(){
                $(this).parent().parent().html('');
            })

            $(document).ready(function(){
                $(".mul-select").select2({
                        placeholder: "Select Category",
                        tags: true,
                        tokenSeparators: ['/',',',';'," "]
                });
            })

        })(jQuery);
    </script>
@endpush
