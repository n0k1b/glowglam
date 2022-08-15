<!-- Modal -->
<div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">{{__('file.Edit Type')}}</h5> &nbsp;&nbsp;&nbsp;&nbsp; <span id="errorMessageEdit"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="updateForm"  class="form-horizontal">
          @csrf

            <div class="modal-body">

                <input type="hidden" name="faq_type_id" id="faqTypeId" hidden>


              <div class="form-group">
                <label>{{__('file.Type Name')}} &nbsp; <span class="text-bold text-danger">*</span></label>
                <input type="text" name="type_name" class="form-control" id="typeName" placeholder="Type Name" >
                <small class="form-text text-muted"> <span id="errorMessge"></span></small>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" checked class="form-check-input" name="is_active" id="isActiveEdit" value="1" checked>
                <label class="form-check-label" for="exampleCheck1">{{__('file.Active')}}</label>
              </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="updateButton" class="btn btn-primary">@lang('file.Update')</button>
            </div>
        </form>
      </div>
    </div>
</div>
