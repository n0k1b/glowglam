<div class="card">
    <h4 class="card-header p-3"><b>General</b></h4>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="generalSubmit">
                    @csrf


                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>Maintenance Mode</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="storefront_one_column_banner_enabled" class="form-check-input">
                                <label class="p-0 form-check-label" for="exampleCheck1">Put the application into maintenance mode</label>
                            </div>
                        </div>
                    </div>
                    <br>


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



