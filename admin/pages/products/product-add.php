<?php
require("../../config/config.php");
if (!empty($adminlogged)) {

    $error = array();
    $loaisanpham = array();

    function reArrayFiles(&$file_post) {

        $file_array = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_array[$i][$key] = $file_post[$key][$i];
            }
        }
        
        return $file_array;
    }

    // Danh sách loại sản phẩm
    $result = $conn->query("SELECT * FROM loai_hang");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $loaisanpham[] = $row;
        }
    }

    //
    if (isset($_POST['add-product-submit']) && $_POST['add-product-submit'] == 'submit') {
        $tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
        $motasanpham = isset($_POST['motasanpham']) ? $_POST['motasanpham'] : '';
        $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';
        $dongianhap = isset($_POST['dongianhap']) ? $_POST['dongianhap'] : '';
        $dongiaban = isset($_POST['dongiaban']) ? $_POST['dongiaban'] : '';
        $phantramkhuyenmai = isset($_POST['phantramkhuyenmai']) ? $_POST['phantramkhuyenmai'] : '0';
        $ngaynhap = isset($_POST['ngaynhap']) ? $_POST['ngaynhap'] : $date_current;
        $id_loai = isset($_POST['id_loai']) ? $_POST['id_loai'] : '';

        $hinhanh = isset($_FILES["hinhanh"]["name"]) ? $_FILES["hinhanh"]["name"] : '';
        $tempname = $_FILES["hinhanh"]["tmp_name"];
        $folder = "../../../storage/uploads/img/" . $hinhanh;

        if($_FILES['hinhanh']['error'] <= 0) {
            move_uploaded_file($tempname ,$folder);
        }
        
        $files = isset($_FILES['hinhanh_chitiet']) ? $_FILES['hinhanh_chitiet'] : array();
        $hinh_anh_chi_tiet = '';

        if(!empty($files)) {
            $files_array = reArrayFiles($files);
            $files_array = array_reverse($files_array);

            foreach($files_array as $file) {
                if($file['error'] <= 0) {
                    move_uploaded_file($file['tmp_name'], "../../../storage/uploads/img/" . $file['name']);
                    $hinh_anh_chi_tiet .= $file['name'] . '||';
                }
            }
        }

        $hinh_anh_chi_tiet = trim($hinh_anh_chi_tiet, '||');

        if(empty($tensanpham)) {
            $error['tensanpham'] = 'Vui lòng nhập tên sản phẩm!';
        }

        if(empty($motasanpham)) {
            $error['motasanpham'] = 'Vui lòng nhập mô tả sản phẩm!';
        }

        if(empty($soluong)) {
            $error['soluong'] = 'Vui lòng nhập số lượng sản phẩm!';
        }

        if(empty($dongianhap)) {
            $error['dongianhap'] = 'Vui lòng nhập đơn giá nhập sản phẩm!';
        }

        if(empty($dongiaban)) {
            $error['dongiaban'] = 'Vui lòng nhập đơn giá bán sản phẩm!';
        }

        if(empty($phantramkhuyenmai)) {
            $phantramkhuyenmai = 0;
        }

        if(empty($ngaynhap)) {
            $ngaynhap  =  $date_current;
        }

        if(empty($hinhanh)) {
            $error['hinhanh'] = 'Vui lòng chọn hình ảnh đại diện của sản phẩm!';
        }

        if(count(explode('||', $hinh_anh_chi_tiet)) < 4) {
            $error['hinhanh_chitiet'] = 'Vui lòng chọn tối thiểu 4 hình ảnh!';
        }


        if(empty($error)) {
            $dongiakhuyenmai = $dongiaban - $dongiaban * $phantramkhuyenmai / 100;

            $stmt_insert_product = $conn->prepare("INSERT INTO `san_pham`(`ten_sp`, `don_gia_nhap`, `don_gia_ban`, `phan_tram_khuyen_mai`, `don_gia_khuyen_mai`, `so_luong_kho`, `mo_ta`, `hinh_anh_dai_dien`, `hinh_anh`, `ngay_nhap`, `id_loai_hang`) VALUES (? ,? ,? ,? ,? ,? ,? ,?, ?, ?, ?)");
            $stmt_insert_product->bind_param("sssssssssss", $tensanpham, $dongianhap, $dongiaban,$phantramkhuyenmai, $dongiakhuyenmai, $soluong, $motasanpham, $hinhanh, $hinh_anh_chi_tiet, $ngaynhap, $id_loai);

            if($stmt_insert_product->execute()) {
                echo "<script>
                        alert('Thêm sản phẩm thành công!');
                        window.location.href = 'product-list.php';
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

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" />

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
                    <li class="menu-item active open">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-desktop"></i>
                            <div data-i18n="Account Settings">Quản lí sản phẩm</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="./product-list.php" class="menu-link">
                                    <div>Danh sách sản phẩm</div>
                                </a>
                            </li>
                            <li class="menu-item active">
                                <a href="./product-add.php" class="menu-link">
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
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-list-check"></i>
                            <div data-i18n="Account Settings">Quản lí đơn hàng</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="../orders/order-list.php" class="menu-link">
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sản phẩm /</span> Thêm sản phẩm
                        </h4>

                        <form id="form-product-add" action="" method="POST" enctype="multipart/form-data">
                            <div class="row bg-white">
                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="tensanpham" class="form-label">Tên sản phẩm</label>
                                                <input type="text" class="form-control" id="tensanpham" name="tensanpham" aria-describedby="defaultFormControlHelp" />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['tensanpham']) ? $error['tensanpham'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="soluong" class="form-label">Số lượng kho</label>
                                                <input type="number" class="form-control" id="soluong" name="soluong" min="1" aria-describedby="defaultFormControlHelp" />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['soluong']) ? $error['soluong'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="dongianhap" class="form-label">Đơn giá nhập</label>
                                                <input type="number" class="form-control" id="dongianhap" name="dongianhap" min="1" aria-describedby="defaultFormControlHelp" />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['dongianhap']) ? $error['dongianhap'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="dongiaban" class="form-label">Đơn giá bán</label>
                                                <input type="number" class="form-control" id="dongiaban" name="dongiaban" min="1" value="0" aria-describedby="defaultFormControlHelp" />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['dongiaban']) ? $error['dongiaban'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="phantramkhuyenmai" class="form-label">Phần trăm khuyến mãi</label>
                                                <input type="number" class="form-control" id="phantramkhuyenmai" name="phantramkhuyenmai" min="0" max="100" value="0" aria-describedby="defaultFormControlHelp" />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['phantramkhuyenmai']) ? $error['phantramkhuyenmai'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="dongiakhuyenmai" class="form-label">Đơn giá khuyến mãi</label>
                                                <input type="number" class="form-control" id="dongiakhuyenmai" name="dongiakhuyenmai" min="1" value="0" readonly disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="ngaynhap" class="form-label">Ngày nhập</label>
                                                <input type="date" class="form-control" id="ngaynhap" name="ngaynhap" aria-describedby="defaultFormControlHelp" />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['ngaynhap']) ? $error['ngaynhap'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="id_loai" class="form-label">Loại sản phẩm</label>
                                                <select class="form-select" id="id_loai" name="id_loai" aria-label="Default select example">
                                                    <?php foreach ($loaisanpham as $item) { ?>
                                                        <option value="<?= $item['id'] ?>">
                                                            <?=$item['ten_loai'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <span id="defaultFormControlHelp" class="form-text text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="hinhanh" class="form-label">Hình ảnh đại diện của sản phẩm</label>
                                                <input class="form-control" type="file" id="hinhanh" name="hinhanh" accept=".jpg, .png, .jpeg" multiple />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['hinhanh']) ? $error['hinhanh'] : ''; ?>
                                                </span>
                                            </div>
                                            <div class="grid-img grid-img-1 d-flex flex-wrap align-items-start mt-4">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="hinhanh_chitiet" class="form-label">Hình ảnh chi tiết sản phẩm</label>
                                                <input class="form-control" type="file" id="hinhanh_chitiet" name="hinhanh_chitiet[]" accept=".jpg, .png, .jpeg" multiple />
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['hinhanh_chitiet']) ? $error['hinhanh_chitiet'] : ''; ?>
                                                </span>
                                            </div>
                                            <div class="grid-img grid-img-2 d-flex flex-wrap align-items-start mt-4">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mb-4 shadow-none">
                                        <div class="card-body">
                                            <div>
                                                <label for="motasanpham" class="form-label">Mô tả sản phẩm</label>
                                                <input name="motasanpham" type="hidden" id="motasanpham">
                                                <!-- Create the editor container -->
                                                <div id="editor" style="height: 400px">
                                                    
                                                </div>
                                                <span id="defaultFormControlHelp" class="form-text text-danger">
                                                    <?php echo isset($error['motasanpham']) ? $error['motasanpham'] : ''; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-end p-4">
                                    <input type="hidden" name="add-product-submit" value="submit">
                                    <button type="button" class="btn btn-primary me-3 btn-submit">Xác nhận</button>
                                </div>

                            </div>
                        </form>
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

        <!-- Include the Quill library -->
        <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>


        <script src="../../assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->

        <!-- Main JS -->
        <script src="../../assets/js/main.js"></script>

        <!-- Page JS -->

        <script src="../../assets/js/form-basic-inputs.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <!-- Initialize Quill editor -->
        <script>
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                ['blockquote', 'code-block', 'image'],

                [{
                    'header': 1
                }, {
                    'header': 2
                }], // custom button values
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }], // superscript/subscript
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }], // outdent/indent
                [{
                    'direction': 'rtl'
                }], // text direction

                [{
                    'size': ['small', false, 'large', 'huge']
                }], // custom dropdown
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],

                [{
                    'color': []
                }, {
                    'background': []
                }], // dropdown with defaults from theme
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],

                ['clean'] // remove formatting button
            ];

            const quill = new Quill('#editor', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });

            const form = document.querySelector('form#form-product-add');
            const description = document.querySelector('input[name=motasanpham]');
            const btnSubmit =document.querySelector('.btn-submit');

            btnSubmit.onclick = function() {
                description.value = JSON.stringify(quill.getContents());
                form.submit();
            }
        </script>

        <script>
            const inputMultipleFile = document.querySelector('input[name="hinhanh_chitiet[]"]');
            const gridImg2 = document.querySelector('.grid-img-2');

            const inputFile = document.querySelector('input[name="hinhanh"]');
            const gridImg1 = document.querySelector('.grid-img-1');

            uploadFile(inputFile, gridImg1);
            uploadMultipleFile(inputMultipleFile, gridImg2);
        </script>

        <script>
            const inputDonGia = document.querySelector('input#dongiaban');
            const inputPhanTram = document.querySelector('input#phantramkhuyenmai');
            const inputDonGiaKhuyenMai = document.querySelector('input#dongiakhuyenmai');

            inputDonGia.onchange = function(e) {
                
            }
        </script>
</body>

</html>