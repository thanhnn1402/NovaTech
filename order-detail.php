<?php
require('./admin/config/config.php');

if (!empty($userlogged)) {

    $madonhang  = isset($_GET['madonhang']) ? $_GET['madonhang'] : '';
    $trangthai = isset($_GET['state']) ? $_GET['state'] : '';


    if (!empty($madonhang)) {

        $order_info = array();
        $products = array();

        $sql_get_order = "SELECT don_hang.ma_don_hang, so_dia_chi.ho_ten, so_dia_chi.so_dien_thoai, so_dia_chi.tinh_tp, so_dia_chi.quan_huyen, so_dia_chi.phuong_xa, so_dia_chi.dia_chi_cu_the, don_hang.ngay_lap, don_hang.hinh_thuc_thanh_toan, don_hang.trang_thai, don_hang.trang_thai_thanh_toan, don_hang.thanh_tien
                          FROM don_hang, so_dia_chi
                          WHERE don_hang.dia_chi_nhan_hang = so_dia_chi.id AND don_hang.ma_don_hang = '{$madonhang}'";

        $order_info = $conn->query($sql_get_order)->fetch_assoc();

        $city = explode("-", $order_info['tinh_tp']);
        $district = explode("-", $order_info['quan_huyen']);
        $ward = explode("-", $order_info['phuong_xa']);


        $sql_get_products = "SELECT san_pham.id, san_pham.ten_sp, san_pham.don_gia_ban, san_pham.don_gia_khuyen_mai, chi_tiet_don_hang.so_luong, san_pham.hinh_anh_dai_dien, san_pham.hinh_anh
                            FROM san_pham, chi_tiet_don_hang
                            WHERE san_pham.id = chi_tiet_don_hang.id_san_pham AND chi_tiet_don_hang.ma_don_hang = '{$madonhang}'";

        $result_products = $conn->query($sql_get_products);

        while($row = $result_products->fetch_assoc()) {
            $products[] = $row;
        }

        if(!empty($trangthai)) {

            if($trangthai == 2) {
                $sql_update_order = "UPDATE don_hang SET trang_thai = '{$trangthai}', trang_thai_thanh_toan = '1' WHERE ma_don_hang = '{$madonhang}'";
            } else {
                $sql_update_order = "UPDATE don_hang SET trang_thai = '{$trangthai}' WHERE ma_don_hang = '{$madonhang}'";
            }

            if($conn->query($sql_update_order)) {
                echo "<script>
                      alert('Thành công!');
                      window.location.href = 'orders.php';
                  </script>";
            } else {
            echo "<script>
                        alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                    </script>";
            }
        }

    }

} else {
    header('location: ./login.php');
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

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style-orders.css">
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
        <div class="order-detail-content">
            <div class="container-lg container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sidebar-menu">
                            <div class="sidebar-menu__header">
                                <img src="./storage/uploads/img/<?= $userlogged['avatar'] ?>" alt="" class="sidebar-menu__header-img">
                                <p class="sidebar-menu__header-name"><?= $userlogged['fullname'] ?></p>
                            </div>

                            <ul class="sidebar-menu__list">
                                <li class="sidebar-menu__item">
                                    <a href="./profile.php" class="sidebar-menu__link">
                                        <i class="fa-regular fa-circle-user sidebar-menu__icon"></i> Thông tin tài khoản
                                    </a>
                                </li>
                                <li class="sidebar-menu__item active">
                                    <a href="./orders.php" class="sidebar-menu__link">
                                        <i class="fa-solid fa-clipboard-list sidebar-menu__icon"></i> Quản lý đơn hàng
                                    </a>
                                </li>
                                <li class="sidebar-menu__item">
                                    <a href="./notify.php" class="sidebar-menu__link">
                                        <i class="fa-regular fa-bell sidebar-menu__icon"></i> Thông báo
                                    </a>
                                </li>
                                <li class="sidebar-menu__item">
                                    <a href="./change-password.php" class="sidebar-menu__link">
                                        <i class="fa-solid fa-gear sidebar-menu__icon"></i> Đổi mật khấu
                                    </a>
                                </li>
                                <li class="sidebar-menu__item">
                                    <a href="./address.php" class="sidebar-menu__link">
                                        <i class="fa-solid fa-map-location-dot sidebar-menu__icon"></i> Địa chỉ
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="py-3">CHI TIẾT ĐƠN HÀNG: <span class="text-primary"><?= $order_info['ma_don_hang'] ?></span></h5>

                            <?php if($order_info['trang_thai'] == 0) { ?>

                                <a href="order-detail.php?madonhang=<?=$madonhang?>&state=3" class="btn btn-outline-danger">Hủy đơn hàng</a>

                            <?php } else if($order_info['trang_thai'] == 1) { ?>

                                    <a href="order-detail.php?madonhang=<?=$madonhang?>&state=2" class="btn btn-success">Đã nhận được hàng</a>

                            <?php }?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">Thông tin khách hàng</h6>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Họ và tên: </span>
                                            <span class="ms-1"><?= $order_info['ho_ten'] ?></span>
                                        </p>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Số điện thoại: </span>
                                            <span class="ms-1"><?= $order_info['so_dien_thoai'] ?></span>
                                        </p>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Địa chỉ: </span>
                                            <span class="ms-1"><?= $order_info['dia_chi_cu_the'] . ', ' . $ward[1] . ', ' . $district[1] . ', ' . $city[1] ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">Thông tin đơn hàng</h6>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Ngày đặt hàng: </span>
                                            <span class="ms-1"><?= $order_info['ngay_lap'] ?></span>
                                        </p>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Hình thức thanh toán: </span>
                                            <span class="ms-1"><?= $order_info['hinh_thuc_thanh_toan'] ?></span>
                                        </p>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Trạng thái thanh toán: </span>
                                            <span class="ms-1 text-success"><?= convert_state_payment($order_info['trang_thai_thanh_toan']) ?></span>
                                        </p>
                                        <p class="card-text mb-1 fs-7">
                                            <span class="fw-bold">Trạng thái đơn hàng: </span>
                                            <span class="ms-1 text-success"><?= convert_state($order_info['trang_thai']) ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <h6 class="card-title">Sản phẩm</h6>
                                        <?php foreach ($products as $item) { ?>
                                            <div class="mt-4 d-flex">
                                                <img src="./storage/uploads/img/<?=$item['hinh_anh_dai_dien']?>" alt="" class="img-thumbnail" style="width: 75px;">
                                                <div class="w-100 ms-3 fs-7">
                                                    <a href="./product-detail.php?id=<?=$item['id']?>" class="text-decoration-none text-default">
                                                        <?=$item['ten_sp']?>
                                                    </a>
                                                    <p class="d-flex align-items-center justify-content-between">
                                                        <span>Số lượng: <?=$item['so_luong']?></span>
                                                        <span class="fw-bold"><?=currency_format($item['don_gia_khuyen_mai'])?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <p class="card-text d-flex align-items-center justify-content-between mb-1 fs-7">
                                            <span>Tạm tính: </span>
                                            <span class="fw-bold"><?=currency_format($order_info['thanh_tien'])?></span>
                                        </p>
                                        <p class="card-text d-flex align-items-center justify-content-between mb-1 fs-7">
                                            <span>Phí vận chuyển: </span>
                                            <span class="fw-bold">0đ</span>
                                        </p>
                                        <p class="card-text d-flex align-items-center justify-content-between mb-1 fs-7">
                                            <span>Giảm giá: </span>
                                            <span class="fw-bold">0đ</span>
                                        </p>
                                        <p class="card-text d-flex align-items-center justify-content-between mb-1 fs-7">
                                            <span>Tổng tiền: </span>
                                            <span class="fs-5 fw-bold text-primary"><?=currency_format($order_info['thanh_tien'])?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <h6 class="card-title pb-3 border-bottom">Phương thức thanh toán</h6>
                                        <p class="card-text d-flex align-items-center justify-content-between mb-1 pt-2 fs-7">
                                            <span class="fw-bold"><?=$order_info['hinh_thuc_thanh_toan']?>: </span>
                                            <span class="ms-1 fs-5 fw-bold text-primary"><?=currency_format($order_info['thanh_tien'])?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End main content -->

        <!-- Start footer -->
        <footer id="footer" class="footer">
            <div class="footer-content">
                <div class="container-lg container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="footer-item">
                                <h6 class="footer-item__title">
                                    VỀ CHÚNG TÔI
                                    </h5>
                                    <div class="footer-item__body">
                                        <p class="footer-item__desc">
                                            Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500.
                                        </p>
                                        <p class="footer-item__info">
                                            <span class="footer-item__icon">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <span class="footer-item__info-text">
                                                Số 18-E4, đường số 5, KDC Tràng An, Phường 7, TP. Bạc Liêu, Tỉnh Bạc Liêu
                                            </span>
                                        </p>
                                        <p class="footer-item__info">
                                            <span class="footer-item__icon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            <span class="footer-item__info-text">
                                                example@gmail.com
                                            </span>
                                        </p>
                                        <p class="footer-item__info">
                                            <span class="footer-item__icon">
                                                <i class="fa-solid fa-phone"></i>
                                            </span>
                                            <span class="footer-item__info-text">
                                                0844 444 369
                                            </span>
                                        </p>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="footer-item">
                                <h6 class="footer-item__title">
                                    CHÍNH SÁCH & ĐIỀU KHOẢN
                                    </h5>
                                    <div class="footer-item__body">
                                        <ul class="footer-item__nav">
                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách mua hàng
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách bảo hành
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách bảo mật
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Điều khoản chung
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="footer-item">
                                <h6 class="footer-item__title">
                                    CHÍNH SÁCH & ĐIỀU KHOẢN
                                    </h5>
                                    <div class="footer-item__body">
                                        <ul class="footer-item__nav">
                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách mua hàng
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách bảo hành
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách bảo mật
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Điều khoản chung
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="footer-item">
                                <h6 class="footer-item__title">
                                    CHÍNH SÁCH & ĐIỀU KHOẢN
                                    </h5>
                                    <div class="footer-item__body">
                                        <ul class="footer-item__nav">
                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách mua hàng
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách bảo hành
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Chính sách bảo mật
                                                </a>
                                            </li>

                                            <li class="footer-item__nav-item">
                                                <a href="" class="footer-item__nav-link">
                                                    Điều khoản chung
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
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

</body>

</html>