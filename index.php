<?php
require('./admin/config/config.php');

$products_pc = array();
$products_laptop = array();
$products_camera = array();
$banners = array();

$sql_products_pc = "SELECT * FROM san_pham WHERE id_loai_hang = 1";
$sql_products_laptop = "SELECT * FROM san_pham WHERE id_loai_hang = 2";
$sql_products_camera = "SELECT * FROM san_pham WHERE id_loai_hang = 3";
$sql_banners = "SELECT * FROM banners";

$result_products_pc = $conn->query($sql_products_pc);
$result_products_laptop = $conn->query($sql_products_laptop);
$result_products_camera = $conn->query($sql_products_camera);
$result_banners = $conn->query($sql_banners);

if ($result_products_pc->num_rows > 0) {
    while ($row = $result_products_pc->fetch_assoc()) {
        $products_pc[] = $row;
    }
}

if ($result_products_laptop->num_rows > 0) {
    while ($row = $result_products_laptop->fetch_assoc()) {
        $products_laptop[] = $row;
    }
}

if ($result_products_camera->num_rows > 0) {
    while ($row = $result_products_camera->fetch_assoc()) {
        $products_camera[] = $row;
    }
}

if ($result_banners->num_rows > 0) {
    while ($row = $result_banners->fetch_assoc()) {
        $banners[] = $row;
    }
}

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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
</head>

