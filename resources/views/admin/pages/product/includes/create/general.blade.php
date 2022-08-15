    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="inputEmail3"><b>{{__('file.Product Name')}} <span class="text-danger">*</span></b></label>
                        <input type="text" name="product_name" id="productName" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}" id="inputEmail3" placeholder="Type Product Name" >
                        @error('product_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3"><b>{{__('file.Description')}} <span class="text-danger">*</span></b></label>
                        <textarea name="description" id="description" class="form-control text-editor">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
