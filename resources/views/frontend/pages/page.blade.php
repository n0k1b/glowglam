@extends('frontend.layouts.master')
@section('frontend_content')
    <div class="breadcrumb-section">
        <div class="container">
            <ul>
                <li><a href="{{route('cartpro.home')}}">@lang('file.Home')</a></li>
                <li>{{$page->pageTranslation->page_name}}</li>
            </ul>
        </div>
    </div>
    <!--FAQ Section starts-->
    <section class="faq-section">
        <div class="container">
            <div class="row">
                @if ($page->pageTranslation)
                    {!! htmlspecialchars_decode($page->pageTranslation->body ?? null) !!}
                @else
                    <h1>@lang('file.Empty Data')</h1>
                @endif
            </div>
        </div>
    </section>
    <!--FAQ Section ends-->
@endsection
