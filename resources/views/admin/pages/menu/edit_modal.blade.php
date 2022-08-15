<!--Create Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLabel"><b>{{ trans('file.Update_Menu') }}</b></h5>&nbsp;&nbsp;&nbsp;&nbsp; <span id="error_message_edit"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="updateForm">
                @csrf
                <input type="hidden" name="menu_id" id="menu_id">
                <input type="hidden" name="menu_translation_id" id="menu_translation_id">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-4 col-form-label"><b>{{ trans('file.Menu Name') }} &nbsp;<span class="text-danger">*</span></b></label>
                            <input type="text" class="col-md-8 form-control" name="menu_name" id="menu_name_edit" placeholder="{{ trans('file.Menu Name') }}">
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>{{ trans('file.Status') }}</b></label>
                            <div class="col-md-8 form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active_edit" value="1" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">{{ trans('file.Enable this menu') }}</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <div id="alertMessageBox">
                            <div id="alertMessageEdit" class="text-light"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary" id="update-button">{{ trans('file.Update') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('file.Close') }}</button>
                    </div>
                </div>
            </form>
        </div>


      </div>
    </div>
  </div>
