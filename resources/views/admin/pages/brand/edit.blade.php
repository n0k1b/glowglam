@extends('admin.main')
@section('title','Admin | Brand | Edit')

@section('admin_content')
<section>

    @include('admin.includes.alert_message')
    @include('admin.includes.error_message')

    <div class="container-fluid"><span id="general_result"></span></div>
    <div class="container-fluid mb-3">
    </div>
    <h1>@lang('file.Edit')</h1>
    <br>

    <form method="post"  class="form-horizontal" action="{{route('brand.update',$brand->id)}}" enctype="multipart/form-data">
        @csrf

            <input type="hidden" name="brand_id" value="{{$brand->id}}">
            <input type="hidden" name="brand_translation_id" value="{{$brandTranslation->id}}">


            <div class="col-md-6 form-group">
                <label>{{__('Brand Name')}}</label>
                <input type="text" name="brand_name" id="brand_name" required class="form-control" @if(isset($brandTranslation->brand_name)) value="{{$brandTranslation->brand_name}}" @else value="" @endif>
            </div>

            <div class="mt-3 col-md-6 form-group">
                @if($brand->brand_logo!==null && Illuminate\Support\Facades\File::exists(public_path($brand->brand_logo)))
                    <img id="item_photo" src="{{asset('public/'.$brand->brand_logo)}}"  height="100px" width="100px">
                @elseif($brand->brand_logo==null || (!Illuminate\Support\Facades\File::exists(public_path($brand->brand_logo))))
                    <img id="item_photo" src="https://dummyimage.com/100x100/000000/0f6954.png&text=Brand"  height="100px" width="100px">
                @endif
                <input type="file" name="brand_logo" id="brandLogo" class="mt-3 form-control" onchange="showImage(this,'item_photo')">
            </div>

            <div class="col-md-4 form-group">
                <label><b>{{__('Status')}}</b></label>
                <div class="col-md-8 form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" @if($brand->is_active==1) checked value="1" @endif  id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">@lang('file.Active')</label>
                </div>
            </div>

            <div class="col form-group" align="center">
                <input type="hidden" name="action" id="action"/>
                <input type="hidden" name="hidden_id" id="hidden_id"/>
                <button type="submit" class="btn btn-success">@lang('file.Update')</button>
            </div>
    </form>

</section>
@endsection


@push('scripts')
    <script type="text/javascript">
        "use strict";
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

