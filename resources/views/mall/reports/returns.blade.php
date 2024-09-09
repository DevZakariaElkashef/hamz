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
                <a href="{{ route('mall.products.export', ['start_at' => request('start_at'), 'end_at' => request('end_at'), 'is_active' => request('is_active'), 'category_id' => request('category_id'), 'brand_id' => request('brand_id')]) }}"
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
                <a href="{{ route('mall.products.index') }}" class="btn btn-warning  btn-icon ml-2"><i
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

    <div class="modal" id="filterModal">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('mall.filter') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                {{-- <form method="get" action="{{ route('mall.products.index') }}">
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
                            <label for="is_active">{{ __('mall.status') }}</label>
                            <select name="is_active" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                <option value="0" @if (request('is_active') == '0') selected @endif>
                                    {{ __('mall.not_active') }}</option>
                                <option value="1" @if (request('is_active') == '1') selected @endif>
                                    {{ __('mall.active') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sectionId">{{ __('mall.section') }}</label>
                            <select id="sectionId" name="product_section_id" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" @if (request('section_id') == $section->id) selected @endif>
                                        {{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="storeId">{{ __('mall.store') }}</label>
                            <select id="storeId" name="product_store_id" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoryId">{{ __('mall.category') }}</label>
                            <select id="categoryId" name="category_id" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == request('category_id')) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brandId">{{ __('mall.brand') }}</label>
                            <select id="brandId" name="brand_id" class="form-control">
                                <option value="">{{ __('mall.all') }}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @if ($brand->id == request('brand_id')) selected @endif>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('mall.filter') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </form> --}}
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
                            <a href="#" class="btn btn-danger mx-1 d-none" id="deleteSelectionBtn"
                                data-toggle="modal" data-effect="effect-flip-vertical" data-target="#deletemodal"
                                data-url="{{ route('mall.products.delete') }}">{{ __('mall.delete') }}</a>
                            <input type="text" id="searchInput" data-url="{{ route('mall.products.search') }}"
                                class="form-control" placeholder="{{ __('mall.search') }}">
                            <div class="custom-select-wrapper mx-1">
                                <select id="showPerPage" class="custom-select"
                                    data-url="{{ route('mall.products.index') }}" onchange="updatePageSize()">
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('mall.Order_number') }}</th>
                                        <th>{{ __('mall.product') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->product->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
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

    @include('mall.products._dynamic_selector')
@endsection
