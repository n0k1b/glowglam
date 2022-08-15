    <div class="card">
        <h4 class="card-header"><b>@lang('file.Attributes')</b></h4>
        <hr>
        <div class="card-body">
            <div class="variants">
                <div class="row">
                    <div class="col-5 form-group">
                        <label>{{__('Atrribute')}}</label>
                        <select name="attribute_id[]" id="attributeId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Attribute')}}'>
                            @forelse ($attributeSets as $item)
                                <option value="" disabled class="text-bold">{{$item->attributeSetTranslation->attribute_set_name ?? $item->attributeSetTranslationEnglish->attribute_set_name ?? null}}</option>
                                @forelse ($item->attributes as $attribute)
                                    <option value="{{$attribute->id}}">&nbsp;&nbsp;&nbsp;{{$attribute->attributeTranslation->attribute_name ?? $attribute->attributeTranslationEnglish->attribute_name ?? null}}</option>
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label>{{__("file.Values")}}</label>
                        <select name="attribute_value_id[]" id="attributeValueId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Value">
                        </select>
                    </div>

                    <div class="col-1">
                        <label>@lang('file.Delete')</label><br>
                        <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                    </div>
                </div>
            </div>

            <span class="btn btn-link add-more" id="addMore"><i class="dripicons-plus"></i> @lang('file.Add New Attribute')</span>

        </div>
    </div>
