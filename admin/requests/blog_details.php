<?php
    include_once "../../../classes/DB.php";
    $t1 = preg_replace('/\s/', '', $_GET["key"]);
    $t2 = preg_replace('/\s/', '', $_COOKIE["admin_ajax_ver"]);
    if ($t1 == $t2) {
        $blog_id = $_GET["id"];
        $sql = "SELECT * FROM `blogs` WHERE `id`=:id";
        $blog_details = DB::query($sql, array(":id" => $blog_id))[0];
        
        $response = "{"
                  .     "\"id\": \"" . $blog_id . "\", "
                  .     "\"title\": \"" . $blog_details["title"] . "\", "
                  .     "\"b_descr\": \"" . $blog_details["brief_descr"] . "\", "
                  .     "\"body\": \"" . $blog_details["body"] . "\", "
                  .     "\"s_date\": \"" . $blog_details["scheduled_date"] . "\", "
                  .     "\"author\": \"" . $blog_details["author"] . "\", "
                  .     "\"tags\": " . $blog_details["tags"]
                  . "}";
        
        echo $response;
    }
?>