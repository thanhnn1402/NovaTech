<?php
require("../config/config.php");
if (!empty($adminlogged)) {
	unset($_SESSION['admin_logged']);
}

$error = array();

if (isset($_POST['login-submit']) && $_POST['login-submit'] == 'submit') {
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$password = isset($_POST['password']) ? addslashes($_POST['password']) : '';

	if (empty($username)) {
		$error['username'] = 'Vui lòng nhập tên tài khoản';
	}

	if (empty($password)) {
		$error['password'] = 'Vui lòng nhập mật khẩu';
	}




	if (empty($error)) {
		$sql = "SELECT id, ten_tai_khoan, mat_khau, ho_ten, email, avatar FROM khach_hang WHERE `ten_tai_khoan` = ? AND `mat_khau` = ? AND `level` = 1 ";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$admin = $result->fetch_all(MYSQLI_ASSOC);


			$_SESSION['admin_logged'] = array(
				'id' =>  $admin[0]['id'],
				'fullname' => $admin[0]['ho_ten'],
				'email' => $admin[0]['email'],
				'avatar' => $admin[0]['avatar'],
			);

			echo "<script>
					alert('Đăng nhập thành công!');
					window.location.href = 'index.php';
				</script>";

		} else {
			$error['username'] = 'Tài khoản hoặc mật khẩu không đúng!';
			$error['password'] = 'Tài khoản hoặc mật khẩu không đúng!';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>Login Basic - Pages | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

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
	<!-- Page -->
	<link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
	<!-- Helpers -->
	<script src="../assets/vendor/js/helpers.js"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="../assets/js/config.js"></script>
</head>

<body>
	<!-- Content -->

	<div class="container-xxl">
		<div class="authentication-wrapper authentication-basic container-p-y">
			<div class="authentication-inner">
				<!-- Register -->
				<div class="card">
					<div class="card-body">
						<h5 class="mb-5 fw-bold text-center">ĐĂNG NHẬP <span class="text-primary">QUẢN TRỊ VIÊN</span> </h5>

						<form id="formAuthentication" class="mb-3" action="auth-login.php" method="POST">
							<div class="mb-3">
								<label for="username" class="form-label">Tên tài khoản</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Enter your email or username" autofocus />
								<span class="form-text text-danger">
									<?php echo isset($error['username']) ? $error['username'] : ''; ?>
								</span>
							</div>
							<div class="mb-3 form-password-toggle">
								<div class="d-flex justify-content-between">
									<label class="form-label" for="password">Mật khẩu</label>
								</div>
								<div class="input-group input-group-merge">
									<input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
									<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
								</div>
								<span class="form-text text-danger">
									<?php echo isset($error['password']) ? $error['password'] : ''; ?>
								</span>
							</div>
							<div class="mb-3">
								<button class="btn btn-primary d-grid w-100" type="submit" name="login-submit" value="submit">Đăng nhập</button>
							</div>
						</form>
					</div>
				</div>
				<!-- /Register -->
			</div>
		</div>
	</div>

	<!-- / Content -->



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

	<!-- Place this tag in your head or just before your close body tag. -->
	<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>