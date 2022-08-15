
<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('file.Add Currency')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="submitForm"  class="form-horizontal">
          @csrf

            <div class="modal-body">
                <div class="container-fluid"><span id="errorMessage"></span></div>

                <div class="form-group">
                    <label>{{__('file.Currency Name')}}</label>
                    <input type="text" name="currency_name" class="form-control" placeholder="Ex: Bangladesh">
                </div>
                <div class="form-group">
                    <label>{{__('file.Currency Code')}}</label>
                    <input type="text" name="currency_code" class="form-control" placeholder="Ex: BDT">
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="submit"id="submitButton" class="btn btn-primary">@lang('file.Submit')</button>
            </div>

        </form>
      </div>
    </div>
  </div>
