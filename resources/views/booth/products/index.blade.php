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
                        href="{{ route('booth.products.index') }}">{{ __('main.products') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('booth.products.import')
                <div class="pr-1 mb-3 mb-xl-0">
                    <a class="btn btn-success  ml-2" data-target="#importmodal" data-toggle="modal"
                        data-effect="effect-flip-vertical">
                        {{ __('main.import') }}
                        <i class="mdi mdi-upload"></i>
                    </a>
                </div>
            @endcan

            @can('booth.products.export')
                <div class="pr-1 mb-3 mb-xl-0">
                    <a href="{{ route('booth.products.export', ['start_at' => request('start_at'), 'end_at' => request('end_at'), 'is_active' => request('is_active'), 'category_id' => request('category_id'), 'brand_id' => request('brand_id')]) }}"
                        class="btn btn-secondary ml-2" data-toggle="tooltip" title="{{ __('main.export_to_excel') }}">
                        {{ __('main.export') }}
                        <i class="mdi mdi-download"></i>
                    </a>
                </div>
            @endcan

            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon ml-2" data-target="#filterModal" data-toggle="modal"
                    data-effect="effect-flip-vertical"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('booth.products.index') }}" class="btn btn-warning  btn-icon ml-2"><i
                        class="mdi mdi-refresh"></i></a>
            </div>

            @can('booth.products.create')
                <div class="mb-3 mb-xl-0">
                    <a href="{{ route('booth.products.create') }}" class="btn btn-primary ">{{ __('main.create') }}</a>
                </div>
            @endcan
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
                    <h6 class="modal-title">{{ __('main.import') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" id="importForm" action="{{ route('booth.products.import') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">{{ __('main.select_file') }}</label>
                            <input type="file" class="form-control" accept=".xlsx" id="file" name="file">
                        </div>
                        <div class="mt-3">
                            <a href="{{ asset('imports/products.xlsx') }}" download
                                class="btn btn-warning">{{ __('main.download_example') }}</a>
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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('main.filter') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="get" action="{{ route('booth.products.index') }}">
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
                        <div class="form-group">
                            <label for="sectionId">{{ __('main.section') }}</label>
                            <select id="sectionId" name="product_section_id" class="form-control">
                                <option value="">{{ __('main.all') }}</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" @if (request('section_id') == $section->id) selected @endif>
                                        {{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="storeId">{{ __('main.store') }}</label>
                            <select id="storeId" name="product_store_id" class="form-control">
                                <option value="">{{ __('main.all') }}</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoryId">{{ __('main.category') }}</label>
                            <select id="categoryId" name="category_id" class="form-control">
                                <option value="">{{ __('main.all') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == request('category_id')) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brandId">{{ __('main.brand') }}</label>
                            <select id="brandId" name="brand_id" class="form-control">
                                <option value="">{{ __('main.all') }}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @if ($brand->id == request('brand_id')) selected @endif>
                                        {{ $brand->name }}</option>
                                @endforeach
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
                        <h4 class="card-title mg-b-0">{{ __('main.products') }}</h4>
                        <div class="d-flex">
                            <a href="#" class="btn btn-danger mx-1 d-none" id="deleteSelectionBtn"
                                data-toggle="modal" data-effect="effect-flip-vertical" data-target="#deletemodal"
                                data-url="{{ route('booth.products.delete') }}">{{ __('main.delete') }}</a>
                            <input type="text" id="searchInput" data-url="{{ route('booth.products.search') }}"
                                class="form-control" placeholder="{{ __('main.search') }}">
                            <div class="custom-select-wrapper mx-1">
                                <select id="showPerPage" class="custom-select"
                                    data-url="{{ route('booth.products.index') }}" onchange="updatePageSize()">
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
                        @include('booth.products.table')
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

    @include('booth.products._dynamic_selector')
@endsection
