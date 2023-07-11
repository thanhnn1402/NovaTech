<?php 
    require('./admin/config/config.php');
    $sql = "SELECT * FROM khach_hang WHERE id = {$userlogged['id']}";
    $result = $conn->query($sql);

    $user = $result->fetch_assoc();

    $error = array();

    if(isset($_POST['change-password-submit']) && $_POST['change-password-submit'] == 'submit') {
        $old_password = isset($_POST['old-password']) ? $_POST['old-password'] : '';
        $new_password = isset($_POST['new-password']) ? $_POST['new-password'] : '';
        $confirm_new_password = isset($_POST['confirm-new-password']) ? $_POST['confirm-new-password'] : '';

        if(empty($old_password)) {
            $error['old-password'] = 'Bạn chưa nhập mật khẩu cũ!';
        }

        if(empty($new_password)) {
            $error['new-password'] = 'Bạn chưa nhập mật khẩu mới!';
        }

        if(empty($confirm_new_password)) {
            $error['confirm-new-password'] = 'Bạn chưa nhập lại mật khẩu mới!';
        } else if($confirm_new_password != $new_password){
            $error['confirm-new-password'] = 'Mật khẩu nhập lại chưa đúng!';
        }

        if(empty($error)) {

            if($old_password != $user['mat_khau']) {
                $error['old-password'] = 'Mật khẩu cũ chưa chính xác!';
            } else {
                $sql = "UPDATE `khach_hang` SET `mat_khau`= ?, `updated_at`='{$date_current}' WHERE id = {$user['id']}";

                $stmt = $conn->prepare($sql);

                $stmt->bind_param("s", $new_password);

                if($stmt->execute()) {
                    echo "<script>
                            alert('Đổi mật khẩu thành công!');
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
                                <img src="<?=$user['avatar']?>" alt="" class="sidebar-menu__header-img">
                                <p class="sidebar-menu__header-name"><?=$userlogged['fullname']?></p>
                            </div>

                            <ul class="sidebar-menu__list">
                                <li class="sidebar-menu__item">
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
                                <li class="sidebar-menu__item active">
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
                        <h5 class="profile-content__title">Đổi mật khẩu</h5>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <form action="" id="form-change-password" class="profile-content__form" method="POST">
                                    <div class="mb-3 form-group">
                                        <label for="old-password" class="form-label profile-content__label">Mật khẩu cũ</label>
                                        <input type="password" class="form-control profile-content__input" id="old-password" name="old-password">
                                        <span class="form-text text-danger">
                                            <?php echo isset($error['old-password']) ? $error['old-password'] : ''?>
                                        </span>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="new-password" class="form-label profile-content__label">Mật khẩu mới</label>
                                        <input type="password" class="form-control profile-content__input" id="new-password" name="new-password">
                                        <span class="form-text text-danger">
                                            <?php echo isset($error['new-password']) ? $error['new-password'] : ''?>
                                        </span>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="confirm-new-password" class="form-label profile-content__label">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control profile-content__input" id="confirm-new-password" name="confirm-new-password">
                                        <span class="form-text text-danger">
                                            <?php echo isset($error['confirm-new-password']) ? $error['confirm-new-password'] : ''?>
                                        </span>
                                    </div>
                                    <input type="hidden" name="change-password-submit" value="submit">
                                    <button class="btn btn-primary profile-content__btn">Cập nhật</button>
                                </form>
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
            form: '#form-change-password',
            errorSelector: '.form-text',
            formGroupSelector: '.form-group',
            rules: [
                validator.isRequired('#old-password', 'Vui lòng nhập trường này'),
                validator.isRequired('#new-password', 'Vui lòng nhập trường này'),
                validator.isRequired('#confirm-new-password', 'Vui lòng nhập trường này'),
                validator.minLength('#old-password', 6, 'Vui lòng nhập tối thiêu 6 kí tự'),
                validator.minLength('#new-password', 6, 'Vui lòng nhập tối thiêu 6 kí tự'),
                validator.minLength('#confirm-new-password', 6, 'Vui lòng nhập tối thiêu 6 kí tự'),
                
                validator.isConfirm('#confirm-new-password', function() {
                    return document.querySelector('#form-change-password #new-password').value;
                }, 'Mật khẩu nhập lại không đúng'),

            ]
        })
    </script>
</body>
</html>