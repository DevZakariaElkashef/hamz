@extends('earn.layouts.master')
@section('title')
    {{ __('main.subscripe') }}
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
                        href="{{ route('earn.subscripe.create', $video_id) }}">{{ __('main.subscripe') }}</a></span>
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
                        <h4 class="card-title mg-b-0">{{ __('main.subscripe') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('earn.subscripe.store', $video_id) }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-12 form-group mg-b-0">
                                <label class="form-label">{{ __('main.packages') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control" name="package_id" id="package-id"
                                    onchange="fillPackageTable()">
                                    @foreach ($packages as $key => $package)
                                        <option value="{{ $package->id }}" aria-valuenow="{{ $key }}"
                                            @if (old('package_id') == $package->id) selected @endif>
                                            {{ $package->name }}</option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="table-responsive mt-5">
                                <table class="table mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th>{{ __('main.name') }}</th>
                                            <th>{{ __('main.limit') }}</th>
                                            {{-- <th>{{ __('main.period_in_days') }}</th> --}}
                                            {{-- <th>قيمه المكافأه</th> --}}
                                            <th>{{ __('main.price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="package-name"></td>
                                            <td id="package-limit"></td>
                                            {{-- <td id="package-reword_amount"></td> --}}
                                            <td id="package-price"></td>
                                        </tr>
                                    </tbody>
                                </table>
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
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
    <script>
        var packageSelector = document.getElementById('package-id');
        var packages = {!! json_encode($packages) !!};
        var language = "{{ app()->getLocale() }}";

        function fillPackageTable() {
            let selectedOption = packageSelector.options[packageSelector.selectedIndex];
            let ariaValue = selectedOption.getAttribute("aria-valuenow");
            let package = packages[ariaValue];
            document.getElementById('package-name').innerText = package["name_" + language];
            document.getElementById('package-limit').innerText = package.limit;
            //document.getElementById('package-reword_amount').innerText = package.reword_amount;
            document.getElementById('package-price').innerText = package.price + "{{ ' ' . __('main.sar') }}";
        }

        window.onload = fillPackageTable();
    </script>
@endsection
@endsection
