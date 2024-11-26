@extends('booth.layouts.master')
@section('title')
    {{ __('main.edit_option') }}
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
                        href="{{ route('booth.options.index') }}">{{ __('main.options') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('booth.options.edit', $option->id) }}">{{ __('main.edit_option') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('booth.options.index') }}" class="btn btn-secondary ">{{ __('main.back') }}</a>
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
                        <h4 class="card-title mg-b-0">{{ __('main.options') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('booth.options.update', $option->id) }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.value') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="value_ar" placeholder="{{ __('main.enter_value') }}"
                                    required="" type="text" value="{{ old('value_ar') ?? $option->value_ar }}">
                                @error('value_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.value') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="value_en" placeholder="{{ __('main.enter_value') }}"
                                    required="" type="text" value="{{ old('value_en') ?? $option->value_en }}">
                                @error('value_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.attribute') }}: <span class="tx-danger">*</span></label>
                                <select required class="form-control" name="attribute_id">
                                    @foreach ($attributes as $attribute)
                                        <option value="{{ $attribute->id }}" @if(old('attribute_id', $option->attribute_id) == $attribute->id) selected @endif>{{ $attribute->name }}</option>
                                    @endforeach
                                </select>
                                @error('attribute_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.status') }}: <span class="tx-danger">*</span></label>
                                <select required class="form-control" name="is_active">
                                    <option value="0" @if (old('is_active', $option->is_active) == 0) selected @endif>
                                        {{ __('main.not_active') }}</option>
                                    <option value="1" @if (old('is_active', $option->is_active) == 1) selected @endif>
                                        {{ __('main.active') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-12 mg-t-10 mg-sm-t-25">
                                <button class="btn btn-main-primary pd-x-20"
                                    type="submit">{{ __('main.submit') }}</button>
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
