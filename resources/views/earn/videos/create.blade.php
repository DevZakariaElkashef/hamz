@extends('earn.layouts.master')
@section('title')
    {{ __('main.create_video') }}
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
                        href="{{ route('earn.videos.create') }}">{{ __('main.create_video') }}</a></span>
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
                    <form method="post" action="{{ route('earn.videos.store') }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="title_ar" placeholder="{{ __('main.enter_name') }}"
                                    required="" type="text" value="{{ old('title_ar') }}">
                                @error('title_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="title_en" placeholder="{{ __('main.enter_name') }}"
                                    required="" type="text" value="{{ old('title_en') }}">
                                @error('title_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Video Duration Input Field -->
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.duration') }}:</label>
                                <input class="form-control" name="duration" id="duration"
                                    placeholder="{{ __('main.duration') }}" type="number"
                                    value="{{ old('duration') }}">
                                @error('duration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.reword_amount') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="reword_amount"
                                    placeholder="{{ __('main.enter_reword_amount') }}" required="" type="number"
                                    value="{{ old('reword_amount') }}">
                                @error('reword_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="customFile">{{ __('main.thumbnail') }}</label>
                                    <input class="custom-file-input" required id="customFile" type="file"
                                        accept=".jpg,.png,.jpeg" name="thumbnail">
                                    @error('thumbnail')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if (auth()->user()->role_id != 3)
                                <div class="col-md-6 form-group mg-b-0">
                                    <label class="form-label">{{ __('main.store') }}: <span
                                            class="tx-danger">*</span></label>
                                    <select required class="form-control select2" name="store_id">
                                        <option value selected disabled>
                                            {{ __('main.select_store') }}
                                        </option>
                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}">
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('store_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <input hidden name='store_id' value="{{ auth()->user()->store_id }}">
                            @endif

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.status') }}: <span class="tx-danger">*</span></label>
                                <select required class="form-control" name="is_active">
                                    <option value="0" @if (old('is_active') == 0) selected @endif>
                                        {{ __('main.not_active') }}</option>
                                    <option value="1" @if (old('is_active') == 1) selected @endif>
                                        {{ __('main.active') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="col-md-6 form-group">
                                <div class="custom-file">
                                    <label class="path" for="path">{{ __('main.url') }}</label>
                                    <input class="form-control" required id="path" type="url" name="path" value="{{ old('path') }}">
                                    @error('path')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.category') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (old('category_id') == $category->id) selected @endif>
                                            {{ $category->{'name_' . app()->getLocale()                                                                                                                                                                                                                                                            } }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="my-3 preview-video">
                                <!-- Video preview will be displayed here -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('customFileVideo').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && file.type === 'video/mp4') {
                    const videoPreviewContainer = document.querySelector('.preview-video');
                    const durationInput = document.getElementById('durationInput');

                    videoPreviewContainer.innerHTML = ''; // Clear any existing preview
                    durationInput.value = ''; // Clear the duration input

                    const video = document.createElement('video');
                    video.width = 300; // Set video width
                    video.controls = true; // Add controls (play, pause, etc.)
                    video.src = URL.createObjectURL(file);

                    // When video metadata (such as duration) is loaded
                    video.addEventListener('loadedmetadata', function() {
                        // Set the video duration (in seconds) to the input field
                        const duration = video.duration;
                        durationInput.value = duration.toFixed(2); // Format duration with 2 decimal places
                    });

                    videoPreviewContainer.appendChild(video);
                }
            });
        });
    </script>
@endsection
