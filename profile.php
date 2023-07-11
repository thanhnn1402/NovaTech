<?php 
    require('./admin/config/config.php');

    if(!empty($userlogged)) {
        $sql = "SELECT * FROM khach_hang WHERE id = {$userlogged['id']}";
        $result = $conn->query($sql);

        $user = $result->fetch_assoc();
        $gioitinh = array("Nam", "Nữ", "Khác");

        $error = array();


        if(isset($_POST['profile-submit']) && $_POST['profile-submit'] == 'submit') {
            $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
            $avatar = isset($_FILES["avatar"]["name"]) ? $_FILES["avatar"]["name"] : '';
            $tempname = $_FILES["avatar"]["tmp_name"];
            $folder = "./storage/uploads/img/" . $avatar;

            if(empty($fullname)) {
                $error['fullname'] = 'Bạn chưa nhập họ tên!';
            }

            if(empty($email)) {
                $error['email'] = 'Bạn chưa nhập email!';
            } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // Kiểm tra định dạng email
                $error['email'] = 'Email chưa đúng định dạng!';
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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style-profile.css">
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
        <div class="profile-content">
            <div class="container-lg container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sidebar-menu">
                            <div class="sidebar-menu__header">
                                <img src="<?=$userlogged['avatar']?>" alt="" class="sidebar-menu__header-img">
                                <p class="sidebar-menu__header-name"><?=$userlogged['fullname']?></p>
                            </div>

                            <ul class="sidebar-menu__list">
                                <li class="sidebar-menu__item active">
                                    <a href="./profile.php" class="sidebar-menu__link">
                                        <i class="fa-regular fa-circle-user sidebar-menu__icon"></i> Thông tin tài khoản
                                    </a>
                                </li>
                                <li class="sidebar-menu__item">
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

                    <div class="col-md-9 profile-content__center">
                        <h5 class="profile-content__title">Thông tin tài khoản</h5>

                        <div class="row mt-4 row-profile">
                            <div class="col-md-8">
                                <form action="" id="form-update" class="profile-content__form" enctype="multipart/form-data" method="POST">

                                    <div class="mb-3 form-group">
                                        <label for="username" class="form-label profile-content__label">Tên tài khoản</label>
                                        <input type="text" class="form-control profile-content__input" id="username" value="<?=$user['ten_tai_khoan']?>" disabled>
                                        <span class="form-text text-danger">
                                            
                                        </span>
                                      </div>
                                    <div class="mb-3 form-group">
                                      <label for="fullname" class="form-label profile-content__label">Họ và tên</label>
                                      <input type="text" class="form-control profile-content__input" id="fullname" name="fullname" value="<?=$user['ho_ten']?>">
                                      <span class="form-text text-danger">
                                        <?php echo isset($error['fullname']) ? $error['fullname'] : ''?>
                                      </span>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="email" class="form-label profile-content__label">Email</label>
                                        <input type="email" class="form-control profile-content__input" id="email" name="email" value="<?=$user['email']?>">
                                        <span class="form-text text-danger">
                                            <?php echo isset($error['email']) ? $error['email'] : ''?>
                                        </span>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="phone" class="form-label profile-content__label">Số điện thoại</label>
                                        <input type="phone" class="form-control profile-content__input" id="phone" name="phone" value="<?=$user['so_dien_thoai']?>">
                                        <span class="form-text text-danger">
                                            <?php echo isset($error['phone']) ? $error['phone'] : ''?>
                                        </span>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="birthdate" class="form-label profile-content__label">Ngày sinh</label>
                                        <input type="date" class="form-control profile-content__input" id="birthdate" name="birthdate" value="<?=$user['ngay_sinh']?>">
                                        <span class="form-text text-danger">
                                            <?php echo isset($error['birthdate']) ? $error['birthdate'] : ''?>
                                        </span>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="gender" class="form-label profile-content__label">Giới tính</label>
                                        <div class="w-50 d-flex align-items-center justify-content-between">
                                            <?php foreach($gioitinh as $item) { ?>
                                                <div>
                                                    <input class="form-check-input profile-content__radio" type="radio" name="gender" value="<?=$item?>" id="male" <?php echo $item == $user['gioi_tinh'] ? 'checked' : '' ?> >
                                                    <label for="male" class="form-label profile-content__label ms-1"><?=$item?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <span class="form-text text-danger"></span>
                                    </div>
                                    <input type="hidden" name="profile-submit" value="submit">
                                    <button class="btn btn-primary profile-content__btn">Cập nhật</button>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="profile-content__form-avatar form-group grid-img">
                                    <img src="<?=$user['avatar']?>" alt="">
                                    <input type="file" class="form-control" id="avatar" name="avatar" form="form-update">
                                    <label for="avatar"><i class="fa-solid fa-upload"></i> Chọn ảnh</label>
                                    <span class="profile-content__form-avatar-text">
                                        Dụng lượng file tối đa 1 MB </br>
                                        Định dạng:.JPEG, .PNG
                                    </span>
                                    <span class="form-text text-danger"></span>
                                </div>
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

    <!-- Validator -->
    <script src="./assets/js/validatior.js"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        validator({
            form: '#form-update',
            errorSelector: '.form-text',
            formGroupSelector: '.form-group',
            rules: [
                validator.isRequired('#fullname', 'Vui lòng nhập trường này'),
                validator.isRequired('#email', 'Vui lòng nhập trường này'),
                validator.isRequired('#phone', 'Vui lòng nhập trường này'),
                validator.isRequired('#birthdate', 'Vui lòng nhập trường này'),
                validator.isEmail('#email', 'Vui lòng nhập đúng định dạng email'),
                validator.isRequired('input[name="gender"]', 'Vui lòng nhập trường này'),
            ]
        });

        const inputFile = document.querySelector('input[name="avatar"]');
        const gridImg = document.querySelector('.grid-img');

        uploadFile(inputFile, gridImg);
    </script>
</body>
</html>