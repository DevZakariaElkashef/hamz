@extends('rfoof.layouts.master')
@section('title')
    {{ __('admin.notifications') }}
@endsection
@section('css')
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .pagination-box {
            display: flex;
        }
    </style>
    <style>
        /* Dropdown Button */
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;

        }

        /* Dropdown button on hover & focus */
        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #3e8e41;
        }

        /* The search field */
        .myInput {
            box-sizing: border-box;
            background-image: url('searchicon.png');
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 14px 20px 12px 45px;
            border: none;
            border-bottom: 1px solid #ddd;
            width: 100% !important;
        }

        /* The search field when it gets focus/clicked on */
        .myInput2:focus {
            outline: 3px solid #ddd;
        }

        /* The search field */
        .myInput2 {
            box-sizing: border-box;
            background-image: url('searchicon.png');
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 14px 20px 12px 45px;
            border: none;
            border-bottom: 1px solid #ddd;
            width: 100% !important;
        }

        /* The search field when it gets focus/clicked on */
        .myInput:focus {
            outline: 3px solid #ddd;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
            width: 100% !important;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            border: 1px solid #ddd;
            z-index: 1;
            width: 100% !important;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content2 a:hover {
            background-color: #f1f1f1
        }

        .dropdown2 {
            position: relative;
            display: inline-block;
            width: 100% !important;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content2 {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            border: 1px solid #ddd;
            z-index: 1;
            width: 100% !important;
        }

        /* Links inside the dropdown */
        .dropdown-content2 a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content2 a:hover {
            background-color: #f1f1f1
        }


        /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
        .show {
            display: block;
        }

        .dropdown-menu {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            padding: 0;
        }

        .dropdown-menu a {
            overflow: hidden;
            outline: none;
        }

        .bss-input {
            border: 0;
            outline: none;
            color: #000;
            width: 100%;
            background-color: #ffffff;
            font-size: 16px;
            border-bottom: 2px solid #000000;
        }

        .bss-input::-webkit-input-placeholder {
            opacity: 1;
            color: #000000;
        }

        .bss-input:-moz-placeholder {
            opacity: 1;
            color: #000000;
        }

        .bss-input::-moz-placeholder {
            opacity: 1;
            color: #000000;
        }

        .bss-input:-ms-input-placeholder {
            opacity: 1;
            color: #000000;
        }

        .bss-input:hover {
            background-color: #ffffff;
        }

        .dropdown-item.addItem {
            background: none;
            padding: 0;
            position: relative;
        }

        .addItem .bss-input {
            height: 40px;
            padding: 0 1.5rem;
        }

        .addItem:focus {
            background: none;
        }

        .bootstrap-select .dropdown-menu li a.addItem span.text {
            display: block;
        }

        .additem .check-mark {
            opacity: 0;
            z-index: -1000;
        }

        .addnewicon {
            position: absolute;
            padding: 0;
            margin: 0;
            right: 0;
            top: 0;
            line-height: 40px;
            text-align: center;
            font-size: 25px;
            width: 40px;
            height: 40px;
            color: #000000;
        }

        .addnewicon:hover {
            color: #000000;
        }

        .bootstrap-select>.dropdown-toggle {
            width: 100%;
            background: #DCEBED !important;
            box-shadow: none !important;
            outline: none !important;
            color: #000000;
            height: 60px;
            padding: .375rem 1.5rem;
            border-radius: 0;
            border: 2px solid #000000 !important;
            font-size: 20px;
        }

        .bootstrap-select .dropdown-toggle:focus,
        .bootstrap-select>select.mobile-device:focus+.dropdown-toggle {
            outline: none !important;
            border: 2px solid #000000;
        }

        .dropdown-item {
            padding: .50rem 1.5rem;
            color: #000000;
            font-size: 18px;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background: #000000;
        }

        .bootstrap-select .dropdown-menu {
            border: 2px solid #000000;
            border-radius: 0;
            background: #DCEBED;
        }

        .add-plus {
            background-color: black;
            color: white;
            font-size: 25px;
            position: absolute;
            top: 0;
            left: 0;
            padding: 7px;
            width: 30px;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('admin.notifications') }}
        @endslot
        @slot('title')
            {{ __('admin.notifications') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0"> {{ __('admin.notifications') }}</h4>
                    <button data-effect="effect-newspaper" data-toggle="modal" href="#myModal"
                        class="btn btn-primary button-icon"><i
                            class="far fa-paper-plane ml-2 font-weight-bolder"></i>{{ __('admin.send_notification') }}</button>
                </div>
                <div class="card-body table-responsive border-0">
                    @include('layouts.session')
                    <table id="datatable" class="table table-bordered dt-responsive text-nowrap w-100">
                        <thead>
                            <tr style="cursor: pointer;">
                                <th class="fw-bold">#</th>
                                <th class="fw-bold">{{ __('admin.title') }}</th>
                                <th class="fw-bold">{{ __('admin.message') }}</th>
                                <th class="fw-bold">{{ __('admin.to') }}</th>
                                <th class="fw-bold">{{ __('admin.created_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($notifications) == 0)
                                <tr class="align-middle">
                                    <td colspan="5" class="text-center">{{ __('admin.no_data') }}</td>
                                </tr>
                            @endif
                            @foreach ($notifications as $count => $notification)
                                <tr data-id="{{ $count + 1 }}">
                                    <td style="width: 80px" class="align-middle">{{ $count + 1 }}</td>
                                    <td class="align-middle">{{ $notification->title }}</td>
                                    <td class="align-middle">{{ $notification->message }}</td>
                                    <td class="align-middle">
                                        @if ($notification->all)
                                            كل الاعضاء
                                        @else
                                            <a data-effect="effect-newspaper" data-toggle="modal"
                                                href="#modelUser{{ $notification->id }}">{{ $notification->user->name }}</a>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $notification->created_at }}
                                    </td>
                                </tr>
                                @if (!$notification->all)
                                    <div class="modal" id="modelUser{{ $notification->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('admin.userDetials') }}</h5>
                                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                                        type="button"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="d-inline">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="title">{{ __('admin.name') }} <span
                                                                            class="text-danger fw-bolder">*</span></label>
                                                                    <input readonly type="input"
                                                                        class="form-control @error('title') is-invalid @enderror"
                                                                        id="title" name="title"
                                                                        placeholder="{{ __('admin.name') }}"
                                                                        value="{{ $notification->user->name }}"
                                                                        required>
                                                                    @error('title')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="title">{{ __('admin.email') }} <span
                                                                            class="text-danger fw-bolder">*</span></label>
                                                                    <input readonly type="input"
                                                                        class="form-control @error('title') is-invalid @enderror"
                                                                        id="title" name="title"
                                                                        placeholder="{{ __('admin.email') }}"
                                                                        value="{{ $notification->user->email ?? '' }}"
                                                                        required>
                                                                    @error('title')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="title">{{ __('admin.phone') }} <span
                                                                            class="text-danger fw-bolder">*</span></label>
                                                                    <input readonly type="input"
                                                                        class="form-control @error('title') is-invalid @enderror"
                                                                        id="title" name="title"
                                                                        placeholder="{{ __('admin.phone') }}"
                                                                        value="{{ $notification->user->phone ?? '' }}"
                                                                        required>
                                                                    @error('title')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary waves-effect"
                                                        data-dismiss="modal">{{ __('admin.back') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12 pagination-box">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.send_notification') }}</h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="acceptForm" class="d-inline" action="{{ route('rfoof.notifications.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="title_ar">{{ __('admin.title_ar') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="input" class="form-control @error('title') is-invalid @enderror"
                                        id="title_ar" name="title_ar" placeholder="{{ __('admin.title_ar') }}"
                                        value="{{ old('title_ar') }}" required>
                                    @error('title_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="title">{{ __('admin.title_en') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="input" class="form-control @error('title') is-invalid @enderror"
                                        id="title_en" name="title_en" placeholder="{{ __('admin.title_en') }}"
                                        value="{{ old('title_en') }}" required>
                                    @error('title_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="message_ar" class="form-label">{{ __('admin.message_ar') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <textarea class="form-control @error('message_ar') is-invalid @enderror" id="message"
                                        placeholder="{{ __('admin.message_ar') }}" name="message_ar" required>{{ old('message_ar') }}</textarea>
                                    @error('message_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="message_en" class="form-label">{{ __('admin.message_en') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <textarea class="form-control @error('message_en') is-invalid @enderror" id="message_en"
                                        placeholder="{{ __('admin.message_en') }}" name="message_en" required>{{ old('message_en') }}</textarea>
                                    @error('message_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="choose" class="form-label">{{ __('admin.choose') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <label class="form-switch">
                                        <input type="checkbox" name="choose" onclick="getEmployee(this)"
                                            class="form-control d-none @error('verified') is-invalid @enderror" />
                                        <div class="main-toggle main-toggle-success" style="cursor: pointer">
                                            <span data-on-label="{{ __('admin.yes') }}"
                                                data-off-label="{{ __('admin.no') }}"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="missionEmployee">
                                <div class="mb-3">
                                    <label class="form-label" for="employee_id">{{ __('admin.users') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <div class="dropdown">
                                        <input type="text" class="border border-dark myInput" style="cursor:pointer;"
                                            placeholder="{{ __('admin.search') }}" onclick="myFunction(this)"
                                            onkeyup="filterFunction(this)">
                                        <div class="dropdown-content">
                                            <input name="employee_id" type="hidden" required />
                                            @foreach ($users as $employee)
                                                <a
                                                    onclick="myFunction2(this, {{ $employee->id }}, '{{ $employee->name }}')">{{ $employee->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="message" class="form-label">{{ __('admin.sms_message') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <label class="form-switch">
                                        <input type="checkbox" name="sms_message"
                                            class="form-control d-none @error('verified') is-invalid @enderror" />
                                        <div class="main-toggle main-toggle-success" style="cursor: pointer">
                                            <span data-on-label="{{ __('admin.yes') }}"
                                                data-off-label="{{ __('admin.no') }}"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="message" class="form-label">{{ __('admin.phone_message') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <label class="form-switch">
                                        <input type="checkbox" name="phone_message"
                                            class="form-control d-none @error('verified') is-invalid @enderror" />
                                        <div class="main-toggle main-toggle-success" style="cursor: pointer">
                                            <span data-on-label="{{ __('admin.yes') }}"
                                                data-off-label="{{ __('admin.no') }}"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-dismiss="modal">{{ __('admin.back') }}</button>
                    <button form="acceptForm" type="submit"
                        class="btn btn-success waves-effect waves-light">{{ __('admin.send_notification') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        function getEmployee(e) {
            if (e.checked) {
                document.getElementById('missionEmployee').style.display = "none";
            } else {
                document.getElementById('missionEmployee').style.display = "block";
            }
        }
        /* When the user clicks on the button,
                        toggle between hiding and showing the dropdown content */
        function myFunction(e) {
            var elements = document.getElementsByClassName("myInput");
            for (let i = 0; i < elements.length; i++) {
                elements[i].classList.remove("show");
            }
            e.nextElementSibling.classList.add("show");
        }

        function myFunctionCategory(e) {
            var elements = document.getElementsByClassName("myInput2");
            console.log(elements);
            for (let i = 0; i < elements.length; i++) {
                elements[i].classList.remove("show");
            }
            e.nextElementSibling.classList.add("show");
        }

        document.onclick = function(e) {
            if (!e.target.classList.contains("myInput")) {
                var elements = document.getElementsByClassName("myInput");
                for (let i = 0; i < elements.length; i++) {
                    elements[i].nextElementSibling.classList.remove("show");
                }
            }
        };
        document.onclick = function(e) {
            if (!e.target.classList.contains("myInput2")) {
                var elements = document.getElementsByClassName("myInput2");
                for (let i = 0; i < elements.length; i++) {
                    elements[i].nextElementSibling.classList.remove("show");
                }
            }
            if (!e.target.classList.contains("myInput")) {
                var elements = document.getElementsByClassName("myInput");
                for (let i = 0; i < elements.length; i++) {
                    elements[i].nextElementSibling.classList.remove("show");
                }
            }
        };

        function filterFunction(input) {
            var filter, ul, li, a, i;
            filter = input.value.toUpperCase();
            div = input.nextElementSibling;
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }

        function myFunction2(e, id, name) {
            e.parentElement.firstElementChild.value = id;
            e.previousElementSibling.parentElement.previousElementSibling.value = name;
        }

        function myFunction2Category(e, id, name) {
            e.parentElement.firstElementChild.value = id;
            e.previousElementSibling.parentElement.previousElementSibling.value = name;
        }
    </script>
@endsection
