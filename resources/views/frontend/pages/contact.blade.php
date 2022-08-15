@extends('frontend.layouts.master')
@section('frontend_content')

    <!--Contact section starts-->
    <section class="contact-section v1">
        <div class="container">
            <div class="col-12">
                <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Contact Us')</h1>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <h3 class="h5">@lang('file.Write To Us')</h3>
                    <form id="contactForm" data-toggle="validator" class="shake" action="{{route('cartpro.contact.message')}}" method="POST">
                        @csrf

                        <div class="form-control-wrap">
                            <input id="name" type="text" class="form-control" name="name" autocomplete="off" required data-error="Please enter your name" placeholder="Name*">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-control-wrap">
                            <input id="Email" type="email" class="form-control" name="email" autocomplete="off" required data-error="Please enter your email" placeholder="Email*">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-control-wrap">
                            <textarea id="message" class="form-control textarea" rows="10" name="message"  data-error="Please enter your message subject" placeholder="Message"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-submit mar-top-30">
                            <button class="button style1" name="submit" type="submit" id="submit">@lang('file.Send Message')</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 offset-md-1 col-sm-12">
                    <div class="contact-widget mar-bot-30">
                        <h3 class="h5">@lang('file.Get In Touch')</h3>
                        <p>{{$setting_store->get_in_touch}}</p>
                    </div>
                    <div class="contact-widget mar-bot-30">
                        <h3 class="h5">@lang('file.Our Address')</h3>
                        <p><i class="las la-map-marker"></i> {{$storefront_address}}</p>
                        <p><i class="las la-phone"></i> {{$setting_store->store_phone ?? null}}</p>
                        <p><i class="las la-envelope"></i> {{$setting_store->store_email ?? null}}</p>
                    </div>
                    <div class="contact-widget mar-bot-30">
                        <h3 class="h5">@lang('file.Opening Hours')</h3>
                        @forelse ($schedules as $item)
                            <p>{{$item}}</p>
                        @empty
                            <p>@lang('file.NONE')</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!--Contact section ends-->

@endsection

@push('scripts')

<script src="">
    if(!Illuminate\Support\Facades\Session::get('success')){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 800,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'Message sent successfully',
            title: ,
        });
    }
</script>

@endpush
