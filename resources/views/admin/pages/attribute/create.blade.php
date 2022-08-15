@extends('admin.main')

@section('title','Admin | Attributes Create')


@section('admin_content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    @include('admin.includes.alert_message')

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">@lang('file.Attributes Create')</h4>
        <div id="success_alert" role="alert"></div>
        <br>
    </div>

    <div class="container">
        <form action="{{route('admin.attribute.store')}}" method="POST">
            @csrf

            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-4">
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="general-settings-general" data-toggle="list" href="#general" role="tab" aria-controls="home">@lang('file.General')</a>
                                <a class="list-group-item list-group-item-action" id="attribute-values" data-toggle="list" href="#values" role="tab" aria-controls="settings">@lang('file.Values')</a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-settings-general">
                                    <div class="card">
                                        <h4 class="card-header"><b>@lang('file.General')</b></h4>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Attribute Set') <span class="text-danger">*</span></b></label>
                                                        <div class="col-sm-8">
                                                            <select name="attribute_set_id" id="attributeSetId" required class="form-control selectpicker @error('attribute_set_id') is-invalid @enderror" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Attribute Set')}}'>
                                                                @forelse ($attributeSets as $item)
                                                                    <option value="{{$item->id}}">{{$item->attributeSetTranslation->attribute_set_name ?? $item->attributeSetTranslationEnglish->attribute_set_name ?? null}}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                            @error('attribute_set_id')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Attribute Name') <span class="text-danger">*</span></b></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" required name="attribute_name" id="navbarText" class="form-control @error('attribute_name') is-invalid @enderror" id="inputEmail3" placeholder="@lang('file.Attribute Name')" >
                                                            @error('attribute_name')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Categories')</b></label>
                                                        <div class="col-sm-8">
                                                            <select name="category_id[]"  class="form-control selectpicker" multiple data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                                                                @foreach ($categories as $item)
                                                                    @if ($item->categoryTranslation->count()>0)
                                                                        @foreach ($item->categoryTranslation as $key => $value)
                                                                            @if ($key<1)
                                                                                @if ($value->local==$local)
                                                                                    <option value="{{$item->id}}">{{$value->category_name}}</option>
                                                                                @elseif($value->local=='en')
                                                                                    <option value="{{$item->id}}">{{$value->category_name}}</option>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">{{__('NULL')}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Filterable')</b></label>
                                                        <div class="col-sm-8">
                                                            <div class="form-group form-check">
                                                                <input type="checkbox" class="form-check-input" name="is_filterable" value="1" id="isActive">
                                                                <span>{{__('file.Use this attribute for filtering products')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Status')</b></label>
                                                        <div class="col-sm-8">
                                                            <div class="form-group form-check">
                                                                <input type="checkbox" checked class="form-check-input" name="is_active" value="1" id="isActive">
                                                                <span>{{__('file.Active')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success">{{__('file.Submit')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="values" role="tabpanel" aria-labelledby="attribute-values">
                                    <div class="card">
                                        <h4 class="card-header"><b>@lang('file.Values')</b></h4>
                                        <div class="card-body">
                                            <div class="variants">
                                                <div class="row">
                                                    <div class="col-6 form-group">
                                                        <label>{{__('file.Value Name')}}</label>
                                                        <input type="text" name="value_name[]" class="form-control" placeholder="{{__('file.Value Name')}}">
                                                    </div>
                                                    <div class="col-2">
                                                        <label>@lang('file.Delete')</label><br>
                                                        <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="btn btn-link add-more" id="addMore"><i class="dripicons-plus"></i> @lang('file.Add More')</span>
                                            <br><br>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success">{{__('file.Submit')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
            console.log('ok');
            var rand = Math.floor(Math.random() * 90000) + 10000;
            $('.variants').append('<div class="row"><div class="col-6 form-group"><label>{{__('Value Name')}}</label><input type="text" name="value_name[]" required class="form-control" placeholder="{{__('Type Value Name')}}"></div><div class="col-2"><label>Delete</label><br><span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span></div></div></div>');
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

