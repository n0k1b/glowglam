<div class="card">
    <h3 class="card-header p-2"><b>{{__('file.Top Brands')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="topBrandsSubmit">
                    @csrf

                    <!-- DB_ROW_ID-80:  => setting[79] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Section Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" @if($setting[79]->plain_value==1) checked @endif value="1" name="storefront_top_brands_section_enabled" class="form-check-input">
                                <label class="form-check-label" for="exampleCheck1">@lang('file.Enable brands section')</label>
                            </div>
                        </div>
                    </div>


                    <!-- Top Brands -->
                    <!-- DB_ROW_ID-81:  => setting[80] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('file.Top Brands')}}</b></label>
                        <div class="col-sm-8">
                            <select name="storefront_top_brands[]" class="form-control selectpicker" multiple="multiple" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Brand')}}'>
                               @forelse ($brands as $item)
                                    <option value="{{$item->id}}"
                                        @foreach($array_brands as $key2 => $value)
                                        @if($array_brands[$key2] == $item->id)
                                                selected
                                            @endif
                                        @endforeach > {{$item->brandTranslation->brand_name ?? $item->brandTranslationEnglish->brand_name ?? null}}
                                    </option>
                               @empty
                               @endforelse
                            </select>
                        </div>
                    </div>



                    <div class="form-group row mt-5">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary save">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>

