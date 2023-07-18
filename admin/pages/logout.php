<?php 
    require("../config/config.php");
    if(isset($_SESSION['admin_logged'])) {
        unset($_SESSION['admin_logged']);

        header('location: ../../index.php');
    }
?>