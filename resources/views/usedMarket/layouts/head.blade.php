<!-- Title -->
<title> @yield('title') </title>
<!-- Favicon -->
<link rel="icon" href="{{ URL::asset('assets/img/brand/logo.png') }}" type="image/x-icon" />

<!--  Custom Scroll bar-->
<link href="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
@if (app()->getLocale() == 'ar')
    <!-- Icons css -->
    <link href="{{ URL::asset('assets/css-rtl/icons.css') }}" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css-rtl/sidemenu.css') }}">
    <!--- Style css -->
    <link href="{{ URL::asset('assets/css-rtl/style.css') }}" rel="stylesheet">
@else
    <!-- Icons css -->
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/sidemenu.css') }}">
    <!--- Style css -->
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
@endif
<!-- Fonts Css -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

<!-- Style Css-->
<style>
    * {
        font-family: 'Cairo', "Roboto", sans-serif;
    }

    .alert-dismissible .close {
        right: auto;
        left: 0;
    }

    .card-header {
        border-bottom: 1px solid #dde2ef
    }

    @if (app()->getLocale() == 'ar')
        .alert-dismissible .close {
            right: auto;
            left: 0;
        }
    @else
        .ml-3 {
            margin-right: 1rem !important;
            margin-left: 0 !important;
        }

        .mr-3 {
            margin-left: 1rem !important;
            margin-right: 0 !important;
        }

        .ml-2 {
            margin-left: 0 !important;
            margin-right: 0.5rem !important;
        }
    @endif
</style>
@include('layouts.custom-style')
@yield('css')
