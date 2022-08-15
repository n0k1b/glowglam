    <div class="card">
        <div class="card-body">

            <div class='form-row row'>
                <div class="col-sm-12">
                    <input class="form-control" type="text" name="card_name" placeholder="@lang('file.Name on Card') *">
                </div>
            </div>

            <br>
            <div class='form-row row'>
                <div class='col-xs-12 form-group card required'>
                    <label class='control-label'>@lang('file.Card Number')</label>
                    <input autocomplete='off' class='form-control card-num' size='20' type='text' required>
                </div>
            </div>

            <br>
            <div class='form-row row'>
                <div class='col-xs-12 col-md-4 form-group cvc required'>
                    <label class='control-label'>CVC</label>
                    <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4' type='text'>
                </div>
                <div class='col-xs-12 col-md-4 form-group expiration required'>
                    <label class='control-label'>@lang('file.Expiration Month')</label> <input class='form-control card-expiry-month'
                        placeholder='MM' size='2' type='text'>
                </div>
                <div class='col-xs-12 col-md-4 form-group expiration required'>
                    <label class='control-label'>@lang('file.Expiration Year')</label> <input class='form-control card-expiry-year'
                        placeholder='YYYY' size='4' type='text'>
                </div>
            </div>
            <br><br>

            <div class='form-row row'>
                <div class='col-xs-12 d-none error form-group'>
                    <div class='alert-danger alert'>@lang('file.Fix the errors before you begin.')</div>
                </div>
            </div>

            <div class="form-row row">
                <div class="checkout-actions mar-top-30">
                    <button class="button lg style1 d-block text-center w-100" type="submit" id="payStripeBtn">{{__('file.Pay Now')}}</button>
                </div>
            </div>

        </div>
    </div>





