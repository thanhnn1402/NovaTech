<?php 
    function result($result_code) {
        $message = '';
        switch($result_code) {
            case 1001: $message = 'Giao dịch thanh toán thất bại do tài khoản người dùng không đủ tiền.'; break;
            case 1002: $message = 'Giao dịch bị từ chối do nhà phát hành tài khoản thanh toán.'; break;
            case 1003: $message = 'Giao dịch bị đã bị hủy.'; break;
            case 1004: $message = 'Giao dịch thất bại do số tiền thanh toán vượt quá hạn mức thanh toán của người dùng.'; break;
            case 1005: $message = 'Giao dịch thất bại do url hoặc QR code đã hết hạn.'; break;
            case 1006: $message = 'Giao dịch thất bại do người dùng đã từ chối xác nhận thanh toán.'; break;
            case 1007: $message = 'Giao dịch bị từ chối vì tài khoản không tồn tại hoặc đang ở trạng thái ngưng hoạt động.'; break;
        }

        return $message;
    }

    if(isset($_GET) && !empty($_GET)) {
        $resultPayment = result($_GET['resultCode']);


        if(empty($resultPayment)) {
            header('location: ../order_insert.php?payment=success');
        } else {
            header('location: ../checkout.php?payment=unsuccessful&message=' . $resultPayment);
        }
    }
?>