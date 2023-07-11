<?php
require('./admin/config/config.php');

if (!empty($userlogged)) {
    $sql = "SELECT * FROM khach_hang WHERE id = {$userlogged['id']}";
    $result = $conn->query($sql);

    $user = $result->fetch_assoc();

    $error = array();
    $address_array = array();

    //
    $sql_address = "SELECT * FROM so_dia_chi WHERE id_khach_hang = {$user['id']}";
    $result_address = $conn->query($sql_address);

    if($result_address->num_rows > 0) {
        while($row = $result_address->fetch_assoc()) {
            $address_array[] = $row;
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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

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
                                <li class="sidebar-menu__item">
                                    <a href="./change-password.php" class="sidebar-menu__link">
                                        <i class="fa-solid fa-gear sidebar-menu__icon"></i> Đổi mật khấu
                                    </a>
                                </li>
                                <li class="sidebar-menu__item active">
                                    <a href="./address.php" class="sidebar-menu__link">
                                        <i class="fa-solid fa-map-location-dot sidebar-menu__icon"></i> Địa chỉ
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="w-100 btn-add-address btn btn-light py-3 text-center shadow-sm" data-bs-toggle="modal" data-bs-target="#address-modal">
                                    <i class="fa-solid fa-plus me-2"></i>
                                    Thêm địa chỉ mới
                                </button>
                            </div>
                            <?php foreach ($address_array as $item) { 
                                $cityArr = explode('-', $item['tinh_tp']);
                                $districtArr = explode('-', $item['quan_huyen']);
                                $wardArr = explode('-', $item['phuong_xa']);
                            ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <h6 class="card-title"><?=$item['ho_ten']?> <?php if($item['trang_thai'] == 0) { echo '<span class="badge ms-2 bg-primary">Mặc định</span>'; } ?></h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-1 fs-7 text-default">Địa chỉ: <?=$item['dia_chi_cu_the'] . ', ' . $wardArr[1] . ', ' . $districtArr[1] . ', ' . $cityArr[1]?></p>
                                                    <p class="mb-1 fs-7 text-default">Điện thoại: <?=$item['so_dien_thoai']?></p>
                                                    <p class="mb-1 fs-7 text-default">Email: <?=$item['email']?></p>
                                                </div>

                                                <div>
                                                    <button 
                                                        class="btn btn-sm btn-outline-primary me-2 btn-edit-address"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#address-modal" 
                                                        data-id="<?=$item['id']?>"
                                                        data-name="<?=$item['ho_ten']?>" 
                                                        data-phone="<?=$item['so_dien_thoai']?>" 
                                                        data-email="<?=$item['email']?>"
                                                        data-city="<?=$cityArr[0]?>"
                                                        data-district="<?=$districtArr[0]?>"
                                                        data-ward="<?=$wardArr[0]?>"
                                                        data-address="<?=$item['dia_chi_cu_the']?>"
                                                        data-check="<?=$item['trang_thai']?>"
                                                    >
                                                        Chỉnh sửa
                                                    </button>
                                                    <?php if($item['trang_thai'] != 0) { echo '<a href="address_delete.php?id='.$item['id'].'" class="btn btn-sm btn-outline-secondary">Xóa</a>'; }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>

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

        <!-- Modal -->
        <div class="modal fade" id="address-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin người nhận hàng</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-address" action="address_insert.php" method="POST">
                            <div class="border-bottom">
                                <div class="mb-3 form-group">
                                    <label for="fullname" class="form-label fs-7 fw-semibold">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control shadow-none fs-7" id="fullname" name="fullname" aria-describedby="emailHelp" placeholder="Nhập họ tên người nhận hàng">
                                    <span class="form-text text-danger"></span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="email" class="form-label fs-7 fw-semibold">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control shadow-none fs-7" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email của bạn">
                                            <span class="form-text text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="phone" class="form-label fs-7 fw-semibold">Điện thoại <span class="text-danger">*</span></label>
                                            <input type="phone" class="form-control shadow-none fs-7" id="phone" name="phone" placeholder="Nhập số điện thoại">
                                            <span class="form-text text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h6 class="my-3">Địa chỉ nhận hàng</h6>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="phone" class="form-label fs-7 fw-semibold">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                        <select id="city" class="select-tp form-select fs-7 shadow-none" aria-label="Default select example">
                                            <option value="" selected>--- Chọn Tỉnh/Thành phố ---</option>
                                        </select>
                                        <input type="hidden" name="city">
                                        <span class="form-text text-danger"></span>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="phone" class="form-label fs-7 fw-semibold">Quận/Huyện <span class="text-danger">*</span></label>
                                        <select id="district" class="form-select fs-7 shadow-none" aria-label="Default select example">
                                            <option value="" selected>--- Chọn Quận/Huyện ---</option>
                                        </select>
                                        <input type="hidden" name="district">
                                        <span class="form-text text-danger"></span>
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <label for="phone" class="form-label fs-7 fw-semibold">Phường/Xã <span class="text-danger">*</span></label>
                                        <select id="ward" class="form-select fs-7 shadow-none" aria-label="Default select example">
                                            <option value="" selected>--- Chọn Phường/Xã ---</option>
                                        </select>
                                        <input type="hidden" name="ward">
                                        <span class="form-text text-danger"></span>
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label fs-7 fw-semibold">Địa chỉ cụ thể <span class="text-danger">*</span></label>
                                            <input type="phone" class="form-control shadow-none fs-7" id="address" placeholder="Số nhà, ấp, tên đường" name="address">
                                            <span class="form-text text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-check d-flex justify-content-end">
                                            <input class="form-check-input" type="checkbox" value="checked" id="flexCheckDefault" name="check-address-default">
                                            <label class="form-check-label ms-2" for="flexCheckDefault">
                                                Đặt làm mặc định
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="input-submit" name="add-address-submit" value="submit">
                                <input type="hidden" id="id-address" name="id_address" value="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button class="btn btn-sm btn-primary" form="form-address">Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal -->

    </div>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>


    <!-- Bootstrap Bundle JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- Validator -->
    <script src="./assets/js/validatior.js"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        validator({
            form: '#form-address',
            errorSelector: '.form-text',
            formGroupSelector: '.form-group',
            rules: [
                validator.isRequired('#fullname', 'Vui lòng nhập trường này'),
                validator.isRequired('#email', 'Vui lòng nhập trường này'),
                validator.isEmail('#email', 'Vui lòng nhập đúng định dạng email'),
                validator.isRequired('#phone', 'Vui lòng nhập trường này'),
                validator.isRequired('#city', 'Vui lòng nhập trường này'),
                validator.isRequired('#district', 'Vui lòng nhập trường này'),
                validator.isRequired('#ward', 'Vui lòng nhập trường này'),
                validator.isRequired('#address', 'Vui lòng nhập trường này'),
            ]
        })
    </script>

    <script>
        const citis = document.getElementById("city");
        const districts = document.getElementById("district");
        const wards = document.getElementById("ward");
        const inputCity = document.querySelector('input[name="city"]');
        const inputDistrict = document.querySelector('input[name="district"]');
        const inputWard = document.querySelector('input[name="ward"]');

        const Parameter = {
            method: "GET",
            url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
            responseType: "application/json",
        };

        const promise = axios(Parameter);

        promise.then(function(result) {
            renderCity(result.data);
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Id);
            }
            citis.onchange = function() {
                districts.length = 1;
                wards.length = 1;

                if (this.value != "") {
                    const result = data.filter(n => n.Id === this.value);
                    
                    for (const k of result[0].Districts) {
                        districts.options[districts.options.length] = new Option(k.Name, k.Id);
                    }
                    inputCity.value = `${this.value}-${citis.options[citis.selectedIndex].text}`;
                }
            };
            districts.onchange = function() {
                wards.length = 1;
                const dataCity = data.filter((n) => n.Id === citis.value);
                if (this.value != "") {
                    const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;
                    
                    for (const w of dataWards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Id);
                    }
                    inputDistrict.value = `${this.value}-${districts.options[districts.selectedIndex].text}`;
                }
            };
            wards.onchange = function() {
                if(this.value != '') {
                    inputWard.value = `${this.value}-${wards.options[wards.selectedIndex].text}`;
                }
            }
        }

        const addressModal = document.getElementById('address-modal');
        const formAddress = document.getElementById('form-address');
        const inputSubmit = addressModal.querySelector('form input#input-submit');
        addressModal.addEventListener('show.bs.modal', event => {

            const button = event.relatedTarget;

            if (button.matches('.btn-add-address')) {
                formAddress.setAttribute('action', 'address_insert.php');
                inputSubmit.setAttribute('name', 'add-address-submit');
            } else {
                
                const data = {
                    id: button.getAttribute('data-id'),
                    name: button.getAttribute('data-name'),
                    email: button.getAttribute('data-email'),
                    phone: button.getAttribute('data-phone'),
                    city: button.getAttribute('data-city'),
                    district: button.getAttribute('data-district'),
                    ward: button.getAttribute('data-ward'),
                    address: button.getAttribute('data-address'),
                    check: button.getAttribute('data-check'),
                }

                formAddress.setAttribute('action', 'address_update.php');
                inputSubmit.setAttribute('name', 'edit-address-submit');
                document.querySelector('form input#id-address').value = data.id;

                // Update the modal's content.
                document.querySelector('.modal-body #fullname').value = data.name;
                document.querySelector('.modal-body #email').value = data.email;
                document.querySelector('.modal-body #phone').value = data.phone;
            }

        })


       
    </script>
</body>

</html>