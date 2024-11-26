@extends('booth.layouts.master')
@section('title')
    {{ __('main.products') }}
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
                <h5 class="content-title mb-0 my-auto"><a href="{{ route('booth.home') }}"
                        class="text-dark">{{ __('main.home') }}</a></h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('booth.reports.customerActivity') }}">{{ __('main.Product_Sales') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('booth.reports.customerActivityExport', ['start_at' => request('start_at'), 'end_at' => request('end_at'), 'is_active' => request('is_active'), 'category_id' => request('category_id'), 'brand_id' => request('brand_id')]) }}"
                    class="btn btn-secondary ml-2" data-toggle="tooltip" title="{{ __('main.export_to_excel') }}">
                    {{ __('main.export') }}
                    <i class="mdi mdi-download"></i>
                </a>

            </div>

            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('booth.reports.customerActivity') }}" class="btn btn-warning  btn-icon ml-2"><i
                        class="mdi mdi-refresh"></i></a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- End Modal effects-->
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('main.products') }}</h4>
                        <div class="d-flex">

                            <input type="text" id="searchReport"
                                data-url="{{ route('booth.reports.customerActivitySearch') }}" class="form-control"
                                placeholder="{{ __('main.search') }}">
                            <div class="custom-select-wrapper mx-1">
                                <select id="showPerPage" class="custom-select"
                                    data-url="{{ route('booth.reports.customerActivity') }}" onchange="updatePageSize()">
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
                        @include('booth.reports.customers.customer_activity_table')
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

    <script>
        $(document).on('input', '#searchReport', function() {
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                data: {
                    search: $(this).val()
                },
                success: function(response) {
                    $('#tableFile').html(response);
                }
            });
        })
    </script>
@endsection