<body>
    <div class="wrapper">
        <!-- Start header -->
        <?php
        require('./partials/header.php')
        ?>
        <!-- End header -->

        <!-- Start banner -->
        <div class="banner">
            <div class="container-fluid-fluid p-0">
                <div class="row m-0">
                    <div class="banner-content p-0">
                        <div class="col-md-12">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="banner-img img-fluid">
                        </div>
                        <div class="col-md-12">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="banner-img img-fluid">
                        </div>
                        <div class="col-md-12">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="banner-img img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End banner -->

        <!-- Start sub banner -->
        <div class="sub-banner my-4">
            <div class="container-lg container-fluid">
                <div class="row">
                    <div class="col-md-3 col-6 mt-3">
                        <div class="sub-banner__item h-100">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="sub-banner__img w-100 h-100 img-fluid rounded-2">
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mt-3">
                        <div class="sub-banner__item h-100">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="sub-banner__img w-100 h-100 img-fluid rounded-2">
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mt-3">
                        <div class="sub-banner__item h-100">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="sub-banner__img w-100 h-100 img-fluid rounded-2">
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mt-3">
                        <div class="sub-banner__item h-100">
                            <img src="./assets/img/banners/banner-1.jpg" alt="" class="sub-banner__img w-100 h-100 img-fluid rounded-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End sub banner -->

        <!-- Start main content -->
        <div class="main-content">

            <!-- Start product featured -->
            <div class="section">
                <div class="section__title section__title--bg-primary">
                    <div class="container-lg container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <h5>SẢN PHẨM NỔI BẬT</h5>
                            </div>
                            <div class="col-6 d-inline-flex align-items-center justify-content-end">
                                <a href="./products.php?category=1" class="section__title-link">Xem tất cả <i class="fa-solid fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section__content">
                    <div class="container-lg container-fluid">
                        <div class="row row-cols-lg-5 row-cols-md-4 row-cols-2 g-2 g-lg-3">
                            <?php foreach ($products_pc as $item) { ?>
                                <div class="col col-6">
                                    <a href="./product-detail.php?id=<?= $item['id'] ?>" class="product-item">
                                        <div class="position-relative" style="padding-bottom: 100%">
                                            <div class="product-item__thumbnail">
                                                <img src="./storage/uploads/img/<?= $item['hinh_anh_dai_dien'] ?>" alt="" class="product-item__thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="product-item__body">
                                            <p class="product-item__name"><?= $item['ten_sp'] ?></p>
                                            <p class="product-item__new-price"><?= currency_format($item['don_gia_khuyen_mai']) ?></p>
                                            <p class="product-item__old-price">
                                                <span><?= currency_format($item['don_gia_ban']) ?></span>
                                                <span><?= $item['phan_tram_khuyen_mai'] ?>%</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End product featured -->

            <!-- Start sub banner -->
            <div class="section">
                <div class="sub-banner my-4">
                    <div class="container-lg container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="sub-banner__item h-100">
                                    <img src="./assets/img/banners/banner-1.jpg" alt="" class="sub-banner__img  w-100  h-100 rounded-2">
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="sub-banner__item h-100">
                                    <img src="./assets/img/banners/banner-1.jpg" alt="" class="sub-banner__img  w-100  h-100 rounded-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End sub banner -->

            <!-- Start product(laptop) -->
            <div class="section">
                <div class="section__title section__title--bg-primary">
                    <div class="container-lg container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <h5>LAPTOP</h5>
                            </div>
                            <div class="col-6 d-inline-flex align-items-center justify-content-end">
                                <a href="./products.php?category=3" class="section__title-link">Xem tất cả <i class="fa-solid fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section__content">
                    <div class="container-lg container-fluid">
                        <div class="row row-cols-lg-5 row-cols-md-4 row-cols-2 g-2 g-lg-3">
                            <?php foreach ($products_laptop as $item) { ?>
                                <div class="col col-6">
                                    <a href="./product-detail.php?id=<?= $item['id'] ?>" class="product-item">
                                        <div class="position-relative" style="padding-bottom: 100%">
                                            <div class="product-item__thumbnail">
                                                <img src="./storage/uploads/img/<?= $item['hinh_anh_dai_dien'] ?>" alt="<?= $item['ten_sp'] ?>" class="product-item__thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="product-item__body">
                                            <p class="product-item__name"><?= $item['ten_sp'] ?></p>
                                            <p class="product-item__new-price"><?= currency_format($item['don_gia_khuyen_mai']) ?></p>
                                            <p class="product-item__old-price">
                                                <span><?= currency_format($item['don_gia_ban']) ?></span>
                                                <span><?= $item['phan_tram_khuyen_mai'] ?>%</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End product(laptop) -->

            <!-- Start product(PC) -->
            <div class="section">
                <div class="section__title section__title--bg-primary">
                    <div class="container-lg container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <h5>CAMERA</h5>
                            </div>
                            <div class="col-6 d-inline-flex align-items-center justify-content-end">
                                <a href="./products.php?category=3" class="section__title-link">Xem tất cả <i class="fa-solid fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section__content">
                    <div class="container-lg container-fluid">
                        <div class="row row-cols-lg-5 row-cols-md-4 row-cols-2 g-2 g-lg-3">
                            <?php foreach ($products_camera as $item) { ?>
                                <div class="col col-6">
                                    <a href="./product-detail.php?id=<?= $item['id'] ?>" class="product-item">
                                        <div class="position-relative" style="padding-bottom: 100%">
                                            <div class="product-item__thumbnail">
                                                <img src="./storage/uploads/img/<?= $item['hinh_anh_dai_dien'] ?>" alt="<?= $item['ten_sp'] ?>" class="product-item__thumbnail-img">
                                            </div>
                                        </div>
                                        <div class="product-item__body">
                                            <p class="product-item__name"><?= $item['ten_sp'] ?></p>
                                            <p class="product-item__new-price"><?= currency_format($item['don_gia_khuyen_mai']) ?></p>
                                            <p class="product-item__old-price">
                                                <span><?= currency_format($item['don_gia_ban']) ?></span>
                                                <span><?= $item['phan_tram_khuyen_mai'] ?>%</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End product(PC) -->
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
        $('.banner-content').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplaySpeed: 3000,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
            dots: true,
            dotClass: 'slick-dots',
            responsive: [{
                breakpoint: 576,
                settings: {
                    arrows: false,
                }
            }, ]
        });
    </script>
</body>

</html>