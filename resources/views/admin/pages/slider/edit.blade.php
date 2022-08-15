<!--Create Modal -->
<div class="modal fade" id="EditformModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel"><b>@lang('file.Edit Slider')</b></h5>
          <button type="button" class="close" id="closeEdit" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="alertMessageEdit" role="alert"></div>

        <div class="modal-body">
            <form method="POST" id="updatetForm" action="{{route('admin.slider.store')}}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="slider_id" id="sliderId">
                <input type="hidden" name="slider_Translation_id" id="sliderTranslationId">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Title') &nbsp;<span class="text-danger">*</span></b></label>
                            <input type="text" class="col-md-8 form-control" name="slider_title" id="sliderTitleEdit" placeholder="@lang('file.Title')">
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Subtitle')</b></label>
                            <input type="text" class="col-md-8 form-control" name="slider_subtitle" id="sliderSubtitleEdit" placeholder="@lang('file.Subtitle')">
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Type') &nbsp;<span class="text-danger">*</span></b></label>
                            <select name="type" id="typeEdit" class="col-md-8 form-control selectpicker">
                                <option value="category">@lang('file.Category')</option>
                                <option value="url">@lang('file.URL')</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b><span id="changeLabelTextByTypeEdit">{{__('file.Category')}}</span> &nbsp;<span class="text-danger">*</span> </b></label>
                            <!--Category-->
                            <div id="dependancyTypeForCategoryEdit" class="col-md-8">
                                <select name="category_id" id="category_id_edit" class="form-control col-md-12 selectpicker" title='{{__('file.-- Select Category --')}}' >
                                    @foreach ($categories as $item)
                                        @forelse ($item->categoryTranslation as $key => $value)
                                            @if ($value->local==$locale)
                                                <option value="{{$item->id}}">{{$value->category_name}}</option> @break
                                            @elseif($value->local=='en')
                                                <option value="{{$item->id}}">{{$value->category_name}}</option> @break
                                            @endif
                                        @empty
                                            <option value="">{{__('file.NULL')}}</option>
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                            <!--URL-->
                            <input type="text" name="url" id="url_edit" class="col-md-8 form-control">

                            <!--For Change Field-->
                            <div id="dependancyTypeEdit" class="col-md-8"></div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>@lang('file.Image') &nbsp;<span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <img id="item_image" width="100px">
                                <input type="file" name="slider_image" id="slider_image" class="form-control" onchange="showImage(this,'item_image')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Target')</b></label>
                            <select name="target" id="targetEdit" class="col-md-8 form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Target')}}'>
                                <option value="same_tab">@lang('file.Same Tab')</option>
                                <option value="new_tab">@lang('file.New Tab')</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Text Alignment')</b></label>
                            <select name="text_alignment" id="textAlignment" class="col-md-8 form-control selectpicker" title='{{__('file.Select Alignment')}}'>
                                <option value="left">@lang('file.Left')</option>
                                <option value="right">@lang('file.Right')</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Text Color')</b></label>
                            <input type="text" id="textColor" name="text_color" class="col-md-8 form-control colorpicker-element" value="#333" data-colorpicker-id="1" data-original-title="" title="">
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Status')</b></label>
                            <div class="col-md-8 form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveEdit" value="1" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">@lang('file.Enable the slide')</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" id="update" class="btn btn-primary">@lang('file.Update')</button>
                </div>
            </form>
        </div>

      </div>
    </div>
  </div>
@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";
            //Change Type
                $('#typeEdit').change(function() {
                    var type = $(this).val();
                    if (type){
                        $.get("{{route('admin.slider.data-fetch-by-type')}}",{type:type}, function (data) {
                            console.log(data)
                            $('#dependancyTypeEdit').empty().html(data);
                        });
                    }else{
                        // $('#designationId').empty().html('<option>--Select --</option>');
                    }
                });
        })(jQuery);
    </script>
@endpush
