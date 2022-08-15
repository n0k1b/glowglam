<div class="card">
    <h3 class="card-header p-2"><b>{{__('file.Top Categories')}}</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="topCategoriesSubmit">
                    @csrf

                    <!-- DB_ROW_ID-80:  => setting[79] -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Section Status')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" @if($settings_new['storefront_top_categories_section_enabled']->plain_value==1) checked @endif value="1" name="storefront_top_categories_section_enabled" class="form-check-input">
                                <label class="form-check-label" for="exampleCheck1">@lang('file.Enable Categories section')</label>
                            </div>
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

