<!--Create Modal -->
<div class="modal fade" id="editModalForm-{{$item->local}}" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel"><b>@lang('file.Edit Language')</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{route('admin.setting.language.update')}}">
            @csrf
            <input type="hidden" name="id" value="{{$item->id}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Language Name')</b></label>
                            <div class="col-sm-8">
                                <input type="text" name="language_name" id="navbarText" class="form-control @error('language_name') is-invalid @enderror" value="{{$item->language_name}}" id="inputEmail3" placeholder="Type Your Language Name" >
                                @error('language_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Locale')</b></label>
                            <div class="col-sm-8">
                                <input type="text" name="local" id="navbarText" class="form-control  @error('local') is-invalid @enderror" value="{{$item->local}}" id="inputEmail3" placeholder="Example: 'en', 'bn', 'fr' etc." >
                                @error('local')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"><b>@lang('file.Status')</b></label>
                            <div class="col-md-8 form-check">
                                <input class="form-check-input" type="checkbox" name="default" @if($item->default==1) checked @endif value="1">
                                <label class="form-check-label" for="defaultCheck1">@lang('file.Default Language')</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </div>


                </div>
                <div class="row mb-5">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <div id="alertMessageBox">
                            <div id="alertMessage" class="text-light"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary" id="save-button">@lang('file.Update')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('file.Close')</button>
                    </div>
                </div>
            </form>

      </div>
    </div>
  </div>
