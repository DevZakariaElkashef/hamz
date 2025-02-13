@extends('layouts.master')
@section('title')
    {{ __('main.home') }}
@endsection
@section('css')
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.welcome_dashboard') }}</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')

    {{-- <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">الاجمالى</h2>
        </div>
    </div> --}}
    <!-- row -->
    <div class="row mt-3 d-flex justify-content-center row-sm">

        @if (auth()->user()->role->name == "super-admin")
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-secondary-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.stores') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $srores->count() }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7"> -23.09%</span> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <span  class="pt-1">
                        <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                    </span>
                </div>
            </div>
        @endif

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.orders') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $orders->count() }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">
                    <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.total_incom') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalIncome }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> -23.09%</span> --}}
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">
                    <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.total_commission') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalCommission }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> -23.09%</span> --}}
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">
                    <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                </span>
            </div>
        </div>



    </div>
    <!-- row closed -->
    <!-- Modal effects -->
    <div class="modal" id="importmodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('main.import') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" id="importForm" action="{{ route('mall.sections.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">{{ __('main.select_file') }}</label>
                            <input type="file" class="form-control" accept=".xlsx" id="file" name="file">
                        </div>
                        <div class="mt-3">
                            <a href="{{ asset("imports/sections.xlsx") }}" download class="btn btn-warning">{{ __('main.download_example') }}</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('main.import') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('main.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="deletemodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('main.delete') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="ids" id="selectionIdsInput">
                    <div class="modal-body">
                        <h6 class="text-center">{{ __('main.Are_you_sure') }}</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">{{ __('main.delete') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('main.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="filterModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('main.filter') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="get" action="{{ route('mall.sections.index') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start_at">{{ __('main.start_date') }}</label>
                            <input type="date" name="start_at" value="{{ request('start_at') }}" id="start_at"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="end_at">{{ __('main.end_date') }}</label>
                            <input type="date" name="end_at" value="{{ request('end_at') }}" id="end_at"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="is_active">{{ __('main.status') }}</label>
                            <select name="is_active" class="form-control">
                                <option value="">{{ __('main.all') }}</option>
                                <option value="0" @if (request('is_active') == '0') selected @endif>
                                    {{ __('main.not_active') }}</option>
                                <option value="1" @if (request('is_active') == '1') selected @endif>
                                    {{ __('main.active') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('main.filter') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('main.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal effects-->
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('main.sections') }}</h4>
                        <div class="d-flex">
                            <a href="#" class="btn btn-danger mx-1 d-none" id="deleteSelectionBtn"
                                data-toggle="modal" data-effect="effect-flip-vertical" data-target="#deletemodal"
                                data-url="{{ route('mall.sections.delete') }}">{{ __('main.delete') }}</a>
                            <input type="text" id="searchInput" data-url="{{ route('mall.sections.search') }}"
                                class="form-control" placeholder="{{ __('main.search') }}">
                            <div class="custom-select-wrapper mx-1">
                                <select id="showPerPage" class="custom-select"
                                    data-url="{{ route('mall.sections.index') }}" onchange="updatePageSize()">
                                    <option value="10" @if (request('per_page') && request('per_page') == 10) selected @endif>10</option>
                                    <option value="25" @if (request('per_page') && request('per_page') == 25) selected @endif>25</option>
                                    <option value="50" @if (request('per_page') && request('per_page') == 50) selected @endif>50</option>
                                    <option value="100" @if (request('per_page') && request('per_page') == 100) selected @endif>100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tableFile">
                        @include('commissionReports.table')
                    </div>
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
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
