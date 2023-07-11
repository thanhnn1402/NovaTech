<?php
require('./admin/config/config.php');

if (!empty($userlogged)) {

    if(isset($_POST['submit-checkout']) && $_POST['submit-checkout'] == 'submit') {
        $products_id = isset($_POST['product-id']) ? $_POST['product-id'] : array();

        if(!empty($products_id)) {
            $_SESSION['products_id'] = $products_id;

            header("location: checkout.php");
        }
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
    <title>NovaTech</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style-cart-product.css">
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
            <div class="cart-content">
                <div class="container-lg container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Giỏ hàng</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <table class="table align-middle cart-table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input class="form-check-input" type="checkbox" id="checkbox-all" value="" checked>
                                        </th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                        <th scope="col">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_products as $item) {
                                        $total = $item['so_luong'] * $item['don_gia_khuyen_mai'];
                                    ?>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox" form="form-checkout" name="product-id[]" value="<?= $item['id'] ?>" checked>
                                            </td>
                                            <td>
                                                <div class="cart-product__group">
                                                    <img src="./storage/uploads/img/<?= $item['hinh_anh_dai_dien'] ?>" alt="" class="cart-product__img">
                                                    <span class="cart-product__name">
                                                        <?= $item['ten_sp'] ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="cart-product__price"><?= currency_format($item['don_gia_khuyen_mai'])?></td>
                                            <td>
                                                <div class="cart-product__quantity">
                                                    <button class="cart-product__btn-minius" data-id="<?= $item['id'] ?>">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <input type="text" min="1" max="1000" value="<?= $item['so_luong'] ?>" name="quantity[]" form="form-checkout" class="cart-product__quantity-input">
                                                    <button class="cart-product__btn-plus" data-id="<?= $item['id'] ?>">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="cart-product__total"><?= currency_format($total) ?></td>
                                            <td>
                                                <button type="button" class="cart-product__btn-delete" data-id="<?= $item['id'] ?>">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <form action="" class="cart-product__form-voucher">
                                <h6 class="cart-product__form-voucher-title">VOUCHER</h6>
                                <div class="cart-product__form-voucher-body">
                                    <input type="text" placeholder="Nhập mã khuyến mãi">
                                    <button type="submit">Áp dụng</button>
                                </div>
                            </form>

                            <div class="cart-product__checkout">
                                <h5>Thanh toán</h5>
                                <p class="mt-4">
                                    <span>Tạm tính</span>
                                    <span class="provisional-total">0đ</span>
                                </p>

                                <p>
                                    <span>Thành tiền</span>
                                    <span class="text-primary fw-bold total-price">0đ</span>
                                </p>

                                <button type="submit" name="submit-checkout" value="submit" class="btn btn-primary cart-product__checkout-btn" form="form-checkout"> TIẾP
                                    TỤC </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="" method="POST" id="form-checkout"></form>


        <!-- End main content -->

        <!-- Start footer -->
        <?php
            require('./partials/footer.php')
        ?>
        <!-- End footer -->

        <div id="toast-container"></div>
    </div>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <!-- Bootstrap Bundle JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <script>
        $(document).ready(function() {

            renderSumTotalCart();

            // Tăng / giảm số lượng sản phẩm trong giỏ hàng 
            const btnsQuantity = $('.cart-product__quantity button');
            const btnDelete = $('.cart-product__btn-delete');

            btnsQuantity.click(function() {
                const btn = $(this);
                const input = btn.parent().find('input[name="quantity[]"]');
                const price = Number.parseInt(btn.parent().parent().parent().find('.cart-product__price').text().replaceAll('.', ''));
                const total = btn.parent().parent().parent().find('.cart-product__total');
                const oldValue = parseInt(input.val());
                let newValue = 0;

                if (btn.hasClass('cart-product__btn-plus')) {

                    $.ajax({
                        url: 'cart_update.php',
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            id: btn.attr('data-id'),
                            quantity: 1,
                        },
                    }).done(function (response) {
                        renderCartHeader(response.cart_products)
                    })

                    newValue = oldValue >= 1000 ? 1000 : oldValue + 1;


                } else {
                    $.ajax({
                        url: 'cart_update.php',
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            id: btn.attr('data-id'),
                            quantity: -1,
                        },
                    }).done(function (response) {
                        renderCartHeader(response.cart_products)
                    })

                    newValue = oldValue <= 1 ? 1 : oldValue - 1;
                }

                $(input).prop('value', parseInt(newValue));

                $(total).text(VND.format(newValue * price));

                renderSumTotalCart();
            });



            $('.cart-product__btn-delete').click(function(e) {
                const id = $(this).attr('data-id');
                
                $.ajax({
                        url: 'cart_delete.php',
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            id: id
                        },
                    }).done(function (response) {
                        toast({
                            message: response.message,
                            type: response.type,
                            duration: 3000
                        });

                        renderCartHeader(response.cart_products)
                    })

                    $(this).parent().parent().remove();

                    renderSumTotalCart();
            })


            function renderCheckAllSubmitBtn() {
                const checkedCount = $('input[name="product-id[]"]:checked').length;

                if (checkedCount > 0) {
                    $('.cart-product__checkout-btn').removeClass('disabled');
                } else {
                    $('.cart-product__checkout-btn').addClass('disabled');
                }
            }

            // Chọn tất cả sản phẩm
            const checkboxAll = $('#checkbox-all');
            const productItem = $('input[name="product-id[]"]');


            checkboxAll.change(function() {
                const checked = $(this).prop('checked');
                productItem.prop('checked', checked);

                renderCheckAllSubmitBtn();
                renderSumTotalCart();
            })

            productItem.change(function() {
                const isCheckAll = productItem.length === $('input[name="product-id[]"]:checked').length;

                checkboxAll.prop('checked', isCheckAll);

                renderCheckAllSubmitBtn();
                renderSumTotalCart();
            });
        });





        // 
        function renderSumTotalCart() {
            const checkedProduct = document.querySelectorAll('input[name="product-id[]"]:checked');
            const provisionalTotalPrice = document.querySelector('.provisional-total');
            const sumTotalPrice = document.querySelector('.total-price');

            let total = 0;

            checkedProduct.forEach((item, index) => {
                const parent = item.parentElement.parentElement;

                const productPrice = Number.parseInt(parent.querySelector('.cart-product__total').innerText.replaceAll('.', ''));

                total += productPrice;
            });


            provisionalTotalPrice.innerText = `${VND.format(total)}`;
            sumTotalPrice.innerText = `${VND.format(total)}`;
        }
    </script>
</body>

</html>