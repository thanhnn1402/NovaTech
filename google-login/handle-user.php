<?php
    require_once('../admin/config/config.php');

    $user_info = $_SESSION['user_info'];

    $sql = "SELECT * FROM khach_hang WHERE email = '{$user_info->email}'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if($result->num_rows > 0) {

        $_SESSION['user_logged'] = array(
            'id' => $user['id'],
            'username' => $user['ten_tai_khoan'],
            'fullname' => $user['ho_ten'],
            'avatar' => $user['avatar']
        );

        header("location: ../index.php");
    } else {
        $sql  = "INSERT INTO `khach_hang`(`ten_tai_khoan`,`ho_ten`, `email`, `avatar`) VALUES (?, ?, ?, ?)";

        // Tạo đối tượng repared
        $stmt = $conn->prepare($sql);
        
        // Gán giá trị vào các tham số ẩn
        $stmt->bind_param("ssss",$user_info->email, $user_info->name, $user_info->email, $user_info->picture);

        // Thực thi câu truy vấn
        if($stmt->execute()) {
            $sql = "SELECT * FROM khach_hang WHERE email = '{$user_info->email}'";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();

            $_SESSION['user_logged'] = array(
                'id' => $user['id'],
                'fullname' => $user['ho_ten'],
                'avatar' => $user['avatar']
            );
    
            header("location: ../index.php");
        } else {
            
        }
    }
?>