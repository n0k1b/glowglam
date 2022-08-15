<div class="card">
    <h3 class="card-header p-3"><b>SMS</b></h3>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="smsSubmit">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>SMS From <span class="text-danger">*</span></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="sms_from" class="form-control" @isset($setting_sms->sms_from) value="{{$setting_sms->sms_from}}" @endisset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><b>SMS Service</b></label>
                        <div class="col-sm-8">
                            <select name="sms_service" id="smsService" class="form-control">
                                <option value="">-- Select Service --</option>
                                <option value="vonage" @if($setting_sms) {{$setting_sms->sms_service=="vonage" ? 'selected':''}} @endif>Vonage</option>
                                <option value="twilio" @if($setting_sms) {{$setting_sms->sms_service=="twilio" ? 'selected':''}}  @endif>Twilio</option>
                            </select>
                        </div>
                    </div>


                    <!--For Vonage-->
                    <div class="form-group row" id="vonageApiKeyField">
                        @if($setting_sms && $setting_sms->sms_service=="vonage")
                            <label class="col-sm-4 col-form-label"><b>API Key <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="api_key" value="{{$setting_sms->api_key}}">
                            </div>
                        @endif
                    </div>
                    <div class="form-group row" id="vonageApiSecretField">
                        @if($setting_sms && $setting_sms->sms_service=="vonage")
                            <label class="col-sm-4 col-form-label"><b>API Secret <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="api_secret" value="{{$setting_sms->api_secret}}">
                            </div>
                        @endif
                    </div>

                    <!--For Twilio-->
                    <div class="form-group row" id="twilioAccountSidField">
                        @if($setting_sms && $setting_sms->sms_service=="twilio")
                            <label class="col-sm-4 col-form-label"><b>Account SID <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="account_sid" value="{{$setting_sms->account_sid}}">
                            </div>
                        @endif
                    </div>
                    <div class="form-group row" id="twilioAuthTokenField">
                        @if($setting_sms && $setting_sms->sms_service=="twilio")
                            <label class="col-sm-4 col-form-label"><b>Auth Token<span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="auth_token" value="{{$setting_sms->auth_token}}">
                            </div>
                        @endif
                    </div>


                    <br>
                    <h3 class="text-bold">Customer Notification Settings</h3>
                    <br>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>Welcome SMS</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="welcome_sms" class="form-check-input" @if($setting_sms) {{$setting_sms->welcome_sms=="1" ? 'checked':''}} @endif>
                                <label class="p-0 form-check-label">Send welcome SMS after registration</label>
                            </div>
                        </div>
                    </div>


                    <br>
                    <h3 class="text-bold">Older Notification Settings</h3>
                    <br>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>New Order Admin SMS</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="new_order_sms_to_admin" class="form-check-input" @if($setting_sms) {{$setting_sms->new_order_sms_to_admin=="1" ? 'checked':''}} @endif>
                                <label class="p-0 form-check-label" for="exampleCheck1">Send new order notification to the admin</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>New Order SMS to Customer</b></label>
                        <div class="col-sm-8">
                            <div class="form-check mt-1">
                                <input type="checkbox" value="1" name="new_order_sms_to_customer" class="form-check-input" @if($setting_sms) {{$setting_sms->new_order_sms_to_customer=="1" ? 'checked':''}} @endif>
                                <label class="p-0 form-check-label" for="exampleCheck1">Send new order notification to the customer</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><b>SMS Order Status</b></label>
                        <div class="col-sm-8">
                            <select name="sms_order_status" class="form-control">
                                <option value="">-- Select Status --</option>
                                <option value="canceled" @if($setting_sms) {{$setting_sms->sms_order_status=="canceled" ? 'selected':''}} @endif>{{ucfirst("canceled")}}</option>
                                <option value="completed" @if($setting_sms) {{$setting_sms->sms_order_status=="completed" ? 'selected':''}} @endif>{{ucfirst("completed")}}</option>
                                <option value="on_hold" @if($setting_sms) {{$setting_sms->sms_order_status=="on_hold" ? 'selected':''}} @endif>{{ucfirst("on hold")}}</option>
                                <option value="pending" @if($setting_sms) {{$setting_sms->sms_order_status=="pending" ? 'selected':''}} @endif>{{ucfirst("pending payment")}}</option>
                                <option value="processing" @if($setting_sms) {{$setting_sms->sms_order_status=="processing" ? 'selected':''}} @endif>{{ucfirst("processing payment")}}</option>
                                <option value="refunded" @if($setting_sms) {{$setting_sms->sms_order_status=="refunded" ? 'selected':''}} @endif>{{ucfirst("refunded")}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
</div>

