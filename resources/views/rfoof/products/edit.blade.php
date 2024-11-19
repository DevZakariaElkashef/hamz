@extends('layouts.master')
@section('title')
    {{ __('admin.product_edit') }}
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
            {{ __('admin.product_edit') }}
        @endslot
        @slot('title')
            {{ __('admin.product_edit') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-0">{{ __('admin.product_edit') }}</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation" action="{{ route('products.update') }}" method="POST"
                        enctype="multipart/form-data" id="product-form">
                        @csrf
                        @method('put')
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        @include('layouts.session')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="images">{{ __('admin.image') }}</label>
                                    <input multiple type="file"
                                        class="form-control @error('images') is-invalid @enderror" id="image"
                                        name="images[]">
                                    @error('images')
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
                                        value="{{ $product->name_ar }}" required>
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
                                        value="{{ $product->name_en }}" required>
                                    @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="price">{{ __('admin.price') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="number" min="1"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        name="price" placeholder="{{ __('admin.price') }}" value="{{ $product->price }}"
                                        required>
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="count">{{ __('admin.count') }} <span
                                            class="text-danger fw-bolder">*</span></label>
                                    <input type="number"min="1" class="form-control @error('count') is-invalid @enderror"
                                        id="count" name="count" placeholder="{{ __('admin.count') }}"
                                        value="{{ $product->count }}" required>
                                    @error('count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="category_id">{{ __('admin.categories') }}<span
                                            class="text-danger fw-bolder">*</span></label>
                                    <select class="form-control form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                        <option value="" selected disabled>{{ __('admin.choose_category') }}
                                        </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($product->category_id == $category->id) selected @endif>{{ $category->title() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
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
                                    <label class="form-label" for="desc">{{ __('admin.desc_ar') }}<span
                                            class="text-danger fw-bolder">*</span></label>
                                    <textarea class="form-control @error('desc_ar') is-invalid @enderror" id="description" name="desc_ar"
                                        placeholder="{{ __('admin.desc_ar') }}">{{ $product->desc_ar }}</textarea>
                                    @error('desc_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="desc">{{ __('admin.desc_en') }}<span
                                            class="text-danger fw-bolder">*</span></label>
                                    <textarea class="form-control @error('desc_en') is-invalid @enderror" id="description_en" name="desc_en"
                                        placeholder="{{ __('admin.desc_en') }}">{{ $product->desc_en }}</textarea>
                                    @error('desc_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">{{ __('admin.product_edit') }}</button>
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
