<?php
require('./admin/config/config.php');
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
    <link rel="stylesheet" href="./assets/css/style-contact.css">
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
        <div class="contact-content">
            <div class="container-lg container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Liên hệ với chúng tôi</h3>
                        <p class="mt-4 fs-7 text-default">
                            Chúng tôi luôn sẵn sàng tiếp nhận mọi ý kiến ​đóng góp và giải đáp những yêu cầu của bạn.
                            Hãy liên hệ ngay với chúng tôi
                        </p>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="mb-5">
                            <p class="fs-7 text-default">
                                <span><i class="fa-solid fa-house"></i></span>
                                <span class="ms-1">Trần Quang Diệu, P. An Thới, Q. Bình Thủy, Tp. Cần Thơ</span>
                            </p>
                            <p class="fs-7 text-default">
                                <span><i class="fa-solid fa-phone"></i></span>
                                <span class="ms-1">0966 480 302</span>
                            </p>
                            <p class="fs-7 text-default">
                                <span><i class="fa-solid fa-envelope"></i></span>
                                <span class="ms-1">thanh.ledah@gmail.com</span>
                            </p>
                        </div>
                        <form id="form-contact">
                            <div class="mb-3 form-group">
                                <label for="fullname" class="form-label fs-7 text-default fw-bold">Họ và tên</label>
                                <input type="text" class="form-control fs-7 text-default" id="fullname">
                                <span class="form-text text-danger"></span>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="email" class="form-label fs-7 text-default fw-bold">Email</label>
                                <input type="email" class="form-control fs-7 text-default" id="email" aria-describedby="emailHelp">
                                <span class="form-text text-danger"></span>
                            </div>

                            <div class="mb-3 form-group">
                                <label for="phone" class="form-label fs-7 text-default fw-bold">Điện thoại</label>
                                <input type="text" class="form-control fs-7 text-default" id="phone">
                                <span class="form-text text-danger"></span>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="content" class="form-label fs-7 text-default fw-bold">Nội dung</label>
                                <textarea name="" id="content" cols="30" rows="5" class="form-control fs-7 text-default"></textarea>
                                <span class="form-text text-danger"></span>
                            </div>

                            <button type="submit" class="btn btn-primary">Gửi đi</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2021.8006266313714!2d105.7595544516842!3d10.059077386791872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a087de195ac639%3A0x22ad07f28f0fdc23!2zTmjDoCB0cuG7jSBRdWFuZyBEaeG7h3UgMSAoIE5ow6AgVHLhu40gUXVhbmcgRGnhu4d1IDIs!5e0!3m2!1svi!2s!4v1688893420512!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
            form: '#form-contact',
            errorSelector: '.form-text',
            formGroupSelector: '.form-group',
            rules: [
                validator.isRequired('#fullname', 'Vui lòng nhập trường này'),
                validator.isRequired('#email', 'Vui lòng nhập trường này'),
                validator.isEmail('#email', 'Vui lòng nhập đúng định dạng email'),
                validator.isRequired('#phone', 'Vui lòng nhập trường này'),
                validator.isRequired('#content', 'Vui lòng nhập trường này'),
            ],
            onSubmit: function(data) {
                console.log(data);
            }
        })
    </script>

</body>

</html>