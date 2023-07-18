<?php
session_start();

// Chuỗi thông tin xác thực
$appId = '1043513456657921';
$appSecret = 'f5f1c397602fa904f03df942933ab3e5';
$redirectUrl = 'https://novaitech.000webhostapp.com/facebook-login/callback.php';
// $redirectUrl = 'http://localhost/NovaTech/facebook-login/callback.php';

// Kiểm tra xem Facebook đã phản hồi với mã truy cập hay chưa
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Gửi yêu cầu POST để nhận mã truy cập
    $tokenUrl = 'https://graph.facebook.com/v14.0/oauth/access_token';
    $params = array(
        'client_id' => $appId,
        'redirect_uri' => $redirectUrl,
        'client_secret' => $appSecret,
        'code' => $code
    );

    $curl = curl_init($tokenUrl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    // Phân tích phản hồi JSON để lấy mã truy cập
    $tokenData = json_decode($response);

    if (isset($tokenData->access_token)) {
        $accessToken = $tokenData->access_token;

        // Gửi yêu cầu GET để lấy thông tin người dùng
        $apiUrl = 'https://graph.facebook.com/v14.0/me?fields=id,name,email&access_token='.$accessToken;
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $userInfo = json_decode(curl_exec($curl));
        curl_close($curl);

        // Lưu thông tin người dùng vào session hoặc làm bất kỳ xử lý nào khác ở đây
        $_SESSION['user_info'] = $userInfo;

        // Chuyển hướng người dùng đến trang chính của bạn
        header('Location: index.php');
        exit();
    }
}
?>
