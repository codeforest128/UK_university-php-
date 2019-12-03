<?php
    $start_from = $offset * $max_results;
    $type = "All";
    $sql = "SELECT itd, firstname, university, course, college, course_end, `availability`, ind1 "
         . "FROM `posts` LIMIT " . $start_from . ", " . $max_results;
    $details = DB::query($sql, array(":start_from" => $start_from));
    foreach($details as $candidate) {
        include "components/candidate.php";
    }
?>
