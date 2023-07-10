<?php
require("../../config/config.php");
if (!empty($adminlogged)) {

    $madonhang = isset($_GET['madonhang']) ? $_GET['madonhang'] : '';
    $trangthai = isset($_GET['state']) ? $_GET['state'] : '';

    if (!empty($madonhang)) {

        $order_info = array();
        $products = array();
        $index = 1;

        $sql_get_order = "SELECT don_hang.ma_don_hang, so_dia_chi.ho_ten, so_dia_chi.so_dien_thoai, so_dia_chi.email, so_dia_chi.tinh_tp, so_dia_chi.quan_huyen, so_dia_chi.phuong_xa, so_dia_chi.dia_chi_cu_the, don_hang.ngay_lap, don_hang.hinh_thuc_thanh_toan, don_hang.trang_thai, don_hang.trang_thai_thanh_toan, don_hang.thanh_tien
                          FROM don_hang, so_dia_chi
                          WHERE don_hang.dia_chi_nhan_hang = so_dia_chi.id AND don_hang.ma_don_hang = '{$madonhang}'";

        $order_info = $conn->query($sql_get_order)->fetch_assoc();

        $city = explode("-", $order_info['tinh_tp']);
        $district = explode("-", $order_info['quan_huyen']);
        $ward = explode("-", $order_info['phuong_xa']);


        $sql_get_products = "SELECT san_pham.id, san_pham.ten_sp, san_pham.don_gia_khuyen_mai, chi_tiet_don_hang.so_luong, chi_tiet_don_hang.tri_gia, san_pham.hinh_anh
                            FROM san_pham, chi_tiet_don_hang
                            WHERE san_pham.id = chi_tiet_don_hang.id_san_pham AND chi_tiet_don_hang.ma_don_hang = '{$madonhang}'";

        $result_products = $conn->query($sql_get_products);

        while ($row = $result_products->fetch_assoc()) {
            $products[] = $row;
        }


        if(!empty($trangthai)) {
            $sql_update_order = "UPDATE don_hang SET trang_thai = '{$trangthai}' WHERE ma_don_hang = '{$madonhang}'";

            if($conn->query($sql_update_order)) {
                echo "<script>
                      alert('Thành công!');
                      window.location.href = 'order-list.php';
                  </script>";
            } else {
            echo "<script>
                        alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                    </script>";
            }
        }
    }
} else {
    header("location: ../auth-login.php");
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Quản trị viên</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.php" class="app-brand-link">
                        <span class="app-brand-logo demo">

                        </span>
                        <span class="app-brand-text demo menu-text text-uppercase fw-bolder">ADMIN</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="../index.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Trang chú</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Giao diện web</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-category"></i>
                            <div data-i18n="Account Settings">Quản lí danh mục</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="../categories/category-list.php" class="menu-link">
                                    <div>Danh sách danh mục</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="../categories/category-add.php" class="menu-link">
                                    <div>Thêm danh mục</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-carousel"></i>
                            <div data-i18n="Account Settings">Quản lí banner</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="../banners/banner-list.php" class="menu-link">
                                    <div>Danh sách banner</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="../banners/banner-add.php" class="menu-link">
                                    <div>Thêm banner</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Khách hàng</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user-pin"></i>
                            <div data-i18n="Account Settings">Quản lí tài khoản</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="../users/user-list.php" class="menu-link">
                                    <div>Danh sách tài khoản</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="../users/user-add.php" class="menu-link">
                                    <div>Thêm tài khoản</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Sản phẩm</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-desktop"></i>
                            <div data-i18n="Account Settings">Quản lí sản phẩm</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="../products/product-list.php" class="menu-link">
                                    <div>Danh sách sản phẩm</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="../products/product-add.php" class="menu-link">
                                    <div>Nhập sản phẩm</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-edit"></i>
                            <div data-i18n="Account Settings">Quản lí chi tiết</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="../products-detail/product-detail-pc-add.php" class="menu-link">
                                    <div>Thêm chi tiết PC</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="../products-detail/product-detail-laptop-add.php" class="menu-link">
                                    <div>Thêm chi tiết Laptop</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="../products-detail/product-detail-camera-add.php" class="menu-link">
                                    <div>Thêm chi tiết Camera</div>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Đơn hàng</span>
                    </li>
                    <li class="menu-item active open">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-list-check"></i>
                            <div data-i18n="Account Settings">Quản lí đơn hàng</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="./order-list.php" class="menu-link">
                                    <div>Danh sách đơn hàng</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../../../storage/uploads/img/<?= $adminlogged['avatar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../../../storage/uploads/img/<?= $adminlogged['avatar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?= $adminlogged['fullname'] ?></span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../account.php">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Thông tin tài khoản</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../account.php">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Cài đặt</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="d-flex align-items-center align-middle">
                                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                <span class="flex-grow-1 align-middle">Thông báo</span>
                                                <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../logout.php">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Đăng xuất</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Đơn hàng /</span>Chi tiết đơn hàng</h4>

                        <div class="row bg-white">
                            <div class="col-md-6">
                                <div class="card shadow-none">
                                    <h5 class="card-title ms-4 mt-4 mb-0">Thông tin khách hàng</h5>

                                    <div class="card-body">
                                        <p>
                                            <span class="fw-bold me-2">Họ tên khách hàng: </span>
                                            <span><?= $order_info['ho_ten'] ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Email: </span>
                                            <span><?= $order_info['email'] ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Số điện thoại: </span>
                                            <span><?= $order_info['so_dien_thoai'] ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Địa chỉ: </span>
                                            <span><?= $order_info['dia_chi_cu_the'] . ', ' . $ward[1] . ', ' . $district[1] . ', ' . $city[1] ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-none">
                                    <h5 class="card-title ms-4 mt-4 mb-0">Thông tin đơn hàng</h5>

                                    <div class="card-body">
                                        <p>
                                            <span class="fw-bold me-2">Mã đơn hàng: </span>
                                            <span class="text-primary"><?= $order_info['ma_don_hang'] ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Ngày đặt hàng: </span>
                                            <span><?= $order_info['ngay_lap'] ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Thanh toán: </span>
                                            <span><?= $order_info['hinh_thuc_thanh_toan'] ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Trạng thái thanh toán: </span>
                                            <span class="text-success"><?= convert_state_payment($order_info['trang_thai_thanh_toan']) ?></span>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-2">Trạng thái đơn hàng: </span>
                                            <span class="text-success"><?= convert_state($order_info['trang_thai']) ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 p-4">
                                <div class="table-responsive text-nowrap p-3">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên sản phẩm</th>
                                                <th scope="col">Số lượng</th>
                                                <th scope="col">Đơn giá</th>
                                                <th scope="col">Trị giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $item) { ?>
                                                <tr>
                                                    <th scope="row"><?=$index?></th>
                                                    <th scope="row"><?=$item['ten_sp']?></th>
                                                    <td><?=$item['so_luong']?></td>
                                                    <td><?=currency_format($item['don_gia_khuyen_mai'])?></td>
                                                    <td><?=currency_format($item['tri_gia'])?></td>
                                                </tr>
                                            <?php $index++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-center fs-5 fw-bold" >
                                                    Tổng thành tiền
                                                </td>
                                                <td class="fs-5 fw-bold text-danger">
                                                    <?=currency_format($order_info['thanh_tien'])?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 px-4 pb-4 d-flex justify-content-between">
                                <div>
                                    <a href="mailto: <?= $order_info['email'] ?>" class="btn btn-info d-inline-flex align-items-center">
                                        <i class='bx bx-envelope'></i>
                                        <span class="ms-1">Liên hệ khách hàng</span>
                                    </a>

                                    <a href="tel: <?= $order_info['so_dien_thoai'] ?>" class="btn btn-warning ms-3 d-inline-flex align-items-center">
                                        <i class='bx bx-phone-call'></i>
                                        <span class="ms-1">Liên hệ khách hàng</span>
                                    </a>
                                </div>
                                <div>
                                    <?php if ($order_info['trang_thai'] == 0) { ?>
                                        <a href="order-edit.php?madonhang=<?=$madonhang?>&state=1" class="btn btn-success ms-3 d-inline-flex align-items-center">
                                            <span class="ms-1">Xác nhận đơn hàng</span>
                                        </a>

                                        <a href="order-edit.php?madonhang=<?=$madonhang?>&state=3" class="btn btn-danger ms-3 d-inline-flex align-items-center">
                                            <span class="ms-1">Hủy đơn hàng</span>
                                        </a>
                                    <?php } ?>
                                </div>
                                
                            </div>
                        </div>
                        <!-- / Content -->



                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../../assets/vendor/libs/popper/popper.js"></script>
        <script src="../../assets/vendor/js/bootstrap.js"></script>
        <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="../../assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->

        <!-- Main JS -->
        <script src="../../assets/js/main.js"></script>

        <!-- Page JS -->

        <script src="../../assets/js/form-basic-inputs.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>