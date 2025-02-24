@extends('earn.layouts.master')
@section('title')
    {{ __('main.edit_video') }}
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
                        href="{{ route('earn.videos.index') }}">{{ __('main.videos') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('earn.videos.edit', $video->id) }}">{{ __('main.edit_video') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('earn.videos.index') }}" class="btn btn-secondary ">{{ __('main.back') }}</a>
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
                        <h4 class="card-title mg-b-0">{{ __('main.videos') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('earn.videos.update', $video->id) }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="title_ar" placeholder="{{ __('main.enter_name') }}"
                                    required="" type="text"
                                    value="{{ old('title_ar', $video->title_ar) ?? $video->title_ar }}">
                                @error('title_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="title_en" placeholder="{{ __('main.enter_name') }}"
                                    required="" type="text"
                                    value="{{ old('title_en', $video->title_en) ?? $video->title_en }}">
                                @error('title_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.duration') }}:</label>
                                <input class="form-control" name="duration" id="duration"
                                    placeholder="{{ __('main.duration') }}" type="number"
                                    value="{{ old('duration', $video->duration) }}">
                                @error('duration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.reword_amount') }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="reword_amount"
                                    placeholder="{{ __('main.enter_reword_amount') }}" required="" type="number"
                                    value="{{ old('reword_amount', $video->reword_amount) }}">
                                @error('reword_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="customFile">{{ __('main.thumbnail') }}</label>
                                    <input class="custom-file-input" id="customFile" type="file" accept=".jpg,.png,.jpeg"
                                        name="thumbnail">
                                    @error('thumbnail')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.store') }}: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" name="store_id">
                                    <option value selected disabled>
                                        {{ __('main.select_store') }}
                                    </option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            @if ($video->store_id == $store->id) selected @endif>{{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('store_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="custom-file">
                                    <label class="" for="path">{{ __('main.url') }}</label>
                                    <input class="form-control" id="path" type="url" name="path"
                                        value="{{ $video->path }}">
                                    @error('path')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="custom-file">
                                    <label class="store_url" for="store_url">{{ __('main.store_url') }}</label>
                                    <input class="form-control" id="store_url" type="store_url" name="store_url"
                                        value="{{ old('store_url', $video->store_url) }}">
                                    @error('store_url')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.status') }}: <span class="tx-danger">*</span></label>
                                <select required class="form-control" name="is_active">
                                    <option value="0" @if (old('is_active', $video->is_active) == 0) selected @endif>
                                        {{ __('main.not_active') }}</option>
                                    <option value="1" @if (old('is_active', $video->is_active) == 1) selected @endif>
                                        {{ __('main.active') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.category') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (old('category_id', $video->category_id) == $category->id) selected @endif>
                                            {{ $category->{'name_' . app()->getLocale()} }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
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
