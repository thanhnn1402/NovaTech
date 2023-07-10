<?php
require('./admin/config/config.php');

if (!empty($userlogged) && isset($_SESSION['products_id'])) {
    $products = array();
    $address = array();
    $tong_tien_don_hang = 0;

    $products_id = isset($_SESSION['products_id']) ? $_SESSION['products_id'] : array();

    if (!empty($products_id)) {
        //
        $products_id = implode(',', $products_id);

        $sql = "SELECT gio_hang.so_luong, san_pham.id, san_pham.ten_sp, san_pham.don_gia_ban, san_pham.phan_tram_khuyen_mai, san_pham.don_gia_khuyen_mai,san_pham.hinh_anh_dai_dien, san_pham.hinh_anh
                        FROM gio_hang, san_pham
                        WHERE gio_hang.id_san_pham = san_pham.id AND gio_hang.id_khach_hang = {$userlogged['id']} AND san_pham.id IN ({$products_id})";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        //
        $sql_address = "SELECT * FROM so_dia_chi WHERE id_khach_hang = {$userlogged['id']}";
        $result_address = $conn->query($sql_address);

        if ($result_address->num_rows > 0) {
            while ($row = $result_address->fetch_assoc()) {
                $address[] = $row;
            }
        }
    }

    //
    if(isset($_GET['payment']) && $_GET['payment'] == 'unsuccessful') {
        if(isset($_SESSION['order'])) {
            unset($_SESSION['order']);
        }

        

        echo "<script>
                    alert('" .$_GET['message']. "!');
              </script>";
    }

} else {

    header("location: login.php");
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
    <link rel="stylesheet" href="./assets/css/style-checkout.css">
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
        <div class="main-content">

            <div class="checkout-content">
                <div class="container-lg container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkout-content__left">
                                <h6 class="checkout-content__left-title">Thông tin nhận hàng</h6>
                                <form action="" id="form-checkout" class="checkout-content__left-form">
                                    <div class="row">
                                        <?php foreach ($address as $item) {
                                            $cityArr = explode('-', $item['tinh_tp']);
                                            $districtArr = explode('-', $item['quan_huyen']);
                                            $wardArr = explode('-', $item['phuong_xa']);
                                        ?>
                                            <div class="col-md-6 col-12">
                                                <div class="checkout-content__left-form-group">
                                                    <input class="form-check-input" type="radio" form="form-order" name="address" id="<?=$item['id']?>" value="<?=$item['id']?>" <?php if ($item['trang_thai'] == 0) echo 'checked'?> >
                                                    <label class="form-check-label" for="<?=$item['id']?>">
                                                        <div class="card w-100">
                                                            <div class="card-body">
                                                                <h6 class="card-title">
                                                                    <?= $item['ho_ten'] ?> 
                                                                    <?php if ($item['trang_thai'] == 0) { echo '<span class="badge ms-2 bg-primary">Mặc định</span>'; } ?>
                                                                </h6>
                                                                <div class="d-flex align-items-end justify-content-between">
                                                                    <div>
                                                                        <p class="mb-1 fs-7 text-default">
                                                                            Địa chỉ: <?= $item['dia_chi_cu_the'] . ', ' . $wardArr[1] . ', ' . $districtArr[1] . ', ' . $cityArr[1] ?>
                                                                        </p>
                                                                        <p class="mb-1 fs-7 text-default">
                                                                            Điện thoại: <?= $item['so_dien_thoai'] ?>
                                                                        </p>
                                                                        <p class="mb-1 fs-7 text-default">
                                                                            Email: <?= $item['email'] ?>
                                                                        </p>
                                                                    </div>

                                                                    <div class="flex-1">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-edit-address w-100" data-bs-toggle="modal" data-bs-target="#address-modal" data-id="<?= $item['id'] ?>" data-name="<?= $item['ho_ten'] ?>" data-phone="<?= $item['so_dien_thoai'] ?>" data-email="<?= $item['email'] ?>" data-city="<?= $cityArr[0] ?>" data-district="<?= $districtArr[0] ?>" data-ward="<?= $wardArr[0] ?>" data-address="<?= $item['dia_chi_cu_the'] ?>" data-check="<?= $item['trang_thai'] ?>">
                                                                            Chỉnh sửa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-6 col-12">
                                            <button type="button" class="btn-add-address" data-bs-toggle="modal" data-bs-target="#address-modal">
                                                <i class="fa-solid fa-plus"></i>
                                                Thêm địa chỉ
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkout-content__right">
                                <h6 class="checkout-content__right-title">Thông tin đơn hàng</h6>
                                <ul class="checkout-content__right-product-list">
                                    <?php foreach ($products as $item) {
                                        $tong_tien_don_hang += ($item['don_gia_khuyen_mai'] * $item['so_luong']);
                                    ?>
                                        <li class="checkout-content__right-product-item">
                                            <img src="./storage/uploads/img/<?= $item['hinh_anh_dai_dien'] ?>" alt="" class="checkout-content__right-product-thumbnail">
                                            <div class="checkout-content__right-product-info">
                                                <p class="checkout-content__right-product-name">
                                                    <?= $item['ten_sp'] ?>
                                                </p>
                                                <div class="checkout-content__right-product-group">
                                                    <p class="checkout-content__right-product-quantity">Số lượng: <?= $item['so_luong'] ?></p>

                                                    <p class="checkout-content__right-product-price"><?= currency_format($item['don_gia_khuyen_mai']) ?></p>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <h6 class="checkout-content__right-title">Phương thức thanh toán</h6>
                                <div class="checkout-content__right-payments">
                                    <form action="" class="products-content-filter__categories-form">
                                        <div class="form-check-pay">
                                            <input class="form-check-input" type="radio" form="form-order" name="payment" value="Ví điện tử MOMO" id="payment1" checked>
                                            <label class="form-check-label" for="payment1">
                                                Ví điện tử MOMO
                                            </label>
                                        </div>
                                        <div class="form-check-pay">
                                            <input class="form-check-input" type="radio" form="form-order" name="payment" value="Thẻ Tín dụng/Ghi nợ" id="payment2">
                                            <label class="form-check-label" for="payment2">
                                                Thẻ Tín dụng/Ghi nợ
                                            </label>
                                        </div>

                                        <div class="form-check-pay">
                                            <input class="form-check-input" type="radio" form="form-order" name="payment" value="Chuyển khoảng ngân hàng" id="payment3">
                                            <label class="form-check-label" for="payment3">
                                                Chuyển khoảng ngân hàng
                                            </label>
                                        </div>

                                        <div class="form-check-pay">
                                            <input class="form-check-input" type="radio" form="form-order" name="payment" value="Thanh toán khi nhận hàng" id="payment4">
                                            <label class="form-check-label" for="payment4">
                                                Thanh toán khi nhận hàng
                                            </label>
                                        </div>
                                    </form>
                                </div>

                                <p class="d-flex align-items-center justify-content-between mt-3 mb-2 text-default">
                                    <span class="fw-bold">Tổng tạm tính</span>
                                    <span class="fw-bold"><?= currency_format($tong_tien_don_hang) ?></span>
                                </p>
                                <p class="d-flex align-items-center justify-content-between mb-2 text-default">
                                    <span class="fw-bold">Phí vận chuyển</span>
                                    <span class="fw-bold">Miễn phí</span>
                                </p>
                                <p class="d-flex align-items-center justify-content-between mb-2 text-default">
                                    <span class="fw-bold">Thành tiền</span>
                                    <span class="fw-bold text-primary fs-5"><?= currency_format($tong_tien_don_hang) ?></span>
                                </p>

                                <div class="text-end">
                                    <button type="submit" name="order-submit" value="submit" form="form-order" class="checkout-content__right-btn">THANH TOÁN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="form-order" action="order_insert.php" method="POST">
                <input type="hidden" name="total" value="<?=$tong_tien_don_hang?>">
            </form>

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

    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

    <!-- Validator -->
    <script src="./assets/js/validatior.js"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script>
        $('form#form-order').submit(function (e) {
            if($('input[name="payment"]:checked').val() == 'Ví điện tử MOMO') {
                $(this).attr('action', './payment/atm_momo.php');
                $(this).attr('enctype', 'application/x-www-form-urlencoded');
            }
        })
    </script>

    <script>
        validator({
            form: '#form-addess',
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
            ],
            onSubmit: function(data) {
                console.log(data);
            }
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
                if (this.value != '') {
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

                document.querySelector('.modal-body #fullname').value = "";
                document.querySelector('.modal-body #email').value = "";
                document.querySelector('.modal-body #phone').value = "";
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