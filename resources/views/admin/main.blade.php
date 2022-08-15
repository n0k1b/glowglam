@php
    if(!Illuminate\Support\Facades\Session::get('currentLocal')){
        Illuminate\Support\Facades\Session::put('currentLocal', 'en');
        $locale = 'en';
    }else {
        $locale = Illuminate\Support\Facades\Session::get('currentLocal');
    }
    Illuminate\Support\Facades\App::setLocale($locale);
@endphp

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset($favicon_logo_path)}}" />


    <!-- Bootstrap CSS-->
    <link rel="preload" href="{{ asset('public/vendor/bootstrap/css/bootstrap.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/bootstrap/css/bootstrap.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>

    <link rel="preload" href="{{ asset('public/vendor/bootstrap/css/awesome-bootstrap-checkbox.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/bootstrap/css/awesome-bootstrap-checkbox.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <link rel="preload" href="{{ asset('public/vendor/bootstrap/css/bootstrap-datepicker.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/bootstrap/css/bootstrap-datepicker.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <link rel="preload" href="{{ asset('public/vendor/bootstrap/css/bootstrap-select.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/bootstrap/css/bootstrap-select.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <!-- Font Awesome CSS-->
    <link rel="preload" href="{{ asset('public/vendor/font-awesome/css/font-awesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/font-awesome/css/font-awesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <!-- Dripicons icon font-->
    <link rel="preload" href="{{ asset('public/vendor/dripicons/webfont.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/dripicons/webfont.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <!-- Google fonts - Roboto -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>

    <!-- Custom Scrollbar-->
    <link rel="preload" href="{{ asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <!-- table sorter preload-->

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/dataTables.bootstrap4.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/dataTables.bootstrap4.min.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/buttons.bootstrap4.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/buttons.bootstrap4.min.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/select.bootstrap4.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/select.bootstrap4.min.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/dataTables.checkboxes.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/dataTables.checkboxes.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/datatables.flexheader.boostrap.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/datatables.flexheader.boostrap.min.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/select2/dist/css/select2.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/select2/dist/css/select2.min.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/RangeSlider/ion.rangeSlider.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/RangeSlider/ion.rangeSlider.min.css') }}"></noscript>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/datatable.responsive.boostrap.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('public/vendor/datatable/datatable.responsive.boostrap.min.css') }}"></noscript>


    <!-- theme preload-->
    <link rel="preload" href="{{ asset('public/css/style.default.css') }}" id="theme-stylesheet" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="{{ asset('public/css/style.default.css') }}" id="theme-stylesheet" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>


    <!-- Color Picker CSS -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" id="theme-stylesheet" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" id="theme-stylesheet" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>
    
    @stack('css')

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZZBZQHXN8Q"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-ZZBZQHXN8Q');
    </script>

    <script type="text/javascript" src="{{ asset('public/vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <style>
        label{
                color: #000000;
        }
    </style>
  </head>

  <body onload="myFunction()">
    <div id="loader"></div>

        @if (session()->has('empty_message'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong>{{ session('empty_message')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @include('admin.includes.sidebar')


        <div style="" id="content" class="animate-bottom">
            <div class="page">
                
                @include('admin.includes.header')
                
                @yield('admin_content')
                
                <footer class="main-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>{{trans('file.Developed')}} {{trans('file.By')}} <a href="https://lion-coders.com" class="external">LionCoders</a></p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZZBZQHXN8Q"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-ZZBZQHXN8Q');
    </script>

    <script type="text/javascript" src="{{ asset('public/vendor/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/jquery/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('public/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/bootstrap/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/chart.js/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/charts-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/front.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <!-- table sorter js-->

    <script type="text/javascript" src="{{ asset('public/vendor/datatable/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/dataTables.select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/sum().js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/dataTables.checkboxes.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/datatable.fixedheader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/datatable.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/datatable/datatable.responsive.boostrap.min.js') }}"></script>

    <script type="text/javascript">
        if ($(window).outerWidth() > 1199) {
            $('nav.side-navbar').removeClass('shrink');
        }
        function myFunction() {
            setTimeout(showPage, 150);
        }
        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("content").style.display = "block";
        }

        // Button Click for showing "Saving ..."
        $(".save").on("click",function(e){
            $('.save').text('Saving ...');
        });

        $("div.alert").delay(3000).slideUp(750);

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
    </script>

    @stack('scripts')
  </body>
</html>
