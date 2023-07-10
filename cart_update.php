<?php 
    require('./admin/config/config.php');

    if(!empty($userlogged)) {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';

        if(!empty($id)) {
            
            $stmt = $conn->prepare("SELECT * FROM gio_hang WHERE id_khach_hang = ? AND id_san_pham = ?");
            $stmt->bind_param("ii", $userlogged['id'], $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $cart_product = $result->fetch_assoc();

                $cart_product['so_luong'] += $quantity;

                if($cart_product['so_luong'] <= 0) {
                    $cart_product['so_luong'] = 1;
                }

                $stmt_update = $conn->prepare("UPDATE `gio_hang` SET `so_luong`= ? WHERE id_khach_hang = ? AND id_san_pham = ?");
                $stmt_update->bind_param("iii",$cart_product['so_luong'], $userlogged['id'], $id);

                if($stmt_update->execute()) {
                    $cart_products = get_cart($conn, $userlogged['id']);

                    echo json_encode(array("title" => "Thành công", "message" => "Đã xóa sản phẩm khỏi giỏ hàng!", "type" => "success", "cart_products" => $cart_products));
                } else {
                    echo json_encode(array("title" => "Thất bại", "message" => "Đã xảy lỗi, vui lòng thử lại sau ít phút!", "type" => "error"));
                }
            }
        }

    }

?>