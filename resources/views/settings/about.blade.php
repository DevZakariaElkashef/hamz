@extends('layouts.master')
@section('title')
    {{ __('main.about_us') }}
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">{{ __('main.home') }}</h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('abouts.index') }}">{{ __('main.about_us') }}</a></span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4 mb-lg-0 mb-4">
            <h4>{{ __('main.settings') }}</h4>
            @include('settings._nav')


        </div>

        <!-- /Categories -->

        <!-- Article -->
        <div class="col-xl-9 col-lg-8 col-md-8">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <form action="{{ route('abouts.update', $about) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content_ar">{{ __('main.content') }}(AR)</label>
                                    <textarea id="content_ar" class="form-control" type="text" name="content_ar">{{ $about->content_ar }}</textarea>
                                    @error('content_ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content_en">{{ __('main.content') }}(EN)</label>
                                    <textarea id="content_en" class="form-control" type="text" name="content_en">{{ $about->content_en }}</textarea>
                                    @error('content_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Article -->
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection

