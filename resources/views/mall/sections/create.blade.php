@extends('mall.layouts.master')
@section('title')
    {{ __('mall.create_section') }}
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
                <h5 class="content-title mb-0 my-auto">{{ __('mall.home') }}</h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.sections.index') }}">{{ __('mall.sections') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.sections.create') }}">{{ __('mall.create_section') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('mall.sections.index') }}" class="btn btn-secondary ">{{ __('mall.back') }}</a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('mall.sections') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('mall.sections.store') }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.name') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="name_ar" placeholder="{{ __('mall.enter_name') }}"
                                    required="" type="text" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.name') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="name_en" placeholder="{{ __('mall.enter_name') }}"
                                    required="" type="text" value="{{ old('name_en') }}">
                                @error('name_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.status') }}: <span class="tx-danger">*</span></label>
                                <select required class="form-control" name="is_active">
                                    <option value="0" @if (old('is_active') == 0) selected @endif>
                                        {{ __('mall.not_active') }}</option>
                                    <option value="1" @if (old('is_active') == 1) selected @endif>
                                        {{ __('mall.active') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="customFile">{{ __('mall.image') }}</label>
                                    <input class="custom-file-input" required id="customFile" type="file" name="image">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mg-t-10 mg-sm-t-25">
                                <button class="btn btn-main-primary pd-x-20"
                                    type="submit">{{ __('mall.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/div-->
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
