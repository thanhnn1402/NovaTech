<?php 
    require('./admin/config/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/favicon-32x32.png">
    <title>NovaTech</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style-news.css">
  </head>
</head>
<body>
    <div class="wrapper">
        <!-- Start header -->
        <?php
            require('./partials/header.php')
        ?>
        <!-- End header -->

        <!-- Start main content -->
        <div class="news-content">
            <div class="container-lg container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tin tức</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="news-slider">
                            <div class="news-slider__item">
                                <img src="https://cdn.sforum.vn/sforum/wp-content/uploads/2023/04/honkai-star-rail-vs-genshin-impact-1.jpg" alt="" class="img-fluid">
                                <p class="news-slider__item-desc">Honkai Star Rail là trò chơi khiến game thủ Genshin Impact phải thèm thuồng</p>
                            </div>
                            <div class="news-slider__item">
                                <img src="https://cdn.sforum.vn/sforum/wp-content/uploads/2023/04/honkai-star-rail-vs-genshin-impact-1.jpg" alt="" class="img-fluid">
                                <p class="news-slider__item-desc">Honkai Star Rail là trò chơi khiến game thủ Genshin Impact phải thèm thuồng</p>
                            </div>
                            <div class="news-slider__item">
                                <img src="https://cdn.sforum.vn/sforum/wp-content/uploads/2023/04/honkai-star-rail-vs-genshin-impact-1.jpg" alt="" class="img-fluid">
                                <p class="news-slider__item-desc">Honkai Star Rail là trò chơi khiến game thủ Genshin Impact phải thèm thuồng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-categories">
                            <h6 class="news-categories__title">DANH MỤC TIN TỨC</h6>
                            <ul class="news-categories__list">
                                <li class="news-categories__item">
                                    <a href="" class="news-categories__link"> <i class="fa-solid fa-house news-categories__icon"></i> Trang chủ</a>
                                </li>
                                <li class="news-categories__item">
                                    <a href="" class="news-categories__link"> <i class="fa-solid fa-newspaper news-categories__icon"></i> Tin công nghệ</a>
                                </li>
                                <li class="news-categories__item">
                                    <a href="" class="news-categories__link"> <i class="fa-solid fa-earth-americas news-categories__icon"></i> Khám phá</a>
                                </li>
                                <li class="news-categories__item">
                                    <a href="" class="news-categories__link"> <i class="fa-solid fa-gamepad news-categories__icon"></i> Game</a>
                                </li>
                                <li class="news-categories__item">
                                    <a href="" class="news-categories__link"> <i class="fa-regular fa-lightbulb news-categories__icon"></i> Thủ thuật</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="news-item">
                                    <a href="" class="w-100 d-inline-block">
                                        <img src="https://phongvu.vn/cong-nghe/wp-content/uploads/2023/04/H3-300x300.png" alt="" class="news-item__thumbnail">
                                    </a>
                                    <div class="news-item__body">
                                        <a href="" class="news-item__btn">Tin tức</a>
                                        <a href="" class="news-item__name">Lễ ký kết độc quyền giữa “thần rừng” SofM và Phong Vũ</a>
                                        <p class="news-item__time">29 Tháng tư 2023</p>
                                        <p class="news-item__desc">Trong ngày 26/04/2023, tuyển thủ Sofm và Phong Vũ sẽ chính thức ký kết độc quyền sản phẩm, bao gồm bộ sưu tập áo thun và lót chuột thiết kế riêng mang dấu ấn gaming của Sofm dành cho fan LMHT. Cùng với đó, sự kiện còn có sự giao lưu, thách đấu của Sofm cùng các fan hâm mộ tại Gaming Zone của Phong Vũ 264 Nguyễn Thị Minh Khai, Quận 3, Tp. Hồ Chí Minh.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="news-item">
                                    <a href="" class="w-100 d-inline-block">
                                        <img src="https://phongvu.vn/cong-nghe/wp-content/uploads/2023/04/H3-300x300.png" alt="" class="news-item__thumbnail">
                                    </a>
                                    <div class="news-item__body">
                                        <a href="" class="news-item__btn">Tin tức</a>
                                        <a href="" class="news-item__name">Lễ ký kết độc quyền giữa “thần rừng” SofM và Phong Vũ</a>
                                        <p class="news-item__time">29 Tháng tư 2023</p>
                                        <p class="news-item__desc">Trong ngày 26/04/2023, tuyển thủ Sofm và Phong Vũ sẽ chính thức ký kết độc quyền sản phẩm, bao gồm bộ sưu tập áo thun và lót chuột thiết kế riêng mang dấu ấn gaming của Sofm dành cho fan LMHT. Cùng với đó, sự kiện còn có sự giao lưu, thách đấu của Sofm cùng các fan hâm mộ tại Gaming Zone của Phong Vũ 264 Nguyễn Thị Minh Khai, Quận 3, Tp. Hồ Chí Minh.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="news-item">
                                    <a href="" class="w-100 d-inline-block">
                                        <img src="https://phongvu.vn/cong-nghe/wp-content/uploads/2023/04/H3-300x300.png" alt="" class="news-item__thumbnail">
                                    </a>
                                    <div class="news-item__body">
                                        <a href="" class="news-item__btn">Tin tức</a>
                                        <a href="" class="news-item__name">Lễ ký kết độc quyền giữa “thần rừng” SofM và Phong Vũ</a>
                                        <p class="news-item__time">29 Tháng tư 2023</p>
                                        <p class="news-item__desc">Trong ngày 26/04/2023, tuyển thủ Sofm và Phong Vũ sẽ chính thức ký kết độc quyền sản phẩm, bao gồm bộ sưu tập áo thun và lót chuột thiết kế riêng mang dấu ấn gaming của Sofm dành cho fan LMHT. Cùng với đó, sự kiện còn có sự giao lưu, thách đấu của Sofm cùng các fan hâm mộ tại Gaming Zone của Phong Vũ 264 Nguyễn Thị Minh Khai, Quận 3, Tp. Hồ Chí Minh.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="news-item">
                                    <a href="" class="w-100 d-inline-block">
                                        <img src="https://phongvu.vn/cong-nghe/wp-content/uploads/2023/04/H3-300x300.png" alt="" class="news-item__thumbnail">
                                    </a>
                                    <div class="news-item__body">
                                        <a href="" class="news-item__btn">Tin tức</a>
                                        <a href="" class="news-item__name">Lễ ký kết độc quyền giữa “thần rừng” SofM và Phong Vũ</a>
                                        <p class="news-item__time">29 Tháng tư 2023</p>
                                        <p class="news-item__desc">Trong ngày 26/04/2023, tuyển thủ Sofm và Phong Vũ sẽ chính thức ký kết độc quyền sản phẩm, bao gồm bộ sưu tập áo thun và lót chuột thiết kế riêng mang dấu ấn gaming của Sofm dành cho fan LMHT. Cùng với đó, sự kiện còn có sự giao lưu, thách đấu của Sofm cùng các fan hâm mộ tại Gaming Zone của Phong Vũ 264 Nguyễn Thị Minh Khai, Quận 3, Tp. Hồ Chí Minh.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="news-item">
                                    <a href="" class="w-100 d-inline-block">
                                        <img src="https://phongvu.vn/cong-nghe/wp-content/uploads/2023/04/H3-300x300.png" alt="" class="news-item__thumbnail">
                                    </a>
                                    <div class="news-item__body">
                                        <a href="" class="news-item__btn">Tin tức</a>
                                        <a href="" class="news-item__name">Lễ ký kết độc quyền giữa “thần rừng” SofM và Phong Vũ</a>
                                        <p class="news-item__time">29 Tháng tư 2023</p>
                                        <p class="news-item__desc">Trong ngày 26/04/2023, tuyển thủ Sofm và Phong Vũ sẽ chính thức ký kết độc quyền sản phẩm, bao gồm bộ sưu tập áo thun và lót chuột thiết kế riêng mang dấu ấn gaming của Sofm dành cho fan LMHT. Cùng với đó, sự kiện còn có sự giao lưu, thách đấu của Sofm cùng các fan hâm mộ tại Gaming Zone của Phong Vũ 264 Nguyễn Thị Minh Khai, Quận 3, Tp. Hồ Chí Minh.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 ">
                                <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation example">
                                    <ul class="pagination">
                                      <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                                      <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End main content -->

        <!-- Start footer -->
        <?php
            require('./partials/footer.php')
        ?>
        <!-- End footer -->
    </div> 

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <!-- Bootstrap Bundle JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script>
        $('.news-slider').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplaySpeed: 3000,
            prevArrow: '<button type="button" class="news-slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="news-slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
        });

    </script>
</body>
</html>