<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    /*home page*/
    $home_url = "http://localhost/ResAPI/";

    $page = isset($_GET['[page']) ? $_GET('page') : 1;

    /*Thiết lập số hồ sơ trên mỗi trang*/
    $records_per_page = 5;

    $from_record_num = ($records_per_page * $page) - $records_per_page;

?>