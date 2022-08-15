    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="inputEmail3"><b>@lang('file.Brand')</b></label>
                        <select name="brand_id" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Brand')}}'>
                            @forelse ($brands as $item)
                                <option value="{{$item->id}}">{{$item->brand_name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3"><b>@lang('file.Categories') <span class="text-danger">*</span> </b></label>
                        <select name="category_id[]" id="categoryId" class="form-control selectpicker @error('category_id') is-invalid @enderror" multiple="multiple" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
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
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3"><b>@lang('file.Tax') Class <span class="text-danger">*</span></b></label>
                        <select name="tax_id" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Tax')}}'>
                            @forelse ($taxes as $tax)
                                <option value="{{$tax->id}}">{{$tax->taxTranslation->tax_name ?? $tax->taxTranslationDefaultEnglish->tax_name ?? null}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3"><b>@lang('file.Tags')</b></label>
                        <select name="tag_id[]" class="form-control selectpicker" multiple="multiple" data-live-search="true" data-live-search-style="begins" title='{{__('Select Tag')}}'>
                            @foreach ($tags as $item)
                                @if ($item->tagTranslation->count()>0)
                                    @foreach ($item->tagTranslation as $key => $value)
                                        @if ($key<1)
                                            @if ($value->local==$local)
                                                <option value="{{$item->id}}">{{$value->tag_name}}</option>
                                            @elseif($value->local=='en')
                                                <option value="{{$item->id}}">{{$value->tag_name}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    <option value="">{{__('NULL')}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3"><b>@lang('file.Status')</b></label>
                        <div class="form-group form-check">
                            <input type="checkbox" checked class="form-check-input" name="is_active" value="1" id="isActive">
                            <span>{{__('file.Enable the product')}}</span>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success btn-block">{{__('file.Save')}}</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
