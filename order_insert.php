<?php 
    require('./admin/config/config.php');

    if(!empty($userlogged)) {

        if((isset($_POST['order-submit']) && $_POST['order-submit'] == 'submit') || (isset($_GET['payment']) && $_GET['payment'] == 'success')) {

            $products = array();

            $orderId = isset($_SESSION['order']['orderId']) ? $_SESSION['order']['orderId'] : getRandomString(10);

            $products_id = isset($_SESSION['products_id']) ? implode(",", $_SESSION['products_id']) : array();
            $address = isset($_POST['address']) ? $_POST['address'] : $_SESSION['order']['address'];
            $payment = isset($_POST['payment']) ? $_POST['payment'] : $_SESSION['order']['payment']; 
            $total = isset($_POST['total']) ? $_POST['total'] : $_SESSION['order']['total']; 
            $trang_thai_thanh_toan = 0;
            

            if(isset($_GET['payment']) && $_GET['payment'] == 'success') {
                $trang_thai_thanh_toan = 1;
            }

            //
            $sql = "SELECT gio_hang.so_luong, san_pham.id, san_pham.ten_sp, san_pham.don_gia_ban, san_pham.don_gia_khuyen_mai, san_pham.hinh_anh
                        FROM gio_hang, san_pham
                        WHERE gio_hang.id_san_pham = san_pham.id AND gio_hang.id_khach_hang = {$userlogged['id']} AND san_pham.id IN ({$products_id})";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
            }

            //
            $sql_insert_order = "INSERT INTO `don_hang`(`ma_don_hang`, `id_khach_hang`, `dia_chi_nhan_hang`, `hinh_thuc_thanh_toan`, `trang_thai_thanh_toan`, `ngay_lap`, `thanh_tien`) VALUES ('{$orderId}','{$userlogged['id']}','{$address}','{$payment}', '{$trang_thai_thanh_toan}', '{$date_current}','{$total}')";

            if($conn->query($sql_insert_order)) {

                $is_query = false;

                foreach($products as $item) {
                    $tri_gia = $item['so_luong'] * $item['don_gia_khuyen_mai'];

                    $sql_insert_order_detail = "INSERT INTO `chi_tiet_don_hang`(`ma_don_hang`, `id_san_pham`, `so_luong`, `don_gia`, `tri_gia`) VALUES ('{$orderId}','{$item['id']}','{$item['so_luong']}','{$item['don_gia_khuyen_mai']}','{$tri_gia}')";

                    if($conn->query($sql_insert_order_detail)) {
                        $is_query = true;
                    } else {
                        $is_query = false;
                    }
                }

                if($is_query == true) {

                    unset($_SESSION['products_id']);

                    $sql_delete = "DELETE FROM `gio_hang` WHERE id_khach_hang = {$userlogged['id']} AND id_san_pham IN ({$products_id})";

                    $conn->query($sql_delete);

                    if(isset($_SESSION['order'])) {
                        unset($_SESSION['order']);
                    }

                    if(isset($_SESSION['products_id'])) {
                        unset($_SESSION['products_id']);
                    }


                    echo "<script>
                            alert('Đặt hàng thành công!');
                            window.location.href = 'orders.php';
                         </script>";
                }

            }

        }

    } else {
        
    }
