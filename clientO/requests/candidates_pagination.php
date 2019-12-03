<?php
    include_once "../../../classes/DB.php";
    include_once "../../../classes/SearchEngine.php";
    // Gather parameters from get request
    if ($_GET["key"] == $_COOKIE["ajax_ver"]) {
        if (isset($_GET["offset"]) && isset($_GET["max"])) {
            if (isset($_GET["type"])) {
                $sel_type = $_GET["type"];
            } else {
                $sel_type = "ALL";
            }
            $off = $_GET["offset"];
            $max = $_GET["max"];
            $start_from = $off * $max;
            $filter = $_GET["filters"] == "true";
            $response;
            switch($sel_type) {
                case "SHRT":
                    $response = SE::request_short($max, $start_from, $filter);
                    break;
                case "CNTCT":
                    $response = SE::request_contacts($max, $start_from, $filter);
                    break;
                case "SEL":
                    $response = SE::request_list(json_decode($_GET["ids"]));
                    break;
                default:
                    $response = SE::request_all($max, $start_from, $filter);
                    break;
            }
            echo $response;
        }
    }
?>