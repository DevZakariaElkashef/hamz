<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('main.signup_vendor') }}</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/signup/css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <h2>{{ __('main.signup_vendor') }}</h2>
        <form action="{{ route('signup') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="upload-btn-wrapper">
                <label for="file-upload" class="custom-file-upload">
                </label>
                <input id="file-upload" type="file" name="image" />
            </div>
            <div class="input-box">
                <input type="text" name="name" placeholder="{{ __('main.name') }}" required>
            </div>
            <div class="input-box">
                <input type="text" name="phone" placeholder="{{ __('main.phone') }}" required>
            </div>
            <div class="input-box">
                <input type="text" name="email" placeholder="{{ __('main.email') }}" required>
            </div>
            <div class="input-box">
                <select id="cities" name="city_id">
                    <option value="" disabled selected>{{ __('main.choose_city') }}</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" @if (old('city_id') == $city->id) selected @endif>
                            {{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="{{ __('main.password') }}" required>
            </div>
            <div class="input-box">
                <input type="password" name="password_confirmation" placeholder="{{ __('main.password_confirmation') }}" required>
            </div>
            <div class="policy">
                <input type="checkbox" name="terms" required>
                <h3 style="padding-right: 5px">{{ __('main.accept_terms') }}</h3>
            </div>
            <div class="input-box button">
                <input type="Submit" value="{{ __('main.signup') }}">
            </div>
            <div class="text">
                <h3><a href="{{ route('login') }}">{{ __('main.have_account') }}</a></h3>
            </div>
        </form>
    </div>
</body>

</html>
