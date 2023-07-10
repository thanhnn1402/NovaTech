<?php 
    require('./admin/config/config.php');

    if(!empty($userlogged)) {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $quantity = 1;

        if(!empty($id)) {
            $stmt = $conn->prepare("SELECT * FROM gio_hang WHERE id_khach_hang = ? AND id_san_pham = ?");
            $stmt->bind_param("ii", $userlogged['id'], $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $cart_product = $result->fetch_assoc();

                $cart_product['so_luong'] += $quantity;

                $stmt_update = $conn->prepare("UPDATE `gio_hang` SET `so_luong`= ? WHERE id_khach_hang = ? AND id_san_pham = ?");
                $stmt_update->bind_param("iii",$cart_product['so_luong'], $userlogged['id'], $id);

                if($stmt_update->execute()) {
                    $cart_products = get_cart($conn, $userlogged['id']);

                    if(isset($_GET['muangay'])) {
                        $_SESSION['products_id'] = array($id);

                        header("location: checkout.php");
                    }

                    echo json_encode(array("title" => "Thành công", "message" => "Đã thêm sản phẩm vào giỏ hàng!", "type" => "success", "cart_products" => $cart_products));
                } else {
                    echo json_encode(array("title" => "Thất bại", "message" => "Đã xảy lỗi, vui lòng thử lại sau ít phút!", "type" => "error"));
                }
            } else {
                $stmt_insert = $conn->prepare("INSERT INTO `gio_hang`(`id_khach_hang`, `id_san_pham`, `so_luong`) VALUES (? ,? ,?)");
                $stmt_insert->bind_param("iii", $userlogged['id'], $id, $quantity);

                if($stmt_insert->execute()) {
                    $cart_products = get_cart($conn, $userlogged['id']);

                    if(isset($_GET['muangay'])) {
                        $_SESSION['products_id'] = array($id);

                        header("location: checkout.php");
                    }

                    echo json_encode(array("title" => "Thành công", "message" => "Đã thêm sản phẩm vào giỏ hàng!", "type" => "success", "cart_products" => $cart_products));
                } else {
                    echo json_encode(array("title" => "Thất bại", "message" => "Đã xảy lỗi, vui lòng thử lại sau ít phút!", "type" => "error"));
                }
            }
        }

    } else {
        $_SESSION['previous-page'] = $_SERVER['HTTP_REFERER'];

        if(isset($_GET['add_cart'])) {
            echo json_encode(array("redirect" => "true"));
        } else {
            header("location: login.php"); 
        }

    }

?>