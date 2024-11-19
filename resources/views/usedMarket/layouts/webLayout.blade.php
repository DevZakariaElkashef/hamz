<?php use Illuminate\Support\Facades\URL;

$url = URL::current();
?>
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required meta tags -->
    <link rel="icon" href="{{ URL::asset('Web/assets/images/logo.jpg') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/aos.css') }}" />

    <!-- for english version please change bootstrap to en bootstrap {{ asset('Web/css/bootstrap.min.css') }} -->
    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/bootstrap.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/animate.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css') }}" />

    <link rel="stylesheet" href="{{ asset('Webcss/Web/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('Web/CSS/style.css') }}">

    <title>الرئيسية</title>

</head>

<body>


    <nav class="navbar sticky-top navbar-expand-lg navbar-light ">
        <div class="container-fluid">
            <a class="navbar-brand bg-white rounded p-2" href="/">
                <img src="{{ asset('Web/assets/images/logo.jpg') }}" alt="Logo Image" class="navbar-logo ">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li><a class="dropdown-item" href="/">الرئيسية</a></li>
                    <li><a class="dropdown-item" href="#aboutUs">من نحن</a></li>
                    <li><a class="dropdown-item" href="#services"> الخدمات</a></li>
                    <li><a class="dropdown-item" href="#catalog"> الباقات</a></li>
                    <li><a class="dropdown-item" href="#contact"> تواصل معنا</a></li>
                    <li><a class="dropdown-item" href="#feedback"> أراء العملاء</a></li>

                </ul>
                <div class="me-2">
                    <a href="loginAndRegister.html" class="login-button"><i class="fa-solid fa-user px-2"></i>تسجيل
                        الدخول</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('main')
    <footer>
        <div class="container py-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="p-2 d-flex flex-column justify-content-center align-items-center">
                        <img src="{{ asset('Web/assets/images/logo.jpg') }}" alt="" class="w-75">


                        <div class="d-flex justify-content-around">

                            <span class="social-icons m-2">
                                <a target="_blank" href="" data-tooltip="Facebook" tabindex="-1">
                                    <svg class="svg-inline--fa fa-facebook-f text-white fs-5" aria-hidden="true"
                                        focusable="false" data-prefix="fab" data-icon="facebook-f" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                        </path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="p-2 mt-2">
                        <h3 class="mb-3">روابط سريعة</h3>
                        <div class="quick-links-line bg-primary w-25 "></div>
                        <ul class="links-list p-0">
                            <li><a href="">الرئيسية</a></li>
                            <li><a href="">من نحن</a></li>
                            <li><a href="">تواصل معانا</a></li>
                            <li><a href="">الاسئلة الشائعة</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="p-2 mt-2 ">
                        <h3 class="mb-3">اعرف اكثر</h3>
                        <div class="quick-links-line bg-primary w-25 "></div>
                        <ul class="links-list p-0">
                            <li><a href="">سياسة الخصوصية</a></li>
                            <li><a href="">الشروط و الاحكام</a></li>
                            <li><a href="">تسجيل الحساب</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="p-2 mt-2">
                        <h3 class="mb-3">بيانات التواصل</h3>
                        <div class="quick-links-line bg-primary w-25 "></div>
                        <ul class="links-list p-0">
                            <li><i class="fa-solid fa-phone-flip px-2"></i><span>099567474775</span></li>
                            <li><i class="fa-regular fa-envelope px-2"></i><span>test@test.com</span></li>
                            <li><i class="fa-regular fa-clock px-2"></i> الأحد : الخميس (٨ صباحا : ٥ مساء)</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        integrity="sha512-2bMhOkE/ACz21dJT8zBOMgMecNxx0d37NND803ExktKiKdSzdwn+L7i9fdccw/3V06gM/DBWKbYmQvKMdAA9Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>
