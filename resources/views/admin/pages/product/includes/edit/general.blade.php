    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="inputEmail3"><b>{{__('file.Product Name')}} <span class="text-danger">*</span></b></label>
                            <input type="text" name="product_name" id="productName" class="form-control @error('product_name') is-invalid @enderror" id="inputEmail3" value="{{$product->productTranslation->product_name ?? $product->productTranslationEnglish->product_name ?? null}}" placeholder="Type Product Name">
                            <input type="hidden" name="product_translation_id" class="form-control" id="inputEmail3" @if(isset($product->productTranslation->id)) value="{{$product->productTranslation->id ?? $product->productTranslation->id}}" @endif>
                            @error('product_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputEmail3"><b>{{__('file.Description')}} <span class="text-danger">*</span></b></label>
                            <textarea name="description" id="description" class="form-control text-editor">
                                {!! htmlspecialchars_decode($product->productTranslation->description ?? $product->productTranslationEnglish->description ?? null) !!}
                            </textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                    </div>
                </div>
            </div>

        </div>
    </div>
