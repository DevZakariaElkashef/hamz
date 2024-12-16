<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">{{ __('main.vendor_registration') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('vendors.store') }}" data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('main.name') }} <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" placeholder="{{ __('main.enter_name') }}" required
                                        type="text" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('main.email') }}</label>
                                    <input class="form-control" name="email" placeholder="{{ __('main.enter_email') }}" type="email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('main.phone') }} <span class="text-danger">*</span></label>
                                    <input class="form-control" name="phone" placeholder="{{ __('main.enter_phone') }}" type="number"
                                        required value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('main.password') }} <span class="text-danger">*</span></label>
                                    <input class="form-control" name="password" placeholder="{{ __('main.enter_password') }}" type="password"
                                        required value="{{ old('password') }}">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('main.city') }} <span class="text-danger">*</span></label>
                                    <select required class="form-control" name="city_id">
                                        <option value="">{{ __('main.select_city') }}</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if (old('city_id') == $city->id) selected @endif>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('main.status') }} <span class="text-danger">*</span></label>
                                    <select required class="form-control" name="is_active">
                                        <option value="0" @if (old('is_active') == 0) selected @endif>{{ __('main.not_active') }}</option>
                                        <option value="1" @if (old('is_active') == 1) selected @endif>{{ __('main.active') }}</option>
                                    </select>
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="col-md-12">
                                    <label class="form-label">{{ __('main.image') }}</label>
                                    <div class="custom-file">
                                        <input class="custom-file-input" id="customFile" type="file" name="image">
                                        <label class="custom-file-label" for="customFile">{{ __('main.choose_file') }}</label>
                                    </div>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 text-center mt-4">
                                    <button class="btn btn-primary px-5" type="submit">{{ __('main.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
