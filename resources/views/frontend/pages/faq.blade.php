@extends('frontend.layouts.master')
@section('frontend_content')
    <!--FAQ Section starts-->

    <!--FAQ Section starts-->
    <section class="faq-section">
        <div class="container">
            <div class="col-12">
                <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Frequently Asked Questions')</h1>
            </div>
            <div class="row">
                <div class="col-md-12 single-faq-section mar-tb-30">
                    @foreach ($faq_types as $key => $item)
                        @if ($item->faqs->isNotEmpty())
                            <div class="row">
                                <div class="col-md-3 col-sm-12 faq-category">
                                    <h3 class="title" data-bs-toggle="collapse" href="#collapseShipping-{{$key}}" aria-expanded="true">{{$item->faqTypeTranslation->type_name}}</h3>
                                </div>
                                <div class="col-md-9 col-sm-12 collapse show" id="collapseShipping-{{$key}}">
                                    @foreach ($item->faqs as $value)
                                        <div class="row single-faq-item">
                                            <div class="col-md-6">
                                                <div class="faq-query ">
                                                    <h5>{{$value->faqTranslation->title}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="faq-ans ">
                                                    <p>{{$value->faqTranslation->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <!--FAQ Section ends-->
@endsection
