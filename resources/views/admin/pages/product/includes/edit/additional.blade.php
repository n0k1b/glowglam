<div class="tab-pane fade show" aria-labelledby="product-additional" id="additional" role="tabpanel">
    <div class="card">
        <h4 class="card-header"><b>{{__('file.Additional')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('file.Short Description')}} </b></label>
                        <div class="col-sm-8">
                            <textarea name="short_description" id="short_description" class="form-control" rows="5">
                                 {{$product->productTranslation->short_description ?? $product->productTranslationEnglish->short_description ?? null}}

                            </textarea>
                            @error('short_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Product New From')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="new_from" id="newFrom" value="{{$product->new_from}}" class="form-control datepicker">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Product New To')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="new_to" id="newTo" value="{{$product->new_to}}" class="form-control datepicker">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
