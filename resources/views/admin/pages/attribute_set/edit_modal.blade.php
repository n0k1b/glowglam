

<!-- Modal -->
<div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('file.Edit Attribute Set')}}</h5>&nbsp;&nbsp;&nbsp;&nbsp; <span id="error_message_edit"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="updateForm"  class="form-horizontal">
          @csrf

            <input type="hidden" name="attribute_set_id" id="AttributeSetIdEdit">
            <input type="hidden" name="attribute_set_translation_id" id="attributeSetTranslationIdEdit">

            <div class="modal-body">

            <span id="error_message_edit"></span>


              <div class="form-group">
                <label>{{__('file.Attribute Set Name')}}</label>
                <input type="text" name="attribute_set_name" id="attributeSetNameEdit" required class="form-control" placeholder="{{__('file.Attribute Set Name')}}">
                <small class="form-text text-muted"> <span id="errorMessge"></span></small>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" id="isActiveEdit">
                <label class="form-check-label" for="exampleCheck1">{{__('file.Active')}}</label>
              </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="action_button" id="updateButton" class="btn btn-primary">@lang('file.Update')</button>
            </div>

        </form>
      </div>
    </div>
  </div>
