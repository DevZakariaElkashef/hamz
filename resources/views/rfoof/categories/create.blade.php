@extends('rfoof.layouts.master')
@section('title')
    {{ __('admin.add_category') }}
@endsection
@section('css')
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('admin.add_category') }}
        @endslot
        @slot('title')
            {{ __('admin.add_category') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-0">{{ __('admin.add_category') }}</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation" action="{{ route('rfoof.categories.store') }}" method="POST"
                        enctype="multipart/form-data" id="product-form">
                        @csrf
                        @include('layouts.session')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-switch">
                                        <input type="checkbox" name="show"
                                            class="form-control d-none @error('show') is-invalid @enderror" />
                                        <div class="main-toggle main-toggle-success" style="cursor: pointer">
                                            <span data-on-label="{{ __('admin.showIcon') }}"
                                                data-off-label="{{ __('admin.hide') }}"></span>
                                        </div>
                                    </label>
                                    @error('show')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="image">{{ __('admin.image') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" required>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name_ar">{{ __('admin.name_ar') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                        id="name_ar" name="name_ar" placeholder="{{ __('admin.name_ar') }}"
                                        value="{{ old('name_ar') }}" required>
                                    @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name_en">{{ __('admin.name_en') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" name="name_en" placeholder="{{ __('admin.name_en') }}"
                                        value="{{ old('name_en') }}" required>
                                    @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">{{ __('admin.add_category') }}</button>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
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
    <!-- Internal ckeditor js -->
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/ckeditor.js') }}"></script>
    <!-- Handle Product Details -->
    <script src="{{ URL::asset('assets/js/product.details.js') }}"></script>
@endsection
