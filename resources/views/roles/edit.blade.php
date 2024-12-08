@extends('layouts.master')
@section('title')
    {{ __('main.edit_role') }}
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
                        href="{{ route('roles.index') }}">{{ __('main.roles') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('roles.edit', $role->id) }}">{{ __('main.edit_role') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary ">{{ __('main.back') }}</a>
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
                        <h4 class="card-title mg-b-0">{{ __('main.roles') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('roles.update', $role->id) }}" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }} <span class="tx-danger">*</span></label>
                                <input class="form-control" name="name" placeholder="{{ __('main.enter_name') }}" required="" type="text" value="{{ old('name', $role->name) }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <span>{{ __('main.permissions') }}:</span>

                            @foreach ($groupedPermissions as $group => $subgroups)
                                <div class="col-md-12 mt-3">
                                    <h5 class="mb-2">{{ __('main.' . $group) }}</h5>
                                    <div class="row">
                                        @foreach ($subgroups as $subgroup => $permissionsList)
                                            <div class="col-md-3 mt-3">
                                                <h6 class="">{{ __('main.' . $subgroup) }}</h6>
                                                <div class="form-check">
                                                    @foreach ($permissionsList as $permission)
                                                        <div class="form-check mt-2">
                                                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" @if (in_array($permission->id, $assignedPermissions)) checked @endif>
                                                            <label class="form-check-label mx-4" for="permission_{{ $permission->id }}">
                                                                {{ __('main.' . implode('.', array_slice(explode('.', $permission->name), 1))) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                </div>
                            @endforeach

                            <div class="col-12 mg-t-10 mg-sm-t-25">
                                <button class="btn btn-main-primary pd-x-20" type="submit">{{ __('main.submit') }}</button>
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
