<?php
require('./admin/config/config.php');

if (!empty($userlogged)) {

    function get_orders($conn, $user_id, $state)
    {
        $data = array();

        $sql = "SELECT * FROM `don_hang` WHERE id_khach_hang = {$user_id} AND trang_thai = {$state}";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    $don_hang_cho_thanh_toan = get_orders($conn, $userlogged['id'], 0);
    $don_hang_dang_giao_hang = get_orders($conn, $userlogged['id'], 1);
    $don_hang_da_hoan_thanh = get_orders($conn, $userlogged['id'], 2);
    $don_hang_da_huy = get_orders($conn, $userlogged['id'], 3);
    
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
    <title>NovaTech</title>

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
        <div class="orders-content">
            <div class="container-lg container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sidebar-menu">
                            <div class="sidebar-menu__header">
                                <img src="<?= $userlogged['avatar'] ?>" alt="" class="sidebar-menu__header-img">
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

                    <div class="col-md-9 orders-content__center">
                        <div class="orders-content__center-header">
                            <h5 class="orders-content__header-title">Quản lý đơn hàng</h5>

                            <div class="orders-content__header-tabs">
                                <button class="orders-content__header-tab tab active">Chờ xác nhận</button>
                                <button class="orders-content__header-tab tab">Đang giao hàng</button>
                                <button class="orders-content__header-tab tab">Đã hoàn thành</button>
                                <button class="orders-content__header-tab tab">Đã hủy</button>
                            </div>
                        </div>

                        <div class="orders-content__body">
                            <div class="orders-content__body-panel panel active">
                                <?php if (!empty($don_hang_cho_thanh_toan)) { ?>

                                    <table class="table align-middle text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Mã đơn hàng</th>
                                                <th scope="col">Ngày mua hàng</th>
                                                <th scope="col">Thanh toán</th>
                                                <th scope="col">Trạng thái thanh toán</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($don_hang_cho_thanh_toan as $item) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="./order-detail.php?madonhang=<?= $item['ma_don_hang'] ?>" class="text-decoration-none"><?= $item['ma_don_hang'] ?></a>
                                                    </td>
                                                    <td><?= $item['ngay_lap'] ?></td>
                                                    <td>
                                                        <?= $item['hinh_thuc_thanh_toan'] ?>
                                                    </td>
                                                    <td class="text-success">
                                                        <?= convert_state_payment($item['trang_thai_thanh_toan']) ?>
                                                    </td>
                                                    <td>
                                                        <?= currency_format($item['thanh_tien']) ?>
                                                    </td>
                                                    <td class="text-success"><?= convert_state($item['trang_thai']) ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                <?php } else { ?>
                                    <div class="orders-content__body-panel--empty">
                                        <img src="./assets/img/order-empty.png" alt="">
                                        <p class="mt-3">Bạn chưa có đơn hàng nào!</p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="orders-content__body-panel panel">
                                <?php if (!empty($don_hang_dang_giao_hang)) { ?>

                                    <table class="table align-middle text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Mã đơn hàng</th>
                                                <th scope="col">Ngày mua hàng</th>
                                                <th scope="col">Thanh toán</th>
                                                <th scope="col">Trạng thái thanh toán</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($don_hang_dang_giao_hang as $item) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="./order-detail.php?madonhang=<?= $item['ma_don_hang'] ?>" class="text-decoration-none"><?= $item['ma_don_hang'] ?></a>
                                                    </td>
                                                    <td><?= $item['ngay_lap'] ?></td>
                                                    <td>
                                                        <?= $item['hinh_thuc_thanh_toan'] ?>
                                                    </td>
                                                    <td class="text-success">
                                                        <?= convert_state_payment($item['trang_thai_thanh_toan']) ?>
                                                    </td>
                                                    <td>
                                                        <?= currency_format($item['thanh_tien']) ?>
                                                    </td>
                                                    <td class="text-success"><?= convert_state($item['trang_thai']) ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                <?php } else { ?>
                                    <div class="orders-content__body-panel--empty">
                                        <img src="./assets/img/order-empty.png" alt="">
                                        <p class="mt-3">Bạn chưa có đơn hàng nào!</p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="orders-content__body-panel panel">
                                <?php if (!empty($don_hang_da_hoan_thanh)) { ?>

                                    <table class="table align-middle text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Mã đơn hàng</th>
                                                <th scope="col">Ngày mua hàng</th>
                                                <th scope="col">Thanh toán</th>
                                                <th scope="col">Trạng thái thanh toán</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($don_hang_da_hoan_thanh as $item) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="./order-detail.php?madonhang=<?= $item['ma_don_hang'] ?>" class="text-decoration-none"><?= $item['ma_don_hang'] ?></a>
                                                    </td>
                                                    <td><?= $item['ngay_lap'] ?></td>
                                                    <td>
                                                        <?= $item['hinh_thuc_thanh_toan'] ?>
                                                    </td>
                                                    <td class="text-success">
                                                        <?= convert_state_payment($item['trang_thai_thanh_toan']) ?>
                                                    </td>
                                                    <td>
                                                        <?= currency_format($item['thanh_tien']) ?>
                                                    </td>
                                                    <td class="text-success"><?= convert_state($item['trang_thai']) ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                <?php } else { ?>
                                    <div class="orders-content__body-panel--empty">
                                        <img src="./assets/img/order-empty.png" alt="">
                                        <p class="mt-3">Bạn chưa có đơn hàng nào!</p>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="orders-content__body-panel panel">
                                <?php if (!empty($don_hang_da_huy)) { ?>

                                    <table class="table align-middle text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Mã đơn hàng</th>
                                                <th scope="col">Ngày mua hàng</th>
                                                <th scope="col">Thanh toán</th>
                                                <th scope="col">Trạng thái thanh toán</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($don_hang_da_huy as $item) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="./order-detail.php?madonhang=<?= $item['ma_don_hang'] ?>" class="text-decoration-none"><?= $item['ma_don_hang'] ?></a>
                                                    </td>
                                                    <td><?= $item['ngay_lap'] ?></td>
                                                    <td>
                                                        <?= $item['hinh_thuc_thanh_toan'] ?>
                                                    </td>
                                                    <td class="text-success">
                                                        <?= convert_state_payment($item['trang_thai_thanh_toan']) ?>
                                                    </td>
                                                    <td>
                                                        <?= currency_format($item['thanh_tien']) ?>
                                                    </td>
                                                    <td class="text-success"><?= convert_state($item['trang_thai']) ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                <?php } else { ?>
                                    <div class="orders-content__body-panel--empty">
                                        <img src="./assets/img/order-empty.png" alt="">
                                        <p class="mt-3">Bạn chưa có đơn hàng nào!</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End main content -->

        <!-- Start footer -->
        <?php require_once('partials/footer.php') ?>
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
        const tabs = document.querySelectorAll('.tab');
        const panels = document.querySelectorAll('.panel');

        tabs.forEach(function(tab, index) {
            const panel = panels[index];

            tab.onclick = function() {
                document.querySelector('.orders-content__header-tab.tab.active').classList.remove('active');
                document.querySelector('.orders-content__body-panel.panel.active').classList.remove('active');

                this.classList.add('active');
                panel.classList.add('active');
            }
        })
    </script>
</body>

</html>