<!DOCTYPE html>
<html>
    <body>
<?php
    # Fetch DB class
    include_once "../classes/DB.php";
    
    # Fetch skill set
    $file = file_get_contents("../temp/skill_set.csv");
    $array = explode(",", $file);
    
  /*  $sql = "SELECT u.username, u.id FROM `users` u LEFT OUTER JOIN `posts` p ON u.id=p.user_id WHERE p.verified=1";
    $candidates = DB::query($sql, NULL);
    foreach ($candidates as $cd) {
      //  $cd_cv_path = "../temp/CVS_TEXT/OCH" . $cd["id"] . " CV.txt";
        $cd_cv_path = "../temp/CVS_TEXT/OCH" . $cd["id"] . " " . $cd["username"] . " CV.txt";
        $cd_cv = strtolower(file_get_contents($cd_cv_path));
        echo "Processing " . $cd["username"] . "'s cv...<br/>";
        $c_skills = "[";
        foreach ($array as $skill) {
            if (strpos($cd_cv, " " . strtolower(ltrim(rtrim($skill))) . " ")) {
                $c_skills .= "\"" . ltrim(rtrim($skill)) . "\", ";
            }
        }
        $c_skills = substr($c_skills, 0, strlen($c_skills) - 2) . "]";
        if ($c_skills == "]") {
            $c_skills = "\"None provided\"";
        }
        $sql = "UPDATE `posts` SET `ind3`=:skills WHERE user_id=:stid";
        echo $sql;
        DB::query($sql, array(":skills" => $c_skills, ":stid" => $cd["id"]));
        echo "Succeeded";
    } 
    */

    
?>       
    </body>
</html>