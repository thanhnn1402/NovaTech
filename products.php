<?php
require('./admin/config/config.php');

$products = array();

$category = isset($_GET['category']) ? $_GET['category'] : '';
if(!empty($category)) {
    $_SESSION['category'] = $category;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
if(!empty($search)) {
    $_SESSION['search'] = $search;

    if(!empty($userlogged)) {
        $sql_check = "SELECT * FROM lich_su_tim_kiem WHERE noi_dung = '{$search}'";
        $result = $conn->query($sql_check);

        if($result->num_rows == 0) {
            $sql_insert = "INSERT INTO lich_su_tim_kiem(`id_khach_hang`, `noi_dung`) VALUES (?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("is", $userlogged['id'], $search);

            $stmt->execute();
        }
    }
}

//
$result = $conn->query("SELECT COUNT(id) AS total FROM san_pham")->fetch_assoc();

if(isset($_SESSION['category']) && !empty($category)) {
    $result = $conn->query("SELECT COUNT(id) AS total FROM san_pham WHERE id_loai_hang = '{$category}'")->fetch_assoc();
}

if(isset($_SESSION['search']) && !empty($search)) {
    $result = $conn->query("SELECT COUNT(san_pham.id) AS total FROM san_pham INNER JOIN loai_hang ON san_pham.id_loai_hang = loai_hang.id WHERE ten_sp LIKE '%{$search}%' OR ten_loai LIKE '%{$search}%'")->fetch_assoc();
}


$total_records = $result['total'];

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$limit = 15;

$total_pages = ceil($total_records / $limit);

if ($current_page > $total_pages) {
    $current_page = $total_pages;
} else if ($current_page < 1) {
    $current_page = 1;
}

$start = ($current_page - 1) * $limit;

//
$sql_products = "SELECT * FROM san_pham LIMIT $start, $limit";

if(isset($_SESSION['category']) && !empty($category)) {
    $sql_products = "SELECT * FROM san_pham WHERE id_loai_hang = '{$category}' LIMIT $start, $limit";
}

if(isset($_SESSION['search']) && !empty($search)) {
    $sql_products = "SELECT * FROM san_pham INNER JOIN loai_hang ON san_pham.id_loai_hang = loai_hang.id WHERE ten_sp LIKE '%{$search}%' OR ten_loai LIKE '%{$search}%' LIMIT $start, $limit";
}

$result_products = $conn->query($sql_products);

if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
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

        <!-- Start main content -->
        <div class="main-content">

            <!-- Start product featured -->
            <div class="section">
                <!-- <div class="section__title">
                    <div class="container-lg container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>SẢN PHẨM NỔI BẬT</h5>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="section__content">
                    <div class="container-lg container-fluid">
                        <div class="row">
                            <!-- <div class="col-md-3">
                                <div class="products-content-filter">
                                    <h6 class="products-content-filter__title">DANH MỤC SẢN PHẨM</h6>
                                    <div class="products-content-filter__categories">
                                        <form action="" class="products-content-filter__categories-form">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="category" id="category-all" checked>
                                                <label class="form-check-label" for="category-all">
                                                    Tất cả
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="category" id="category-pc">
                                                <label class="form-check-label" for="category-pc">
                                                    PC - Linh kiện
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="category" id="category-laptop">
                                                <label class="form-check-label" for="category-laptop">
                                                    Laptop
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="category" id="category-camera">
                                                <label class="form-check-label" for="category-camera">
                                                    Camera
                                                </label>
                                            </div>
                                        </form>
                                    </div>

                                    <h6 class="products-content-filter__title">LỌC THEO GIÁ TIỀN</h6>
                                    <div class="products-content-filter__price">
                                        <div class="range-slide">
                                            <div class="slide">
                                                <div class="line" id="line" style="left: 0%; right: 0%;"></div>
                                                <span class="thumb" id="thumbMin" style="left: 0%;"></span>
                                                <span class="thumb" id="thumbMax" style="left: 100%;"></span>
                                            </div>
                                            <input id="rangeMin" type="range" max="42000000" min="300000" step="100000" value="300000">
                                            <input id="rangeMax" type="range" max="42000000" min="300000" step="100000" value="42000000">
                                        </div>
                                        <div class="display">
                                            <span id="min">300.000 ₫</span>
                                            <span id="max">42.000.000 ₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="products-main-content">
                                    <div class="products-main-content__header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <nav aria-label="breadcrumb">
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                                                        <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                                                    </ol>
                                                </nav>
                                            </div>
                                            <div class="offset-md-3 col-md-3">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Mới nhất</option>
                                                    <option value="1">Thứ tự theo mức độ phổ biến</option>
                                                    <option value="2">Thứ tự theo mức độ đánh giá</option>
                                                    <option value="3">Thứ tự theo giá: thấp đến cao</option>
                                                    <option value="4">Thứ tự theo giá: cao đến thấp</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products-main-content__body">
                                        <div class="row row-cols-lg-5 row-cols-md-4 row-cols-2 g-2 g-lg-3">
                                            <?php foreach ($products as $item) { ?>
                                                <div class="col mt-3">
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

                                        <div class="row mt-4">
                                            <div class="col-md-12 ">
                                                <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation example">
                                                    <ul class="pagination">
                                                        <?php if ($current_page > 1 && $total_pages > 1) { ?>
                                                            <li class="page-item">
                                                                <a class="page-link" href="./products.php?page=<?= $current_page - 1 ?>">
                                                                    <i class="fa-solid fa-chevron-left"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php
                                                        for ($i = 1; $i <= $total_pages; $i++) {
                                                            if ($i == $current_page) {
                                                                echo '<li class="page-item active"><a class="page-link" href="#"> ' . $i . ' </a></li>';
                                                            } else {
                                                                echo '<li class="page-item"><a class="page-link" href="./products.php?page= ' . $i . ' "> ' . $i . ' </a></li>';
                                                            }
                                                        }
                                                        ?>

                                                        <?php if ($current_page < $total_pages && $total_pages > 1) { ?>
                                                            <li class="page-item">
                                                                <a class="page-link" href="./products.php?page=<?= $current_page + 1 ?>">
                                                                    <i class="fa-solid fa-chevron-right"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>

                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End product featured -->

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
            dotClass: 'slick-dots'
        });
    </script>

    <script>
        let min = 300000;
        let max = 42000000;

        const calcLeftPosition = value => 100 / (42000000 - 300000) * (value - 300000);

        $('#rangeMin').on('input', function(e) {
            const newValue = parseInt(e.target.value);
            if (newValue > max) return;
            min = newValue;
            $('#thumbMin').css('left', calcLeftPosition(newValue) + '%');
            $('#min').php(VND.format(newValue));
            $('#line').css({
                'left': calcLeftPosition(newValue) + '%',
                'right': (100 - calcLeftPosition(max)) + '%'
            });
        });

        $('#rangeMax').on('input', function(e) {
            const newValue = parseInt(e.target.value);
            if (newValue < min) return;
            max = newValue;
            $('#thumbMax').css('left', calcLeftPosition(newValue) + '%');
            $('#max').php(VND.format(newValue));
            $('#line').css({
                'left': calcLeftPosition(min) + '%',
                'right': (100 - calcLeftPosition(newValue)) + '%'
            });
        });
    </script>
</body>

</html>