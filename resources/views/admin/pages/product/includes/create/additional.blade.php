    <div class="card">
        <h4 class="card-header"><b>{{__('file.Additional')}}</b></h4>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>{{__('file.Short Description')}} </b></label>
                        <div class="col-sm-8">
                            <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="5">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Product New From')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="new_from" id="newFrom" class="form-control datepicker @error('new_from') is-invalid @enderror" value="{{ old('new_from') }}">
                            @error('new_from')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b> {{__('file.Product New To')}}</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="new_to" id="newTo" class="form-control datepicker @error('new_to') is-invalid @enderror" value="{{ old('new_to') }}">
                            @error('new_to')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
