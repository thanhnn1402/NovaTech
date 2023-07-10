<?php
require('./admin/config/config.php');

if (!empty($userlogged)) {

    $error = array();

    //
    $sql_address = "SELECT * FROM so_dia_chi WHERE id_khach_hang = {$userlogged['id']}";
    $result_address = $conn->query($sql_address);

    // Thêm địa chỉ
    if (isset($_POST['edit-address-submit']) && $_POST['edit-address-submit'] == 'submit') {
        $id = isset($_POST['id_address']) ? $_POST['id_address'] : '';
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : '';
        $ward = isset($_POST['ward']) ? $_POST['ward'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $check_default = isset($_POST['check-address-default']) ? $_POST['check-address-default'] : '';

        if(empty($fullname)) {
            $error['fullname'] = 'Bạn chưa nhập họ tên!';
        }

        if(empty($email)) {
            $error['email'] = 'Bạn chưa nhập email!';
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // Kiểm tra định dạng email
            $error['email'] = 'Email chưa đúng định dạng!';
        }

        if(empty($phone)) {
            $error['fullname'] = 'Bạn chưa nhập họ tên!';
        }

        if(empty($city)) {
            $error['city'] = 'Bạn chưa chọn Tỉnh/Thành phố!';
        }

        if(empty($district)) {
            $error['district'] = 'Bạn chưa chọn Quận/Huyện!';
        }

        if(empty($ward)) {
            $error['ward'] = 'Bạn chưa chọn Phường/Xã!';
        }

        if(empty($address)) {
            $error['address'] = 'Bạn chưa nhập địa chỉ cụ thể!';
        }

        if(empty($check_default)) {
            $check_default = 1;
        } else {
            $check_default = 0;
        }

        if($result_address->num_rows == 0) {
            $check_default = 0;
        }

        // Nếu không có lỗi
        if(empty($error)) {

            // 
            if($check_default == 0 && $result_address->num_rows > 0) {
                $sql_update_address = "UPDATE `so_dia_chi` SET `trang_thai`='1' WHERE id_khach_hang = {$userlogged['id']}";
                $conn->query($sql_update_address);
            }


            $sql_update_address = "UPDATE `so_dia_chi` SET `ho_ten`=?, `email`=?,`so_dien_thoai`=?, `tinh_tp`=?, `quan_huyen`=?, `phuong_xa`=?, `dia_chi_cu_the`=?, `trang_thai`=? WHERE id = ?";
            $stmt = $conn->prepare($sql_update_address);
            $stmt->bind_param("sssssssii", $fullname, $email, $phone, $city, $district, $ward, $address, $check_default, $id);

            if($stmt->execute()) {
                echo "<script>
                            alert('Cập nhật địa chỉ thành công!');
                    </script>";
                header("location: " . $_SERVER['HTTP_REFERER']);
            } else {
                echo "<script>
                            alert('Có lỗi trong quá trình xử lý, Vui lòng thử lại!');
                    </script>";
            }


        }
    }
} else {
    header('location: ./login.php');
}


?>