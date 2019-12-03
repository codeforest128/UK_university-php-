<?php
    $filters = array();
    if (isset($_POST["search-type"])) {
        if ($_POST["search-type"] == "basic") {
            // Check the opportunity type
            $crr = FALSE;
            $intrn = FALSE;
            if (isset($_POST["career"])) {
                $crr = TRUE;
            } 
            if (isset($_POST["intern"])) {
                $intrn = TRUE;
            }
            if ($crr != $intrn) {
                if ($crr) {
                    $filters["o-type"] = "Career";
                } else {
                    $filters["o-type"] = "Internship";
                }
            }

            // Initialise filters for use below
            $filters["course"] = array();
            $filters["grade"] = array();
            $filters["sector"] = array();
            $filters["gradyear"] = array();
            // Access course, grade, sector and graduation year filters
            foreach ($_POST as $key => $value) {
                if (preg_match("/^skill-/", $key) == 1) {
                    $key = substr($key, strpos($key, "-") + 1);
                    $filters["skill"][$key] = $value;
                }
                if (preg_match("/^course-/", $key) == 1) {
                    $key = substr($key, strpos($key, "-") + 1);
                    $filters["course"][$key] = $value;
                } else if (preg_match("/^grade-/", $key)) {
                    $key = substr($key, strpos($key, "-") + 1);
                    $filters["grade"][$key] = $value;
                } else if (preg_match("/^sector-/", $key)) {
                    $key = substr($key, strpos($key, "-") + 1);
                    $filters["sector"][$key] = $value;
                } else if (preg_match("/^gradyear-/", $key)) {
                    $key = substr($key, strpos($key, "-") + 1);
                    $filters["gradyear"][$key] = $value;
                }
            }
        } else if ($_POST["search-type"] == "smart") {

        } else {
            header("Refresh:0");
        }
    }
    $_SESSION["filters"] = $filters;
?>