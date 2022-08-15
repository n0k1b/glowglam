
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">{{__('file.Add Color')}}</h5> &nbsp;&nbsp;&nbsp;&nbsp; <span id="error_message"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="submitForm"  class="form-horizontal">
          @csrf

            <div class="modal-body">
            <span id="errorMessage"></span>

              <div class="form-group">
                <label>{{__('file.Color Name')}} &nbsp; <span class="text-bold text-danger">*</span></label>
                <input type="text" name="color_name" required class="form-control" placeholder="Type Color Name" >
              </div>
              <div class="form-group">
                <label>{{__('file.Color Code')}} &nbsp; <span class="text-bold text-danger">*</span></label>
                <input type="text" name="color_code" required class="form-control colorpicker" placeholder="Type Color Code" >
              </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">{{__('file.Submit')}}</button>
            </div>

        </form>
      </div>
    </div>
  </div>
