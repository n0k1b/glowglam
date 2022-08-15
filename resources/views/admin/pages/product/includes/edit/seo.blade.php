<div class="tab-pane fade show" aria-labelledby="product-seo" id="seo" role="tabpanel">
    <div class="card">
        <h4 class="card-header"><b>{{__('file.SEO')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Meta Title')}} </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="meta_title" id="metaTitle" value="{{$product->productTranslation->meta_title ?? $product->productTranslationEnglish->meta_title ?? null}}"  class="form-control" id="inputEmail3" placeholder="@lang('file.Type') @lang('file.Meta Title')" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('file.Meta Description')}} </b></label>
                        <div class="col-sm-8">
                            <textarea name="meta_description" id="meta_description" value="{{$product->productTranslation->meta_description ?? $product->productTranslationEnglish->meta_description ?? null}}" class="form-control" rows="5"></textarea>
                            @error('meta_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
