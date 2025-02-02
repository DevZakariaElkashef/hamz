@extends('rfoof.layouts.master')
@section('title')
    مفضلات الاعضاء
@endsection
@section('css')
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .pagination-box {
            display: flex;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            مفضلات الاعضاء
        @endslot
        @slot('title')
            مفضلات الاعضاء
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0">
                        مفضلات الاعضاء
                    </h4>

                </div>
                <div class="card-body table-responsive border-0">
                    @include('layouts.session')
                    @component('components.errors')
                        @slot('id')
                            company_id
                        @endslot
                    @endcomponent
                    <table id="datatable" class="table table-bordered dt-responsive text-nowrap w-100">
                        <thead>
                            <tr style="cursor: pointer;">
                                <th class="fw-bold">#</th>
                                <th class="fw-bold">العضو</th>
                                <th class="fw-bold">الاعلان</th>
                                <th class="fw-bold">التاريخ</th>
                                <th class="fw-bold">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($favourites) == 0)
                                <tr class="align-middle">
                                    <td colspan="9" class="text-center">{{ __('admin.no_data') }}</td>
                                </tr>
                            @endif
                            @foreach ($favourites as $count => $new)
                                <tr data-id="{{ $count + 1 }}">
                                    <td style="width: 80px" class="align-middle">{{ $count + 1 }}</td>
                                    <td class="align-middle">{{ $new->user->name }}</td>
                                    <td class="align-middle">{{ $new->product->name }}</td>
                                    <td class="align-middle">{{ $new->created_at }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex">

                                            <button type="submit"
                                                class="modal-effect btn btn-outline-secondary bg-danger text-dark btn-sm"
                                                title="{{ __('admin.delete') }}" data-effect="effect-newspaper"
                                                data-toggle="modal" href="#myModal{{ $new->id }}">
                                                <i class="fas fa-trash-alt" style="color:white"></i>
                                            </button>


                                        </div>

                                        <div class="modal" id="myModal{{ $new->id }}">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">حذف المفضله</h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل تريد حذف المفضله؟</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form class="d-inline" action="{{ route('rfoof.favourite.delete') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <input type="hidden" name="favouriteId"
                                                                value="{{ $new->id }}" />
                                                            <button type="button" class="btn btn-secondary waves-effect"
                                                                data-dismiss="modal">{{ __('admin.back') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-danger waves-effect waves-light">{{ __('admin.delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12 pagination-box">
                            {{ $favourites->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
