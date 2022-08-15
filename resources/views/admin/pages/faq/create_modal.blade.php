<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">{{__('file.Add FAQ')}}</h5> &nbsp;&nbsp;&nbsp;&nbsp; <span id="error_message"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="submitForm"  class="form-horizontal">
          @csrf

            <div class="modal-body">


                <div class="form-group">
                    <label>{{__('file.FAQ Type')}} &nbsp; <span class="text-bold text-danger">*</span></label>
                    <select name="faq_type_id" id="attributeSetId" required class="form-control selectpicker @error('attribute_set_id') is-invalid @enderror" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select FAQ Type')}}'>
                        @forelse ($faq_types as $item)
                            <option value="{{$item->id}}">{{$item->faqTypeTranslation->type_name ?? $item->faqTypeTranslationEnglish->type_name ?? null}}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('faq_type_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{__('file.Title')}} &nbsp; <span class="text-bold text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Title" >
                </div>
                <div class="form-group">
                    <label>{{__('file.Description')}} &nbsp; <span class="text-bold text-danger">*</span></label><br>
                    <textarea name="description" cols="100" rows="10"></textarea>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" checked class="form-check-input" name="is_active"  value="1" checked>
                    <label class="form-check-label" for="exampleCheck1">{{__('file.Active')}}</label>
                </div>
                </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="action_button" id="submitButton" class="btn btn-primary">@lang('file.Submit')</button>
            </div>
        </form>
      </div>
    </div>
</div>
