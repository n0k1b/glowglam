    <div class="card">
        <h4 class="card-header"><b>{{__('file.Images')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Basic Image')}} </b></label>
                        <div class="col-sm-8">
                            <input type="file" name="base_image" id="baseImage" class="form-control @error('base_image') is-invalid @enderror">
                            @error('base_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Additional Images')}} </b></label>
                        <div class="col-sm-8">
                            <input type="file" name="additional_images[]" multiple id="multipleImages" class="form-control @error('additional_images') is-invalid @enderror">
                            @error('additional_images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
