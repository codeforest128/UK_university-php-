<?php
    $filters = array();
    unset($_SESSION["filters"]);
    if (isset($_POST["search-type"])) {
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

        $filters["smart"] = 0;

        // Initialise filters for use below
        $filters["course"] = array();
        $filters["grade"] = array();
        $filters["sector"] = array();
        $filters["gradyear"] = array();
        // Access course, grade, sector and graduation year filters
        foreach ($_POST as $key => $value) {
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
            } else if (preg_match("/^skill-/", $key) == 1) {
                $key = substr($key, strpos($key, "-") + 1);
                $filters["skill"][$key] = $value;
            }
             else if (preg_match("/^location-/", $key) == 1) {
                $key = substr($key, strpos($key, "-") + 1);
                $filters["location"][$key] = $value;
            }
            else if (preg_match("/^qualification-/", $key) == 1) {
                $key = substr($key, strpos($key, "-") + 1);
                $filters["qualification"][$key] = $value;
            }
            else if (preg_match("/^university-/", $key) == 1) {
                $key = substr($key, strpos($key, "-") + 1);
                $filters["university"][$key] = $value;
            }

            
        }
        if ($_POST["search-type"] == "smart") {
            $filters["smart"] = 1;
            $keywords = explode(",", $_POST["keywords"]);
            for ($i = 0; $i < sizeof($keywords); $i++) {
                $keywords[$i] = ltrim(rtrim($keywords[$i]));
            }
            if (!($keywords[0] == "" && sizeof($keywords) == 1)) {
                $filters["keywords"] = $keywords;
            }
            $filters["des_amt"] = $_POST["amount_required"];
		}
        // } else if($_POST["search-type"] == "basic") {
			// $filters["basic"] = 1;
            // $keywords = explode(",", $_POST["keywords"]);
            // for ($i = 0; $i < sizeof($keywords); $i++) {
                // $keywords[$i] = ltrim(rtrim($keywords[$i]));
            // }
            // if (!($keywords[0] == "" && sizeof($keywords) == 1)) {
                // $filters["keywords"] = $keywords;
            // }
            // $filters["des_amt"] = $_POST["amount_required"];
		// }
        $_SESSION["filters"] = $filters;
    }
?>