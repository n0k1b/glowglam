    <div class="card">
        <h4 class="card-header"><b>{{__('file.SEO')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Meta Title')}} </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="meta_title" id="metaTitle" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" id="inputEmail3" placeholder="Type Meta Title" >
                            @error('meta_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('file.Meta Description')}} </b></label>
                        <div class="col-sm-8">
                            <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror"rows="5">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
