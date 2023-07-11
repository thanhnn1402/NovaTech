<?php
session_start();

// Chuỗi thông tin xác thực
$client_id = '40464060386-a84qioi3qelv8bvm8620ek5ren7hchg7.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://novaitech.000webhostapp.com/google-login/callback.php';

// Lấy mã truy cập từ Google
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Gửi yêu cầu POST để nhận mã truy cập
    $token_url = 'https://accounts.google.com/o/oauth2/token';
    $params = array(
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    );

    $curl = curl_init($token_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    // Phân tích phản hồi JSON
    $token_data = json_decode($response);

    if (isset($token_data->access_token)) {
        $access_token = $token_data->access_token;

        // Gửi yêu cầu GET để lấy thông tin người dùng
        $api_url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$access_token;
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $user_info = json_decode(curl_exec($curl));
        curl_close($curl);

        // Lưu thông tin người dùng vào session hoặc làm bất kỳ xử lý nào khác ở đây
        $_SESSION['user_info'] = $user_info;

        // Chuyển hướng người dùng đến trang chính của bạn
        header('Location: handle-user.php');
        exit();
    }
}
?>
