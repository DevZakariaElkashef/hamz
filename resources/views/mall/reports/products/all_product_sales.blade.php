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
                        href="{{ route('mall.reports.allProductSales') }}">{{ __('mall.Product_Sales') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('mall.reports.allProductSalesExport', ['search' => request('search')]) }}"
                    class="btn btn-secondary ml-2" data-toggle="tooltip" title="{{ __('mall.export_to_excel') }}">
                    {{ __('mall.export') }}
                    <i class="mdi mdi-download"></i>
                </a>

            </div>

            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('mall.reports.allProductSales') }}" class="btn btn-warning  btn-icon ml-2"><i
                        class="mdi mdi-refresh"></i></a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- Modal effects -->
    <div class="modal" id="importmodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('mall.import') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" id="importForm" action="{{ route('mall.products.import') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">{{ __('mall.select_file') }}</label>
                            <input type="file" class="form-control" accept=".xlsx" id="file" name="file">
                        </div>
                        <div class="mt-3">
                            <a href="{{ asset('imports/products.xlsx') }}" download
                                class="btn btn-warning">{{ __('mall.download_example') }}</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('mall.import') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="deletemodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('mall.delete') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="ids" id="selectionIdsInput">
                    <div class="modal-body">
                        <h6 class="text-center">{{ __('mall.Are_you_sure') }}</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">{{ __('mall.delete') }}</button>
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
                        <div class="d-flex">
                            <a href="#" class="btn btn-danger mx-1 d-none" id="deleteSelectionBtn" data-toggle="modal"
                                data-effect="effect-flip-vertical" data-target="#deletemodal"
                                data-url="{{ route('mall.products.delete') }}">{{ __('mall.delete') }}</a>

                            <input type="text" id="searchReport"
                                data-url="{{ route('mall.reports.allProductSalesSearch') }}" class="form-control"
                                placeholder="{{ __('mall.search') }}">

                            <div class="custom-select-wrapper mx-1">
                                <select id="showPerPage" class="custom-select"
                                    data-url="{{ route('mall.reports.allProductSales') }}" onchange="updatePageSize()">
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
                        @include('mall.reports.all_product_sales_table')
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
