<?php 
    require('./admin/config/config.php');

    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $products = array();
    $list_search_history = array();

    if(isset($userlogged['id'])) {
        $list_search_history = get_search_history($conn, $userlogged['id']);
    }

    if(!empty($keyword)) {
        $sql = "SELECT san_pham.id, ten_sp, ten_loai 
            FROM san_pham INNER JOIN loai_hang ON san_pham.id_loai_hang = loai_hang.id 
            WHERE ten_sp LIKE '%{$keyword}%' OR ten_loai LIKE '%{$keyword}%'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            echo json_encode(array("products" => $products));
        } else {
            echo json_encode(array("message" => "Không tìm thấy sản phẩm"));
        }
    } else {
        echo json_encode(array("list" => $list_search_history));
    }
?>