<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Create Vaule')}}</h5>
                <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <form method="post" id="submitForm"  class="form-horizontal">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Value Name')</b></label>
                            <div class="col-sm-8">
                                <input type="text" name="attribute_value_name" id="navbarText" class="form-control" id="inputEmail3" placeholder="@lang('file.Value Name')" >
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" name="action_button" id="submitButton" class="btn btn-success">{{__('file.Submit')}}</button>
                    </div>
                </form>
        </div>
    </div>
</div>
