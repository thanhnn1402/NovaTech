<?php
require('./admin/config/config.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$product = array();
$product_detail = array();
$related_products = array();

if (!empty($id)) {
    // Sản phẩm
    $stmt_get_product = $conn->prepare("SELECT san_pham.id, ten_sp, don_gia_ban, phan_tram_khuyen_mai, don_gia_khuyen_mai, mo_ta, hinh_anh, san_pham.id_loai_hang, loai_hang.ten_loai FROM san_pham, loai_hang WHERE san_pham.id_loai_hang = loai_hang.id AND san_pham.id = ?");
    $stmt_get_product->bind_param("s", $id);
    $stmt_get_product->execute();
    $result_get_product = $stmt_get_product->get_result();
    $product = $result_get_product->fetch_assoc();

    $array_img = explode('||', $product['hinh_anh']);
    array_shift($array_img);


    // THông số kỹ thuật
    $sql = '';
    for ($i = 1; $i <= 15; $i++) {
        $sql .= 'chi_tiet_' . $i . ',';
    }

    $sql = trim($sql, ',');
    $stmt_get_product_detail = $conn->prepare("SELECT " . $sql . " FROM chi_tiet_san_pham WHERE id_san_pham = ?");
    $stmt_get_product_detail->bind_param("s", $id);
    $stmt_get_product_detail->execute();
    $result_get_product_detail = $stmt_get_product_detail->get_result();
    $product_detail = $result_get_product_detail->fetch_assoc();

    // Sản phẩm liên quan
    $stmt_get_related_products = $conn->prepare("SELECT id, ten_sp, don_gia_ban, don_gia_khuyen_mai, phan_tram_khuyen_mai, hinh_anh_dai_dien  FROM san_pham WHERE san_pham.id_loai_hang = ? AND id NOT IN (?) ");
    $stmt_get_related_products->bind_param("ii", $product['id_loai_hang'], $id);
    $stmt_get_related_products->execute();
    $result_get_related_products = $stmt_get_related_products->get_result();
    if ($result_get_related_products->num_rows > 0) {
        while ($row = $result_get_related_products->fetch_assoc()) {
            $related_products[] = $row;
        }
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
    <title>TIN HỌC NHƯ Ý</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" />

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style-product-detail.css">
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
            <div class="section">
                <div class="container-lg container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                                    <li class="breadcrumb-item"><a href="#"><?= $product['ten_loai'] ?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $product['ten_sp'] ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="product-detail__slider">
                                <?php foreach ($array_img as $img) { ?>
                                    <img src="./storage/uploads/img/<?= $img ?>" alt="">
                                <?php } ?>
                            </div>
                            <div class="product-detail__slider-nav">
                                <div class="row m-0" id="nav-slider">
                                    <?php foreach ($array_img as $img) { ?>
                                        <div class="col-md-3">
                                            <img src="./storage/uploads/img/<?= $img ?>" alt="" class="img-fluid">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="product-detail__info">

                                <h6 class="product-detail__name"><?= $product['ten_sp'] ?></h6>
                                <p class="product-detail__number-star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <span>5 đánh giá</span>
                                </p>
                                <p class="product-detail__old-price"><span><?= currency_format($product['don_gia_ban']) ?></span> <span>-<?= $product['phan_tram_khuyen_mai']?>%</span></p>
                                <h6 class="product-detail__new-price"><?= currency_format($product['don_gia_khuyen_mai']) ?></h6>

                                <div class="product-detail__btns">
                                    <a href="cart_insert.php?id=<?= $product['id'] ?>&muangay=true" class="btn btn-primary product-detail__btn" data-id="<?= $product['id'] ?>">
                                        MUA NGAY
                                    </a>
                                    <button type="button" class="btn btn-outline-primary btn-add-cart product-detail__btn" data-id="<?= $product['id'] ?>">
                                        THÊM VÀO GIỎ HÀNG
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail__body">
                        <div class="col-md-7">

                            <div class="product-detail__content short">
                                <h4 class="product-detail__content-title">
                                    Thông tin sản phẩm
                                </h4>
                                <div class="product-detail__desc">

                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button class="btn-see-more btn btn-outline-primary">Xem thêm</button>
                            </div>

                            <div class="product-detail__review">
                                <h6 class="product-detail__review-title">
                                    Đánh giá <?= $product['ten_sp'] ?>
                                </h6>
                                <div class="product-detail__review-box">
                                    <div class="product-detail__review-box-left">
                                        <h1>4.8</h1>
                                        <p class="product-detail__number-star mb-0">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        </p>
                                        <span>5 đánh giá</span>
                                    </div>

                                    <div class="product-detail__review-box-right">
                                        <div class="product-detail__review-box-right-group">
                                            <span>5 &#9733;</span>
                                            <div class="progress">
                                                <span class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></span>
                                            </div>
                                            <span>80%</span>
                                        </div>

                                        <div class="product-detail__review-box-right-group">
                                            <span>4 &#9733;</span>
                                            <div class="progress">
                                                <span class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></span>
                                            </div>
                                            <span>20%</span>
                                        </div>

                                        <div class="product-detail__review-box-right-group">
                                            <span>3 &#9733;</span>
                                            <div class="progress">
                                                <span class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></span>
                                            </div>
                                            <span>0%</span>
                                        </div>

                                        <div class="product-detail__review-box-right-group">
                                            <span>2 &#9733;</span>
                                            <div class="progress">
                                                <span class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></span>
                                            </div>
                                            <span>0%</span>
                                        </div>

                                        <div class="product-detail__review-box-right-group">
                                            <span>1 &#9733;</span>
                                            <div class="progress">
                                                <span class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></span>
                                            </div>
                                            <span>0%</span>
                                        </div>
                                    </div>
                                </div>

                                <form action="" class="product-detail__review-form">
                                    <div class="form-group">
                                        <input type="text" placeholder="Họ và tên (bắt buộc)">
                                        <input type="text" placeholder="Số điện thoại (bắt buộc)">
                                    </div>
                                    <section id="rate" class="product-detail__review-form-rating">
                                        <!-- FIFTH STAR -->
                                        <input type="radio" id="star_5" name="rate" value="5" />
                                        <label for="star_5" title="Five">&#9733;</label>
                                        <!-- FOURTH STAR -->
                                        <input type="radio" id="star_4" name="rate" value="4" />
                                        <label for="star_4" title="Four">&#9733;</label>
                                        <!-- THIRD STAR -->
                                        <input type="radio" id="star_3" name="rate" value="3" />
                                        <label for="star_3" title="Three">&#9733;</label>
                                        <!-- SECOND STAR -->
                                        <input type="radio" id="star_2" name="rate" value="2" />
                                        <label for="star_2" title="Two">&#9733;</label>
                                        <!-- FIRST STAR -->
                                        <input type="radio" id="star_1" name="rate" value="1" />
                                        <label for="star_1" title="One">&#9733;</label>
                                    </section>

                                    <textarea rows="5" class="w-100" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>

                                    <div class="text-end">
                                        <button type="submit">Gửi</button>
                                    </div>
                                </form>

                                <ul class="product-detail__review-list-comment">
                                    <li class="product-detail__review-list-comment-item js-li-comment">
                                        <h6>Thương</h6>
                                        <p class="product-detail__number-star">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                        </p>
                                        <p>Sản phẩm tốt</p>
                                        <div>
                                            <button>
                                                <i class="fa-regular fa-thumbs-up"></i>
                                                Thích
                                            </button>
                                            <button class="btn-rep-comment">
                                                <i class="fa-regular fa-comments"></i>
                                                Trả lời
                                            </button>
                                            <span class="mx-2"> | </span>
                                            <span> 1 ngày trước </span>
                                        </div>

                                        <form action="" class="form-rep-comment">
                                            <input type="text" placeholder="Nhập bình luận...">
                                            <button type="submit">Gửi</button>
                                        </form>
                                    </li>

                                    <li class="product-detail__review-list-comment-item js-li-comment">
                                        <h6>Thương</h6>
                                        <p class="product-detail__number-star">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                        </p>
                                        <p>Sản phẩm tốt</p>
                                        <div>
                                            <button>
                                                <i class="fa-regular fa-thumbs-up"></i>
                                                Thích
                                            </button>
                                            <button class="btn-rep-comment">
                                                <i class="fa-regular fa-comments"></i>
                                                Trả lời
                                            </button>
                                            <span class="mx-2"> | </span>
                                            <span> 1 ngày trước </span>
                                        </div>

                                        <ul class="product-detail__review-list-sub-comment">
                                            <li class="product-detail__review-list-comment-item">
                                                <h6>Thương</h6>
                                                <p class="product-detail__number-star">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </p>
                                                <p>Sản phẩm tốt</p>
                                                <div>
                                                    <button>
                                                        <i class="fa-regular fa-thumbs-up"></i>
                                                        Thích
                                                    </button>
                                                    <button class="btn-rep-comment">
                                                        <i class="fa-regular fa-comments"></i>
                                                        Trả lời
                                                    </button>
                                                    <span class="mx-2"> | </span>
                                                    <span> 1 ngày trước </span>
                                                </div>
                                            </li>
                                        </ul>

                                        <form action="" class="form-rep-comment">
                                            <input type="text" placeholder="Nhập bình luận...">
                                            <button type="submit">Gửi</button>
                                        </form>
                                    </li>

                                    <li class="product-detail__review-list-comment-item js-li-comment">
                                        <h6>Thương</h6>
                                        <p class="product-detail__number-star">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                        </p>
                                        <p>Sản phẩm tốt</p>
                                        <div>
                                            <button>
                                                <i class="fa-regular fa-thumbs-up"></i>
                                                Thích
                                            </button>
                                            <button class="btn-rep-comment">
                                                <i class="fa-regular fa-comments"></i>
                                                Trả lời
                                            </button>
                                            <span class="mx-2"> | </span>
                                            <span> 1 ngày trước </span>
                                        </div>

                                        <form action="" class="form-rep-comment">
                                            <input type="text" placeholder="Nhập bình luận...">
                                            <button type="submit">Gửi</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="product-detail__specifications">
                                <h5>Thông số kỹ thuật</h5>
                                <table class="table table-striped table-borderless">
                                    <tbody>
                                        <?php foreach ($product_detail as $item) { ?>
                                            <?php if (!empty($item)) {
                                                $item = explode(':', $item); ?>
                                                <tr>
                                                    <td class="w-50"><?= $item[0] ?>:</td>
                                                    <td><?= $item[1] ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Start related product -->
                    <div class="related-product">
                        <h5 class="related-product__title my-4">
                            SẢN PHẨM LIÊN QUAN
                        </h5>
                        <div class="row related-product__slider">
                            <?php foreach ($related_products as $item) { ?>
                                <div class="col-md-3">
                                    <a href="./product-detail.php?id=<?= $item['id'] ?>" class="product-item mx-2">
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
                                                <span><?=$item['phan_tram_khuyen_mai']?>%</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- End related product -->
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

    <div id="quill" class="d-none"></div>
    <div id="toast-container"></div>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <!-- Bootstrap Bundle JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-delta-to-html"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script>
        $('.product-detail__slider').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplaySpeed: 3000,
            prevArrow: '<button type="button" class="product-detail__slider-slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="product-detail__slider-slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
            asNavFor: '#nav-slider'
        });

        $('#nav-slider').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplaySpeed: 3000,
            focusOnSelect: true,
            arrows: false,
            asNavFor: '.product-detail__slider'
        });



        $('.related-product__slider').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplaySpeed: 3000,
            prevArrow: '<button type="button" class="related-product__slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="related-product__slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
        });
    </script>

    <script>
        function getParent(element, selector) {
            while (element.parentElement) {
                if (element.parentElement.matches(selector)) {
                    return element.parentElement
                } else {
                    element = element.parentElement;
                }
            }
        }

        const btnRepComment = $('.btn-rep-comment');
        $(btnRepComment).on('click', function() {
            const parent = getParent(this, '.js-li-comment');
            console.log(parent);
            $(parent).find('.form-rep-comment').css('display', 'flex')
        })
    </script>

    <script>
        const deltas = <?php echo isset($product['mo_ta']) ? $product['mo_ta'] : ''; ?>;

        var quill = new Quill("#quill", {
            readOnly: true
        });

        quill.setContents(deltas);

        document.querySelector('.product-detail__desc').innerHTML = quill.root.innerHTML;
    </script>

    <script>

        $(document).ready(function() {
            $('.btn-add-cart').click(function(e) {
                const id = $(this).attr('data-id');

                $.ajax({
                    url: 'cart_insert.php',
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        id: id,
                        add_cart: true,
                    },
                }).done(function(response) {
                    if (response.redirect) {
                        window.location.href = 'login.php';
                    } else {
                        toast({
                            message: response.message,
                            type: response.type,
                            duration: 3000
                        });

                        //
                        renderCartHeader(response.cart_products);
                    }

                })
            });


            $('.btn-see-more').click(function(e) {
                if($('.product-detail__content').hasClass('short')) {
                    $(this).text('Thu gọn');
                    $('.product-detail__content').removeClass('short');
                } else {
                    $('.product-detail__content').addClass('short');
                    $(this).text('Xem thêm');
                }
            })

        })
    </script>
</body>

</html>