<?php
require("../config/config.php");
if (!empty($adminlogged)) {

    $error = array();
    $user = array();

    $stmt_get_user = $conn->prepare("SELECT * FROM khach_hang WHERE id = ?");
    $stmt_get_user->bind_param("s", $adminlogged['id']);
    $stmt_get_user->execute();
    $result_get_user = $stmt_get_user->get_result();
    $user = $result_get_user->fetch_assoc();

    $gioi_tinh = array("Nam", "Nữ", "Khác");


    if(isset($_POST['account-submit']) && $_POST['account-submit'] == 'submit') {
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

        $avatar = isset($_FILES["avatar"]["name"]) ? $_FILES["avatar"]["name"] : '';
        $tempname = $_FILES["avatar"]["tmp_name"];
        $folder = "../../storage/uploads/img/" . $avatar;

        if(empty($fullname)) {
            $error['fullname'] = 'Bạn chưa nhập họ tên!';
        }

        if(empty($email)) {
            $error['email'] = 'Bạn chưa nhập email!';
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // Kiểm tra định dạng email
            $error['email'] = 'Email chưa đúng định dạng!';
        }

        if(empty($password)) {
            $error['password'] = 'Bạn chưa nhập mật khẩu!';
        }

        if(empty($phone)) {
            $error['phone'] = 'Bạn chưa nhập số điện thoại!';
        }

        if(empty($birthdate)) {
            $error['birthdate'] = 'Bạn chưa chọn ngày sinh!';
        }

        if($_FILES['avatar']['error'] <= 0) {
            move_uploaded_file($tempname ,$folder);
        }

        if(empty($avatar)) {
            $avatar = $user['avatar'];
        }

        if(empty($error)) {

            if($email != $user['email']) {
                $sql = "SELECT * FROM khach_hang WHERE email = '{$email}'";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                    $error['email'] = 'Email đã tồn tại!';
                }
            }

          

            if(empty($error)) {
                $sql = "UPDATE `khach_hang` SET `ho_ten`= ?, `email`= ?,`gioi_tinh`='{$gender}',`ngay_sinh`='{$birthdate}',`so_dien_thoai`= ?,`avatar`='{$avatar}',`updated_at`='{$date_current}' WHERE id = {$user['id']} ";

                $stmt = $conn->prepare($sql);
                
                $stmt->bind_param("sss", $fullname, $email, $phone);

                $_SESSION['user_logged']['avatar'] = $avatar;

                if($stmt->execute()) {
                    echo "<script>
                            alert('Cập nhật tài khoản thành công!');
                        </script>";
                    header("Refresh:0");
                } else {
                    echo "<script>
                            alert('Có lỗi trong quá trình xử lý, Vui lòng thử lại!');
                        </script>";
                }
            }
        }
    }

} else {
    header("location: ./auth-login.php");
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Account settings - Account | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
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
                    <li class="menu-item active">
                        <a href="index.php" class="menu-link">
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
                                <a href="./categories/category-list.php" class="menu-link">
                                    <div>Danh sách danh mục</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="./categories/category-add.php" class="menu-link">
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
                                <a href="./banners/banner-list.php" class="menu-link">
                                    <div>Danh sách banner</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="./banners/banner-add.php" class="menu-link">
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
                                <a href="./users/user-list.php" class="menu-link">
                                    <div>Danh sách tài khoản</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="./users/user-add.php" class="menu-link">
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
                                <a href="./products/product-list.php" class="menu-link">
                                    <div>Danh sách sản phẩm</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="./products/product-add.php" class="menu-link">
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
                                <a href="./products-detail/product-detail-pc-add.php" class="menu-link">
                                    <div>Thêm chi tiết PC</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="./products-detail/product-detail-laptop-add.php" class="menu-link">
                                    <div>Thêm chi tiết Laptop</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="./products-detail/product-detail-camera-add.php" class="menu-link">
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
                                <a href="./orders/order-list.php" class="menu-link">
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


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../../storage/uploads/img/<?= $adminlogged['avatar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../../storage/uploads/img/<?= $adminlogged['avatar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
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
                                        <a class="dropdown-item" href="./account.php">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Thông tin tài khoản</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="./account.php">
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
                                        <a class="dropdown-item" href="logout.php">
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Cài đặt tài khoản /</span> Tài khoản</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Tài khoản</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="notifications.php"><i class="bx bx-bell me-1"></i> Thông báo</a>
                                    </li>

                                </ul>
                                <div class="card mb-4">
                                    <h5 class="card-header">Thông tin tài khoản</h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4 grid-img-avatar">
                                            <img src="../../storage/uploads/img/<?= $user['avatar'] ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <label for="avatar" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Upload new photo</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                    <input type="file" id="avatar" form="formAccountSettings" name="avatar" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                </label>
                                                <a href="" class="btn btn-outline-secondary account-image-reset mb-4">
                                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Reset</span>
                                                </a>

                                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="username" class="form-label">Tên tài khoản</label>
                                                    <input class="form-control" type="text" id="username" value="<?= $user['ten_tai_khoan'] ?>" readonly />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="fullname" class="form-label">Họ tên</label>
                                                    <input class="form-control" type="text" name="fullname" id="fullname" value="<?= $user['ho_ten'] ?>" />
                                                    <span class="form-text text-danger"><?php echo isset($error['fullname']) ? $error['fullname'] : ''?></span>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input class="form-control" type="email" id="email" name="email" value="<?= $user['email'] ?>" placeholder="john.doe@example.com" />
                                                    <span class="form-text text-danger"><?php echo isset($error['email']) ? $error['email'] : ''?></span>
                                                </div>
                                                <div class="mb-3 col-md-6 form-password-toggle">
                                                    <div class="d-flex justify-content-between">
                                                        <label class="form-label" for="password">Mật khẩu</label>
                                                    </div>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="password" class="form-control" name="password" value="<?= $user['mat_khau'] ?>" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                    </div>
                                                    <span class="form-text text-danger"><?php echo isset($error['password']) ? $error['password'] : ''?></span>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="organization" class="form-label">Giới tính</label>
                                                    <div class="d-flex py-2">
                                                        <?php foreach ($gioi_tinh as $item) { ?>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" value="<?= $item ?>" id="Male" name="gender" <?php echo $item == $user['gioi_tinh'] ? 'checked' : '' ?> />
                                                                <label class="form-check-label" for="Male"> <?= $item ?>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <span class="form-text text-danger"><?php echo isset($error['gender']) ? $error['gender'] : ''?></span>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="birthdate" class="form-label">Ngày sinh</label>
                                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= $user['ngay_sinh'] ?>" />
                                                    <span class="form-text text-danger"><?php echo isset($error['birthdate']) ? $error['birthdate'] : ''?></span>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="phone">Số điện thoại</label>
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">VN (+84)</span>
                                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="202 555 0111" value="<?= $user['so_dien_thoai'] ?>" />
                                                    </div>
                                                    <span class="form-text text-danger"><?php echo isset($error['phone']) ? $error['phone'] : ''?></span>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="created_at" class="form-label">Ngày tạo</label>
                                                    <input type="datetime-local" class="form-control" id="created_at" readonly value="<?= $user['created_at'] ?>" placeholder="Address" />
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" name="account-submit" value="submit" class="btn btn-primary me-2">Lưu lại</button>
                                                <button type="reset" class="btn btn-outline-secondary">Hủy</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /Account -->
                                </div>
                                <!-- <div class="card">
                                    <h5 class="card-header">Delete Account</h5>
                                    <div class="card-body">
                                        <div class="mb-3 col-12 mb-0">
                                            <div class="alert alert-warning">
                                                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                                            </div>
                                        </div>
                                        <form id="formAccountDeactivation" onsubmit="return false">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
                                                <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                                            </div>
                                            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                                        </form>
                                    </div>
                                </div> -->
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
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
			const inputFile = document.querySelector('input[name="avatar"]');
			const gridImg = document.querySelector('.grid-img-avatar');

			uploadFile(inputFile, gridImg);
		</script>
</body>

</html>