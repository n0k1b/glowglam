<div class="card">
    <h3 class="card-header p-3"><b>Custom CSS/JSS</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="customCssJssSubmit">
                    @csrf


                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>Header</b></label>
                        <div class="col-sm-8">
                            <textarea name="header" cols="30" rows="10" class="form-control"> @isset($setting_custom_css_js->header) value="{{$setting_custom_css_js->header}}" @endisset</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>Footer</b></label>
                        <div class="col-sm-8">
                            <textarea name="footer" cols="30" rows="10" class="form-control"> @isset($setting_custom_css_js->footer) value="{{$setting_custom_css_js->footer}}" @endisset</textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>
