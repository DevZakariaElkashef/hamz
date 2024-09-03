<!-- Title -->
<title> @yield('title') </title>
<!-- Favicon -->
<link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/x-icon" />
<!-- Icons css -->
<link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{ URL::asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{ URL::asset('assets/css-rtl/sidemenu.css') }}">
@yield('css')
<!--- Style css -->
<link href="{{ URL::asset('assets/css-rtl/style.css') }}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{ URL::asset('assets/css-rtl/style-dark.css') }}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{ URL::asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet">

<style>
    .custom-toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .custom-toggle-input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .custom-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .custom-toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    .custom-toggle-input:checked+.custom-toggle-slider {
        background-color: #4CAF50;
        /* Green when active */
    }

    .custom-toggle-input:not(:checked)+.custom-toggle-slider {
        background-color: #FF6347;
        /* Red when inactive */
    }

    .custom-toggle-input:checked+.custom-toggle-slider:before {
        transform: translateX(24px);
    }

    .custom-toggle-input:not(:checked)+.custom-toggle-slider:before {
        transform: translateX(0px);
    }
</style>
