@extends('booth.layouts.master')
@section('title')
    {{ __('main.create_store') }}
@endsection

@include('booth.stores.style')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">{{ __('main.home') }}</h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('booth.stores.index') }}">{{ __('main.stores') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('booth.stores.create') }}">{{ __('main.create_store') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('booth.stores.index') }}" class="btn btn-secondary ">{{ __('main.back') }}</a>
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
                        <h4 class="card-title mg-b-0">{{ __('main.stores') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('booth.stores.store') }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="name_ar" placeholder="{{ __('main.enter_name') }}"
                                    required="" type="text" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.name') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="name_en" placeholder="{{ __('main.enter_name') }}"
                                    required="" type="text" value="{{ old('name_en') }}">
                                @error('name_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.description') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <textarea class="form-control" name="description_ar" placeholder="{{ __('main.enter_description') }}" required="">{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.description') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <textarea class="form-control" name="description_en" placeholder="{{ __('main.enter_description') }}" required="">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.phone') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="phone" placeholder="{{ __('main.enter_phone') }}"
                                    required="" type="text" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.iban') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="iban" placeholder="{{ __('main.enter_iban') }}"
                                    required="" type="text" value="{{ old('iban') }}">
                                @error('iban')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.sections') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control select2" name="section_id">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"
                                            @if (old('section_id') == $section->id) selected @endif>
                                            {{ $section->name }}</option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.cities') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control select2" name="city_id">
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            @if (old('city_id') == $city->id) selected @endif>
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.sellers') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control select2" name="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if (old('user_id') == $user->id) selected @endif>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.lat') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="lat" placeholder="{{ __('main.enter_lat') }}"
                                    required="" type="text" value="{{ old('lat') }}">
                                @error('lat')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.lng') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="lng" placeholder="{{ __('main.enter_lng') }}"
                                    required="" type="text" value="{{ old('lng') }}">
                                @error('lng')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.address') }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="address" placeholder="{{ __('main.enter_address') }}"
                                    required="" type="text" value="{{ old('address') }}">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.status') }}: <span
                                        class="tx-danger">*</span></label>
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

                            <div class="col-md-6 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="customFile">{{ __('main.image') }}</label>
                                    <input class="custom-file-input" required id="customFile" type="file"
                                        name="image">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            <div class="col-md-12 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label"
                                        for="customFileMulti">{{ __('main.images') }}</label>
                                    <input class="custom-file-input" multiple id="customFileMulti" type="file"
                                        name="images[]" accept="image/*">
                                    @error('images')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="image-preview" class="mt-4 d-flex flex-wrap"></div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="custom-checkbox-toggle">
                                    <input type="checkbox" value="1" id="pick_up" name="pick_up">
                                    <label for="pick_up">{{ __('main.Pick_Up_From_The_Store') }}</label>
                                </div>
                                @error('pick_up')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="custom-checkbox-toggle">
                                    <input type="checkbox" value="1" id="delivery_type" name="delivery_type">
                                    <label for="delivery_type">{{ __(("booth.Store_Has_Delivery")) }}</label>
                                </div>
                                @error('delivery_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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

@include('booth.stores.script')
