<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('home_assets/css/bootstrap-ar.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('home_assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home_assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home_assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('home_assets/css/style.css') }}">
    <title>Hamz</title>
</head>

<body>

    <div class="header_wrapper" style='background-image: url("{{ asset('home_assets/images/header_bg.png') }}")'>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-8">
                    <div class="header_img">
                        <img src="{{ asset('home_assets/images/header_img.png') }}" alt="Header">

                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="header_conte">
                        <h5>تطبيق hamz</h5>
                        <p>
                            سوق شامل لتوفير المنتجات والخدمات المتميزة والفرص التفاعلية
                        </p>
                        <a href=""><img src="{{ asset('home_assets/images/apple.png') }}" alt="apple"></a>
                        <a href=""><img src="{{ asset('home_assets/images/gooel.png') }}" alt="google"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="about_content" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="thcontent">
                        <div class="about_chicken">
                            <img src="{{ asset('home_assets/images/car.png') }}" alt="">
                        </div>
                        <h5>عن التطبيق</h5>
                        <p>
                            هذا التطبيق هو منصة تسوق متكاملة تجمع بين المنتجات المتنوعة، العروض الحصرية، والفرص
                            التفاعلية، مما يوفر
                            للمستخدمين تجربة فريدة تجمع بين التسوق والترفيه. يتكون التطبيق من ستة عناصر رئيسية مصممة
                            لتلبية احتياجات
                            المستخدمين المختلفة
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 text-left">
                    <div class="about_img">
                        <img src="{{ asset('home_assets/images/about-img.png') }}" alt="About Us">
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="features_section" style='background-image: url("{{ asset('home_assets/images/features_bg.png') }}")'>
        <div class="container">
            <div class="section_header">
                <h5>مميزات تطبيق المنقذ الشامل </h5>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="list">
                        <ul class="list-unstyled">
                            <li>
                                <div class="card_body">
                                    <h5>سهولة الاستخدام</h5>
                                    <p>
                                        واجهة بسيطة وسلسة تتيح لك طلب الخدمة خلال دقائق.
                                    </p>
                                </div>
                                <div class="card_icon">
                                    <img src="{{ asset('home_assets/images/icon1.svg') }}" alt="">
                                </div>
                            </li>

                            <li class="middle">
                                <div class="card_body">
                                    <h5>أمان وضمان</h5>
                                    <p>
                                        جميع الفنيين موثوقون ومدققون لضمان جودة العمل.
                                    </p>
                                </div>
                                <div class="card_icon">
                                    <img src="{{ asset('home_assets/images/icon2.svg') }}" alt="">
                                </div>
                            </li>

                            <li>
                                <div class="card_body">
                                    <h5>عروض أسعار تنافسية</h5>
                                    <p>
                                        احصل على عدة عروض من الفنيين واختر الأنسب لك.
                                    </p>
                                </div>
                                <div class="card_icon">
                                    <img src="{{ asset('home_assets/images/icon3.svg') }}" alt="">

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-6">
                    <div class="features_img">
                        <img src="{{ asset('home_assets/images/features_img.png') }}" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="list list_opsite">
                        <ul class="list-unstyled">
                            <li>
                                <div class="card_icon">
                                    <img src="{{ asset('home_assets/images/icon4.svg') }}" alt="">
                                </div>
                                <div class="card_body">
                                    <h5> خدمات شاملة</h5>
                                    <p>
                                        يغطي التطبيق جميع احتياجات الصيانة المنزلية والسيارات.
                                    </p>
                                </div>
                            </li>

                            <li class="middle">
                                <div class="card_icon">
                                    <img src="{{ asset('home_assets/images/icon5.svg') }}" alt="">
                                </div>
                                <div class="card_body">
                                    <h5>نظام تقييم شفاف</h5>
                                    <p>
                                        يمكنك الاطلاع على تقييمات العملاء السابقين لاتخاذ قرارك بثقة.
                                    </p>
                                </div>
                            </li>

                            <li>
                                <div class="card_icon">
                                    <img src="{{ asset('home_assets/images/icon6.svg') }}" alt="">
                                </div>
                                <div class="card_body">
                                    <h5>خيارات دفع مرنة</h5>
                                    <p>
                                        إمكانية الدفع الإلكتروني أو الدفع المباشر عند استلام الخدمة.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="screens" data-aos="fade-up">
        <div class="scree_icon">
            <img src="{{ asset('home_assets/images/screen_img.png') }}" alt="">
        </div>
        <div class="container">
            <div class="section-header">
                <h5>شاشات تطبيق hamz</h5>
            </div>
            <div class="wrapper">
                <div class="screens-slider-wrapper">
                    <div class="owl-carousel" dir="ltr">
                        <div class="slider-item">
                            <img src="{{ asset('home_assets/images/05.png') }}" alt="">
                        </div>
                        <div class="slider-item">
                            <img src="{{ asset('home_assets/images/04.png') }}" alt="">
                        </div>
                        <div class="slider-item">
                            <img src="{{ asset('home_assets/images/03.png') }}" alt="">
                        </div>
                        <div class="slider-item">
                            <img src="{{ asset('home_assets/images/02.png') }}" alt="">
                        </div>
                        <div class="slider-item">
                            <img src="{{ asset('home_assets/images/01.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="download_app">
        <div class="container">
            <div class="download_app_wrapper">
                <div class="row">
                    <div class="col-sm-12 xcol-md-6 col-lg-6">
                        <h5>حمل النسخة الأخيرة من التطبيق</h5>
                        <p>يتوفر تطبيق <span>hamz</span> علي جوجل بلاي وآب استور </p>
                        <div class="download_app_btn">
                            <a href=""><img src="{{ asset('home_assets/images/gooel.png') }}" alt="google"></a>
                            <a href=""><img src="{{ asset('home_assets/images/apple.png') }}" alt="apple"></a>
                        </div>
                    </div>
                    <div class="download_app_img">
                        <img src="{{ asset('home_assets//images/download.png') }}" alt="Download">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="live-preview">
    </div>


    <script src="{{ asset('home_assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('home_assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('home_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('home_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('home_assets/js/aos.js') }}"></script>
    <script src="{{ asset('home_assets/js/main.js') }}"></script>
</body>

</html>
