<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Cards</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('landing-page.css') }}">

</head>

<body>


    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="row justify-content-center align-items-center mt-5">
                <div class="col-md-4 mt-4">
                    <div class="card w-100" style="width: 18rem; height: 27rem;">
                        <img src="https://www.maweidukum.com/wp-content/uploads/2023/12/%D8%B1%D8%A8%D8%AD-%D8%A7%D9%84%D9%85%D8%A7%D9%84-%D9%85%D9%86-%D9%85%D8%B4%D8%A7%D9%87%D8%AF%D8%A9-%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88%D9%87%D8%A7%D8%AA.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">شاهد وإكسب</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of
                                the card's content.</p>
                            <a href="#" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card w-100" style="width: 18rem; height: 27rem;">
                        <img src="https://arabianutopia.com/wp-content/uploads/2024/06/%D8%AE%D8%B7%D9%88%D8%A7%D8%AA-%D9%84%D8%A5%D8%B9%D8%AF%D8%A7%D8%AF-%D9%83%D9%88%D8%A8%D9%88%D9%86%D8%A7%D8%AA-%D8%A7%D9%84%D8%AE%D8%B5%D9%85-%D8%B9%D9%84%D9%89-%D9%85%D8%AA%D8%AC%D8%B1-%D9%88%D9%88%D9%83%D9%88%D9%85%D8%B1%D8%B3-780x470.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">كوبونات الخصم</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of
                                the card's content.</p>
                            <a href="#" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card w-100" style="width: 18rem; height: 27rem;">
                        <img src="https://archgalleries.com/wp-content/uploads/2020/03/%D8%AA%D8%B5%D9%85%D9%8A%D9%85-%D9%88%D8%AA%D9%86%D9%81%D9%8A%D8%B0-%D8%A8%D9%88%D8%AB%D8%A7%D8%AA-%D8%B4%D8%B1%D9%83%D8%A9-%D9%86%D8%B3%D9%85%D8%A7-%D9%88%D8%B4%D8%B1%D9%83%D8%A7%D9%87%D9%85-02.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">بوثات</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of
                                the card's content.</p>
                            <a href="#" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card w-100" style="width: 18rem; height: 27rem;">
                        <img src="https://watanimg.elwatannews.com/image_archive/original_lower_quality/14454940291719314406.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">مول</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of
                                the card's content.</p>
                            <a href="{{ route('mall.home') }}" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card w-100" style="width: 18rem; height: 27rem;">
                        <img src="https://markat-used.com/wp-content/uploads/2021/10/6-2.png" class="card-img-top"
                            alt="...">
                        <div class="card-body">
                            <h5 class="card-title">ماركات مستخدمه</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of
                                the card's content.</p>
                            <a href="#" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card w-100" style="width: 18rem; height: 27rem;">
                        <img src="https://media.istockphoto.com/id/154229260/photo/firm-handshake-on-white-background.jpg?s=612x612&w=0&k=20&c=ULw2Pb7HWLZUiXPkd3pEZHwHT4MGUFlAssE_qtwpqjo="
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">رفوف</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of
                                the card's content.</p>
                            <a href="#" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var animatedMarquee = $('.animated-marquee');

        $(window).resize(function() {
            animatedMarquee.remove();
            $('body').append(animatedMarquee);
        });
    </script>
</body>

</html>
