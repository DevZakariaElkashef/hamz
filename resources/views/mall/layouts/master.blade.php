<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="Keywords"
        content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
    @include('mall.layouts.head')
</head>

<body class="main-body app sidebar-mini">
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ URL::asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    @php
        $toastPosition = app()->getLocale() == 'en' ? 'right: 20px;' : 'left: 20px;';
    @endphp
    @if (session('success') || session('error'))
        <div class="demo-static-toast" style="z-index: 10000000; position: fixed; bottom: 20px; {{ $toastPosition }}">
            <div aria-atomic="true" aria-live="assertive" class="toast fade show" role="alert">
                <div class="toast-body text-light"
                    style="background-color: {{ session('success') ? '#007f00' : '#c82333' }};">
                    {{ session('success') ?? session('error') }}
                </div>
            </div>
        </div>
    @endif
    <div class="demo-static-toast success-toast d-none"
        style="z-index: 10000000; position: fixed; bottom: 20px; {{ $toastPosition }}">
        <div aria-atomic="true" aria-live="assertive" class="toast fade show" role="alert">
            <div class="toast-body text-light" style="background-color: #007f00;">

            </div>
        </div>
    </div>
    <div class="demo-static-toast error-toast d-none"
        style="z-index: 10000000; position: fixed; bottom: 20px; {{ $toastPosition }}">
        <div aria-atomic="true" aria-live="assertive" class="toast fade show" role="alert">
            <div class="toast-body text-light" style="background-color: #c82333;">

            </div>
        </div>
    </div>





    @include('mall.layouts.main-sidebar')
    <!-- main-content -->
    <div class="main-content app-content">
        @include('mall.layouts.main-header')

        <!-- container -->
        <div class="container-fluid">
            @yield('page-header')

            @yield('content')
            @include('mall.layouts.sidebar')
            @include('mall.layouts.models')
            @include('mall.layouts.footer')
            @include('mall.layouts.footer-scripts')
</body>

</html>
