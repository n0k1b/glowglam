<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.About Us')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="aboutUsSubmit" method="POST" action="{{route('admin.setting.about_us.store_or_update')}}" enctype="multipart/form-data">
                    @csrf

                    <!-- Status -->
                    {{-- <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="status" class="form-check-input" @isset($setting_about_us->status) {{$setting_about_us->status=="1" ? 'checked':''}} @endisset>
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Enable About Us')</label>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Tilte -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Title') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" @empty(!$setting_about_us) value="{{$setting_about_us->aboutUsTranslation->title}}" @endempty class="form-control">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Description') <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <textarea name="description" id="" cols="40" rows="10">@if($setting_about_us) {{$setting_about_us->aboutUsTranslation->description ?? null}} @endif</textarea>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Image') <span class="text-danger">*</span></b></label>
                        {{-- <div class="col-sm-8">
                            <input type="file" name="image" class="form-control">
                        </div> --}}

                        <div class="col-md-8">
                            @if($setting_about_us && $setting_about_us->image!==null && Illuminate\Support\Facades\File::exists(public_path($setting_about_us->image)))
                                <img src="{{asset('public/'.$setting_about_us->image)}}" id="testImage" height="100px" width="100px">
                            @else
                                <img src="https://dummyimage.com/100x100/cccccc/666666&text=About US" id="testImage">
                            @endif
                            <br>
                            <input type="file" name="image" class="form-control" onchange="showImage(this,'testImage')">
                        </div>
                    </div>

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

        function showImage(data, imgId){
            if(data.files && data.files[0]){
                var obj = new FileReader();
                obj.onload = function(d){
                    var image = document.getElementById(imgId);
                    image.src = d.target.result;
                }
                obj.readAsDataURL(data.files[0]);
            }
        }
    </script>

@endpush



