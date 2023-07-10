<?php 
    $categories = array(); 
    $cart_products = array();
    $sql_categories = "SELECT * FROM danh_muc";
    $result_categories = $conn->query($sql_categories);


    if($result_categories->num_rows > 0) {
        while($row = $result_categories->fetch_assoc()) {
            $categories[] = $row;
        }
    }


    $tong_san_pham = 0;
    $tong_tien = 0;
    if(isset($userlogged) && !empty($userlogged)) {
        $cart_products = get_cart($conn, $userlogged['id']);


        foreach($cart_products as $item) {
            $tong_san_pham++; 
            $tong_tien += (($item['so_luong'] * $item['don_gia_khuyen_mai']));
        }

        if(stripos($userlogged['avatar'], 'http') == '') {
            $userlogged['avatar'] = "./storage/uploads/img/" . $userlogged['avatar'];
        }
    }

    
?>

<header id="header" class="header">
    <!-- Start header top bar -->
    <div class="header-topbar">
        <div class="container-lg container-fluid-lg">
            <div class="row">
                <div class="col-md-9">
                    <div class="header-topbar__left">
                        <p class="header-topbar__left-item">
                            <i class="fa-solid fa-phone header-topbar__left-icon"></i>
                            0966 480 302
                        </p>
                        <p class="header-topbar__left-item">
                            <i class="fa-solid fa-envelope header-topbar__left-icon"></i>
                            nnthanh122002@gmail.com
                        </p>
                        <p class="header-topbar__left-item">
                            <i class="fa-solid fa-location-dot header-topbar__left-icon"></i>
                            Trần Quang Diệu, P. An Thới, Q. Bình Thủy, Tp. Cần Thơ
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="header-topbar__right">
                        <a href="" class="header-topbar__right-link" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="" class="header-topbar__right-link" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Twitter">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="" class="header-topbar__right-link" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="" class="header-topbar__right-link" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Youtube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End header top bar -->

    <!-- Start header main -->
    <div class="header-main">
        <div class="container-lg container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <a href="./index.php" class="header-main-logo">
                        <img src="./assets/img/logo.png" alt="LOGO" class="header-main-logo__img">
                        <h6 class="header-main-logo__text">NOVATECH</h6>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="header-main-search">
                        <form action="" class="header-main-search__form">
                            <input type="text" placeholder="Nhập từ khóa cần tìm" class="header-main-search__input">
                            <button type="submit" class="header-main-search__btn-submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button> 

                            <div class="header-main-search-history">
                                <div class="header-main-search-history__heading">
                                    <h6 class="header-main-search-history__title">
                                        LỊCH SỬ TÌM KIẾM
                                    </h6>
                                    <a href="" class="header-main-search-history__delete">Xóa lịch sử</a>
                                </div>
                                <div class="header-main-search-history__body">
                                    <ul class="header-main-search-history__list">
                                        <li class="header-main-search-history__item">
                                            <a href="" class="header-main-search-history__link">
                                                <i class="fa-regular fa-clock"></i>
                                                Camera
                                            </a>
                                        </li>

                                        <li class="header-main-search-history__item">
                                            <a href="" class="header-main-search-history__link">
                                                <i class="fa-regular fa-clock"></i>
                                                Camera
                                            </a>
                                        </li>

                                        <li class="header-main-search-history__item">
                                            <a href="" class="header-main-search-history__link">
                                                <i class="fa-regular fa-clock"></i>
                                                Camera
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5">
                    <div class="header-main-menu">
                        <div class="header-main-menu__item header-notify">
                            <a href="#" class="header-main-menu__link">
                                <span class="header-main-menu__icon">
                                    <i class="fa-regular fa-bell"></i>
                                </span>
                                
                                <span class="badge"> </span>
                            </a>

                            <div class="header-notify-menusub">
                                <h6 class="header-notify-menusub__title">THÔNG BÁO</h6>
                                <ul class="header-notify-menusub__list">
                                    <li class="header-notify-menusub__item">
                                        <a href="" class="header-notify-menusub__link">
                                            <span class="header-notify-menusub__icon">
                                                <i class="fa-solid fa-gift"></i>
                                            </span>
                                            <div>
                                                <p class="header-notify-menusub__name">Sản phẩm khuyến mãi</p>
                                                <p class="header-notify-menusub__des">Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản</p>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="header-notify-menusub__item">
                                        <a href="" class="header-notify-menusub__link">
                                            <span class="header-notify-menusub__icon">
                                                <i class="fa-solid fa-gift"></i>
                                            </span>
                                            <div>
                                                <p class="header-notify-menusub__name">Sản phẩm khuyến mãi</p>
                                                <p class="header-notify-menusub__des">Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản</p>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="header-notify-menusub__item">
                                        <a href="" class="header-notify-menusub__link">
                                            <span class="header-notify-menusub__icon">
                                                <i class="fa-solid fa-gift"></i>
                                            </span>
                                            <div>
                                                <p class="header-notify-menusub__name">Sản phẩm khuyến mãi</p>
                                                <p class="header-notify-menusub__des">Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="header-notify-menusub__footer">
                                    <a href="" class="header-notify-menusub__footer-link">Xem tất cả thông báo</a>
                                </div>
                            </div>
                        </div>

                        <div class="header-main-menu__item header-cart">
                            <a href="#" class="header-main-menu__link">
                                <span class="header-main-menu__icon">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </span>
                                <span class="sum-cart-product">
                                    (<?=$tong_san_pham?>)
                                </span>
                            </a>

                            <div class="header-cart-menusub">
                                <?php if(!empty($cart_products)) { ?>

                                    <h6 class="header-cart-menusub__title">SẢN PHẨM MỚI THÊM</h6>
                                    <ul class="header-cart-menusub__list">
                                        <?php foreach ($cart_products as $item) { 
                                                $arr_img = explode("||", $item['hinh_anh']); 
                                        ?>
                                            <li class="header-cart-menusub__item">
                                                <a href="" class="header-cart-menusub__link">
                                                    <img src="./storage/uploads/img/<?=$item['hinh_anh_dai_dien']?>" alt="" class="header-cart-menusub__thumbnail">
                                                    <div>
                                                        <p class="header-cart-menusub__name"><?=$item['ten_sp']?></p>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <span class="header-cart-menusub__quantity">x<?=$item['so_luong']?></span>
                                                            <span class="header-cart-menusub__price"><?=currency_format($item['don_gia_khuyen_mai'])?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="header-cart-menusub__footer">
                                        <div class="header-cart-menusub__footer-heading">
                                            <span>Tổng tiền</span>
                                            <span class="price-total-cart"><?=currency_format($tong_tien)?></span>
                                        </div>
                                        <a href="./cart.php" class="header-cart-menusub__footer-link">Xem giỏ hàng</a>
                                    </div>

                                <?php } else { ?>
                                    
                                    <div class="text-center" style="padding: 100px 0">
                                        <img src="./assets/img/order-empty.png" alt="" class="w-50">
                                        <p class="mt-4">Giỏ hàng chưa có sản phẩm nào</p>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="header-main-menu__item header-main-menu__user">
                            <?php if(empty($userlogged)) {?>
                                    <a href="./login.php" class="header-main-menu__link">
                                        <span class="header-main-menu__icon">
                                            <i class="fa-regular fa-circle-user"></i>
                                        </span>
                                        Đăng nhập
                                    </a>
                            <?php } else { ?>
                                <p class="header-main-menu__user-info">
                                    <img src="<?=$userlogged['avatar']?>" alt="" class="header-main-menu__user-avatar">
                                    <span class="header-main-menu__user-name text-truncate"><?=$userlogged['fullname']?></span>
                                </p>

                                <div class="header-main-menu__user-menu">
                                    <div class="header-main-menu__user-menu-header">
                                        <img src="<?=$userlogged['avatar']?>" alt="">
                                        <span><?=$userlogged['fullname']?></span>
                                    </div>
                                    <div class="header-main-menu__user-menu-body">
                                        <div class="header-main-menu__user-menu-item">
                                            <a href="./profile.php" class="">
                                                <i class="fa-regular fa-user"></i>
                                                Thông tin tài khoản
                                            </a>
                                        </div>
                                        <div class="header-main-menu__user-menu-item">
                                            <a href="./orders.php" class="">
                                                <i class="fa-solid fa-clipboard-list"></i>
                                                Quản lý đơn hàng
                                            </a>
                                        </div>
                                        <div class="header-main-menu__user-menu-item">
                                            <a href="./notify.php" class="">
                                                <i class="fa-regular fa-bell"></i>
                                                Thông báo
                                            </a>
                                        </div>
                                        <div class="header-main-menu__user-menu-item">
                                            <a href="./change-password.php" class="">
                                                <i class="fa-solid fa-gear"></i>
                                                Đổi mật khẩu
                                            </a>
                                        </div>
                                        <div class="header-main-menu__user-menu-item">
                                            <a href="./address.php" class="">
                                                <i class="fa-solid fa-map-location-dot"></i>
                                                Địa chỉ
                                            </a>
                                        </div>
                                    </div>
                                    <div class="header-main-menu__user-menu-footer">
                                        <a href="logout.php"><i class="fa-solid fa-power-off"></i> Đăng xuất</a>
                                    </div>
                                </div>
                            <?php }?>

                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End header main -->

    <!-- Start header navbar -->
    <div class="header-navbar">
        <div class="container-lg container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="header-navbar__list">
                        <li class="header-navbar__item">
                            <a href="./index.php" class="header-navbar__link">
                                TRANG CHỦ
                            </a>
                        </li>

                        <li class="header-navbar__item">
                            <a href="./about.php" class="header-navbar__link">
                                GIỚI THIỆU
                            </a>
                        </li>

                        <li class="header-navbar__item">
                            <a href="./products.php" class="header-navbar__link">
                                SẢN PHẨM
                            </a>
                        </li>

                        <li class="header-navbar__item">
                            <a href="./contact.php" class="header-navbar__link">
                                LIÊN HỆ
                            </a>
                        </li>

                        <li class="header-navbar__item">
                            <a href="./news.php" class="header-navbar__link">
                                TIN TỨC
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End header navbar -->

</header>

<header class="header-mobile">
    <div class="topbar-mobile"></div>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <a href="" class="header-mobile__logo">
                    <img src="./assets/img/logo.png" alt="LOGO">
                    <p class="text-primary">NOVATECH</p>
                </a>
            </div>

            <div class="col-6 d-flex align-items-center justify-content-end">
                <button class="btn btn-shopping">
                    <i class="fa-solid fa-basket-shopping"></i>
                </button>
                <button class="btn"><i class="fa-regular fa-user"></i></button>
                <button class="btn"><i class="fa-solid fa-bars"></i></button>
            </div>

            <div class="col-12">
                <form action="" class="header-main-search__form">
                    <input type="text" placeholder="Nhập từ khóa cần tìm" class="header-main-search__input">
                    <button type="submit" class="header-main-search__btn-submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <div class="header-main-search-history">
                        <div class="header-main-search-history__heading">
                            <h6 class="header-main-search-history__title">
                                LỊCH SỬ TÌM KIẾM
                            </h6>
                            <a href="" class="header-main-search-history__delete">Xóa lịch sử</a>
                        </div>
                        <div class="header-main-search-history__body">
                            <ul class="header-main-search-history__list">
                                <li class="header-main-search-history__item">
                                    <a href="" class="header-main-search-history__link">
                                        <i class="fa-regular fa-clock"></i>
                                        Camera
                                    </a>
                                </li>

                                <li class="header-main-search-history__item">
                                    <a href="" class="header-main-search-history__link">
                                        <i class="fa-regular fa-clock"></i>
                                        Camera
                                    </a>
                                </li>

                                <li class="header-main-search-history__item">
                                    <a href="" class="header-main-search-history__link">
                                        <i class="fa-regular fa-clock"></i>
                                        Camera
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>       
</header>