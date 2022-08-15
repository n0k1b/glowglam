<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <h5 id="exampleModalLabel" class="modal-title"></h5>
                <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal" action="{{route('user_list.update')}}" enctype="multipart/form-data">

                    @csrf
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label>{{__('file.First Name')}} *</label>
                            <input type="text" name="first_name" id="first_name" required class="form-control"
                                   placeholder="{{__('file.First Name')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Last Name')}} *</label>
                            <input type="text" name="last_name" id="last_name" required class="form-control"
                                   placeholder="{{__('file.Last Name')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Username')}} *</label>
                            <input type="text" name="username" id="username" required class="form-control"
                                   placeholder="{{__('file.Username')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Phone')}} *</label>
                            <input type="text" name="phone" id="phone" required class="form-control"
                                   placeholder="{{__('file.Phone')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Email')}} *</label>
                            <input type="email" name="email" id="email" required class="form-control"
                                   placeholder="{{__('file.Email')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Password')}} *</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="{{__('file.Password')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Confirm password')}} *</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                   placeholder="{{__('file.Confirm Password')}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Role')}} *</label>
                            <select class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" required name="role" id="role">
                                @foreach ($roles as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="exampleFormControlFile1">{{__('file.Image')}}</label>
                            <input type="file" class="form-control-file" name="image" id="exampleFormControlFile1">
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" name="is_active" id="isActive" id="default" value="1" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">{{__('file.Active')}}</label>
                            </div>
                        </div>
                        <div class="container">
                            <div class="form-group" align="center">
                                <input type="hidden" name="action" id="action"/>
                                <input type="hidden" name="hidden_id" id="hidden_id"/>
                                <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                       value={{trans('file.Add')}}>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
