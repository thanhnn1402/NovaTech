<?php
    require('./admin/config/config.php');

    $error = array();

    // Chuỗi thông tin xác thực google
    $client_id = '40464060386-t7nmio6hrg143doj33fesrn85q8k3lha.apps.googleusercontent.com';
    $client_secret = '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';
    $redirect_uri = 'https://novaitech.000webhostapp.com/google-login/callback.php';
    // $redirect_uri = 'http://localhost/NovaTech/google-login/callback.php';

    // Tạo URL để chuyển hướng người dùng đến trang đăng nhập Google
    $auth_url = 'https://accounts.google.com/o/oauth2/auth?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=openid%20email%20profile';

    // Chuỗi thông tin xác thực facebook
    $appId = '1043513456657921';
    $appSecret = 'f5f1c397602fa904f03df942933ab3e5';
    $redirectUrl = 'https://novaitech.000webhostapp.com/facebook-login/callback.php';
    // $redirectUrl = 'http://localhost/NovaTech/facebook-login/callback.php';

    // Tạo URL để chuyển hướng người dùng đến trang đăng nhập Facebook
    $authUrl = 'https://www.facebook.com/v14.0/dialog/oauth?client_id='.$appId.'&redirect_uri='.$redirectUrl.'&scope=email';

    if(isset($_POST['login-submit']) && $_POST['login-submit'] == 'submit') {
        $account = isset($_POST['account']) ? trim($_POST['account']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        if(empty($account)) {
            $error['account'] = 'Bạn chưa nhập tên tài khoản!';
        }

        if(empty($password)) {
            $error['password'] = 'Bạn chưa nhập mật khẩu!';
        }


        if(empty($error)) {
            $sql = "SELECT * FROM khach_hang WHERE ten_tai_khoan = '{$account}' OR email = '{$account}'";
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if($user['mat_khau'] == $password ) {
                    $_SESSION['user_logged'] = array(
                        'id' => $user['id'],
                        'username' => $user['ten_tai_khoan'],
                        'fullname' => $user['ho_ten'],
                        'avatar' => $user['avatar']
                    );

                    if(isset($_SESSION['previous-page'])) {
                        header("location: " . $_SESSION['previous-page']);
                    } else {
                        header("location: index.php");
                    }
                }  else {
                    $error['password'] = 'Mật khẩu không đúng!';
                }

            } else {
                $error['account'] = 'Tên tài khoản không đúng!';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style-login.css">
</head>
</head>

<body>
    <div class="wrapper">

        <!-- Start main content -->
        <div class="main-content">
            <div class="container-lg container-fluid login-register-content">
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-8 col-12 login-form">
                        <form action="login.php" id="form-login" method="POST">
                            <div class="login-form-logo">
                                <img src="./assets/img/logo.png" alt="">
                            </div>
                            <h5 class="text-center">Đăng nhập tài khoản</h5>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label for="account" class="form-label">
                                        <i class="fa-solid fa-user"></i>
                                    </label>
                                    <input type="text" class="form-control" id="account" name="account" aria-describedby="emailHelp"
                                        placeholder="Tên tài khoản hoặc email">
                                </div>
                                <span class="error-message form-text text-danger">
                                    <?php echo isset($error['account']) ? $error['account'] : ''; ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label for="password" class="form-label">
                                        <i class="fa-solid fa-lock"></i>
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                                </div>
                                <span class="error-message form-text text-danger">
                                    <?php echo isset($error['password']) ? $error['password'] : ''; ?>
                                </span>
                                <a href="" class="mt-2 d-block fs-7 text-decoration-none text-end">Quên mật khẩu?</a>
                            </div>
                            <input type="hidden" name="login-submit" value="submit">
                            <button class="form-login-btn">Đăng nhập</button>
                        </form>

                        <div class="d-flex align-items-center justify-content-between my-4">
                            <hr class="flex-fill">
                            <span class="mx-3 text-default">
                                Chưa có tài khoản?
                                <a href="./register.php" class="text-primary text-decoration-none">
                                    Đăng ký
                                </a></span>
                            <hr class="flex-fill">
                        </div>
                        
                        <div class="socical-login">
                            <div class="row">
                                <div class="col-6">
                                    <a href="<?=$authUrl?>" class="socical-login-btn socical-login--facebook">
                                        <i class="fa-brands fa-facebook-f me-1"></i>
                                        Facebook
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?=$auth_url?>" class="socical-login-btn socical-login--google">
                                        <i class="fa-brands fa-google me-1"></i>
                                        Google
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End main content -->

    </div>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <!-- Bootstrap Bundle JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- Validate -->
    <script src="./assets/js/validatior.js"
        type="text/javascript"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        validator({
            form: '#form-login',
            errorSelector: '.error-message',
            formGroupSelector: '.form-group',
            rules: [
                validator.isRequired('#account', 'Vui lòng nhập trường này'),
                validator.isRequired('#password', 'Vui lòng nhập trường này'),
                validator.minLength('#password', 6, 'Vui lòng nhập tối thiêu 6 kí tự'),
            ]
        })
    </script>

</body>

</html>