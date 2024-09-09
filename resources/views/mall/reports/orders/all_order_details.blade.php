@extends('mall.layouts.master')
@section('title')
    {{ __('mall.products') }}
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
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto"><a href="{{ route('mall.home') }}"
                        class="text-dark">{{ __('mall.home') }}</a></h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.reports.allOrderDetails') }}">{{ __('mall.Product_Sales') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('mall.reports.allOrderDetailsExport', ['start_at' => request('start_at'), 'end_at' => request('end_at'), 'section_id' => request('section_id'), 'store_id' => request('store_id'),]) }}"
                    class="btn btn-secondary ml-2" data-toggle="tooltip" title="{{ __('mall.export_to_excel') }}">
                    {{ __('mall.export') }}
                    <i class="mdi mdi-download"></i>
                </a>

            </div>

            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon ml-2" data-target="#filterModal" data-toggle="modal"
                    data-effect="effect-flip-vertical"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('mall.reports.allOrderDetails') }}" class="btn btn-warning  btn-icon ml-2"><i
                        class="mdi mdi-refresh"></i></a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
      <div class="modal" id="filterModal">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('mall.filter') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="get" action="{{ route('mall.reports.allOrderDetails') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start_at">{{ __('mall.start_date') }}</label>
                            <input type="date" name="start_at" value="{{ request('start_at') }}" id="start_at"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="end_at">{{ __('mall.end_date') }}</label>
                            <input type="date" name="end_at" value="{{ request('end_at') }}" id="end_at"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="sectionId">{{ __('mall.section') }}</label>
                            <select id="sectionId" name="section_id" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" @if (request('section_id') == $section->id) selected @endif>
                                        {{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="storeId">{{ __('mall.store') }}</label>
                            <select id="storeId" name="store_id" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('mall.filter') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
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
                        <h4 class="card-title mg-b-0">{{ __('mall.products') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tableFile">
                        @include('mall.reports.orders.all_order_details_table')
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
