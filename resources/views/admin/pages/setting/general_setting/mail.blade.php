<div class="card">
    <h3 class="card-header p-3"><b>@lang('file.Mail')</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="mailSubmit">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail From Address')</b></label>
                        <div class="col-sm-8">
                            <input type="email" name="mail_address" class="form-control" @isset($setting_mail->mail_address) value="{{$setting_mail->mail_address}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail From Name')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="mail_name" class="form-control" @isset($setting_mail->mail_name) value="{{$setting_mail->mail_name}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail Host')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="mail_host" class="form-control" @isset($setting_mail->mail_host) value="{{$setting_mail->mail_host}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail Port')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="mail_port" class="form-control" @isset($setting_mail->mail_port) value="{{$setting_mail->mail_port}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail Username')</b></label>
                        <div class="col-sm-8">
                            <input type="text" name="mail_username" class="form-control" @isset($setting_mail->mail_username) value="{{$setting_mail->mail_username}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail Password')</b></label>
                        <div class="col-sm-8">
                            <input type="password" name="mail_password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Mail Encryption')</b></label>
                        <div class="col-sm-8">
                            <select name="mail_encryption" class="form-control">
                                <option value="">@lang('file.-- Select Encryption --')</option>
                                <option value="Tls" @isset($setting_mail->mail_encryption) {{$setting_mail->mail_encryption=="Tls" ? 'selected':''}} @endisset>Tls</option>
                                <option value="SSL" @isset($setting_mail->mail_encryption) {{$setting_mail->mail_encryption=="SSL" ? 'selected':''}} @endisset>SSL</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <h3 class="text-bold">@lang('file.Customer Notification Settings')</h3>
                    <br>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Welcome Email')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="welcome_email" class="form-check-input" @isset($setting_mail->welcome_email) {{$setting_mail->welcome_email=="1" ? 'checked':''}} @endisset>
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Send welcome email after registration')</label>
                            </div>
                        </div>
                    </div>


                    <br>
                    <h3 class="text-bold">@lang('file.Order Notification Settings')</h3>
                    <br>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.New Order Admin Email')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="new_order_to_admin" class="form-check-input" @isset($setting_mail->new_order_to_admin) {{$setting_mail->new_order_to_admin=="1" ? 'checked':''}} @endisset>
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Send new order notification to the admin')</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>@lang('file.Invoice Email')</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="invoice_mail" class="form-check-input" @isset($setting_mail->invoice_mail) {{$setting_mail->invoice_mail=="1" ? 'checked':''}} @endisset>
                                <label class="p-0 form-check-label" for="exampleCheck1">@lang('file.Send invoice email to the customer after checkout')</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>@lang('file.Email Order Status')</b></label>
                        <div class="col-sm-8">
                            <select name="mail_order_status" class="form-control">
                                <option value="">@lang('file.-- Select Status --')</option>
                                <option value="canceled" @isset($setting_mail->mail_order_status) {{$setting_mail->mail_order_status=="canceled" ? 'selected':''}} @endisset>{{ucfirst("canceled")}}</option>
                                <option value="completed" @isset($setting_mail->mail_order_status) {{$setting_mail->mail_order_status=="completed" ? 'selected':''}} @endisset>{{ucfirst("completed")}}</option>
                                <option value="on_hold" @isset($setting_mail->mail_order_status) {{$setting_mail->mail_order_status=="on_hold" ? 'selected':''}} @endisset>{{ucfirst("on hold")}}</option>
                                <option value="pending" @isset($setting_mail->mail_order_status) {{$setting_mail->mail_order_status=="pending" ? 'selected':''}} @endisset>{{ucfirst("pending payment")}}</option>
                                <option value="processing" @isset($setting_mail->mail_order_status) {{$setting_mail->mail_order_status=="processing" ? 'selected':''}} @endisset>{{ucfirst("processing payment")}}</option>
                                <option value="refunded" @isset($setting_mail->mail_order_status) {{$setting_mail->mail_order_status=="refunded" ? 'selected':''}} @endisset>{{ucfirst("refunded")}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>

