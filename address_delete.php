<?php
require('./admin/config/config.php');

if (!empty($userlogged)) {

    $id = isset($_GET['id']) ? trim($_GET['id']) : '';

    if(!empty($id)) {
        $stmt_delete = $conn->prepare("DELETE FROM `so_dia_chi` WHERE id = ?");
        $stmt_delete->bind_param("i", $id);

        if($stmt_delete->execute()) {
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
     }

} else {
    header('location: ./login.php');
}


?>