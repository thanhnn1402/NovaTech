<?php
    session_start();
    define("DATABASE", "id21020306_novatech");
    define("USERNAME", "id21020306_novatech2023");
    define("PASSWORD", "987664Aa@");
    define("LOCALHOST", "localhost");
    $conn = new mysqli(LOCALHOST, USERNAME, PASSWORD, DATABASE);
    
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    } 
    
    date_default_timezone_set('Asia/Ho_Chi_Minh'); 
    $date_current = '';
    $date_current = date("Y-m-d H:i:s");

    $userlogged = isset($_SESSION['user_logged']) ? $_SESSION['user_logged'] : array();
    $adminlogged = isset($_SESSION['admin_logged']) ? $_SESSION['admin_logged'] : array();

    if (!function_exists('currency_format')) {
        function currency_format($number, $suffix = 'đ') {
            if (!empty($number)) {
                return number_format($number, 0, ',', '.') . "{$suffix}";
            }
        }

        function getRandomString($n) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }

            return $randomString;
        }

        // get cart product
        function get_cart($conn, $user_id) {
            $data = array();

            $sql = "SELECT gio_hang.so_luong, san_pham.id, san_pham.ten_sp, san_pham.don_gia_ban, san_pham.phan_tram_khuyen_mai, san_pham.don_gia_khuyen_mai, san_pham.hinh_anh_dai_dien, san_pham.hinh_anh
                    FROM gio_hang, san_pham
                    WHERE gio_hang.id_san_pham = san_pham.id AND gio_hang.id_khach_hang = {$user_id}";

            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            return $data;
        }

        //
        function convert_state($state)
        {
            $state_text = '';

            switch ($state) {
                case 0:
                    $state_text = 'Chờ xác nhận';
                    break;
                case 1:
                    $state_text = 'Đang giao hàng';
                    break;
                case 2:
                    $state_text = 'Đã hoàn thành';
                    break;
                default: $state_text = 'Đã hủy'; break;
            }

            return $state_text;
        }

        function convert_state_payment($state)
        {
            $state_text = '';

            switch ($state) {
                case 0:
                    $state_text = 'Chờ thanh toán';
                    break;
                case 1:
                    $state_text = 'Đã thanh toán';
                    break;
                default: $state_text = 'Đã hủy'; break;
            }

            return $state_text;
        }
    }

?>