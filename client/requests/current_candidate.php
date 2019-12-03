<?php
    include_once "../../../classes/DB.php";
    $t1 = preg_replace('/\s/', '', $_GET["key"]);
    $t2 = preg_replace('/\s/', '', $_COOKIE["ajax_ver"]);
    if ($t1 == $t2) {
        if (isset($_GET["id"])) {
            # Error reporting settings (comment to turn on)
            error_reporting(0);

            # Get the general details
            $selected_candidate_id = $_GET["id"];
            $sql = "SELECT firstname, lastname, university, course, college, course_end, `availability`, `type`, school, qualification, grade, ind1, ind2, ind3, descr "
                 . "FROM `posts` WHERE user_id = :sid";
            $selected_candidate_details = DB::query($sql, array(":sid" => $selected_candidate_id))[0];

            # Get the candidates cv
            $sql = "SELECT `file_name` FROM `images` "
                 . "WHERE userid = :id";
            $f_name = DB::query($sql, array(":id" => $selected_candidate_id))[0]["file_name"];
            $cv_path = "../temp/uploads/" . $f_name;

            # Get current client id
            $token = $_COOKIE['SNID'];
            $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];

            # Check if the current candidate is on client's short list
            $sql = "SELECT COUNT(p.user_id) AS amount FROM "
                 . "`short_list` sl LEFT OUTER JOIN `posts` p "
                 . "ON sl.student_id=p.user_id "
                 . "WHERE sl.client_id = :cid "
                 . "AND p.user_id = :stid";
            $on_sl = !(DB::query($sql, array(":cid" => $client_id, ":stid" => $selected_candidate_id))[0]["amount"] == 0);

            # Check if the current candidate is on client's contact list
            $sql = "SELECT COUNT(p.user_id) AS amount FROM "
                 . "`contacts` c LEFT OUTER JOIN `posts` p "
                 . "ON c.student_id=p.user_id "
                 . "WHERE c.client_id = :cid "
                 . "AND p.user_id = :stid";
            $on_con = !(DB::query($sql, array(":cid" => $client_id, ":stid" => $selected_candidate_id))[0]["amount"] == 0);

            # If they are on contact list fetch those details too
            $contact_details = 0;
            if ($on_con) {
                $sql = "SELECT p.mob, u.email FROM `posts` p "               
                     . "LEFT OUTER JOIN `users` u "
                     . "ON p.user_id=u.id "
                     . "WHERE p.user_id = :sid";
                $contact_details = DB::query($sql, array(":sid" => $selected_candidate_id))[0];
            }

            # Begin to assemble response
            $res = "<div class=\"viewobjecttop\">"
                 #     Candidate avatar
                 .     "<div class=\"objectleft\">";
            # Determine university - In case data isn't there should be Oxford
            if (sizeof($selected_candidate_details["university"]) == 0) {
                $s_uni = "University of Oxford";
            } else {
                $s_uni = $selected_candidate_details["university"];
            }
            switch($s_uni) {
                case "University of Oxford":
                    $uni_temp = "oxf";
                    break;
                case "University of Cambridge":
                    $uni_temp = "cmb";
                    break;
                case "University of Durham":
                    $uni_temp = "dhm";
                    break;
            }
            $res .=        "<div class=\"viewcircle uni-avatar-" . $uni_temp . "\" id=\"avatar_name\">"
                 .             "<span><i class=\"fas fa-user-graduate\"></i></span>"
                 .         "</div>"
                 .     "</div>"
                 #     Candidate overview
                 .     "<div class=\"objectright\">";
            if ($on_con) {
            $res .=        "<span class=\"specific_contacted_container\"><i class=\"fas fa-address-book\"></i></span>";
            }
            $res .=        "<p class=\"candname\">"
                 .         $selected_candidate_details["firstname"] . " from " . $s_uni
                 .         "</p>"
                 .         "<p class=\"broaddetails\">"
                 .              $selected_candidate_details["course"]
                 .         "</p>"
                 .         "<p class=\"broaddetails\">"
                 .              $selected_candidate_details["college"]
                 .         "</p>"
                 .         "<input type=\"hidden\" name=\"lastestid\" id=\"lastestid\" value=\"".$_GET['id']."\">"
                           # Basic actions
                 .         "<button data-toggle=\"modal\" data-target=\"#individual_email\" data-backdrop=\"static\" class=\"sendemail-small\" id=\"myBtn2\""
                 ."onclick=\"email_setup1(this,'compose')\">Email</button>"
                 .         "<button style='margin-left: 5%;' class=\"sendemail-small"; 
            # Sort out whether they've been shortlisted
            if ($on_sl) {
                $res .= " shortlisted";
            }
            $res .= "\" onclick=\"shortlist_candidate()\"";
            if ($on_sl) {
                $res .= " disabled";
            }
            $res .= ">Shortlist</button>"
                 .     "</div>"
                 . "</div>";
            # Assemble middle section of candidate profile
            $res .="<div class=\"viewobjectmiddle\">"
                 .     "<div class=\"objectleft\">"
                 .         "<center class=\"skills\">Name:</center>"
                 .         "<center class=\"skills\">Grad year:</center>"
                 .         "<center class=\"skills\">Availability:</center>"
                 .     "</div>"
                 .     "<div class=\"objectright\">"
                 .         "<p class=\"interestlist\">"
                 .              $selected_candidate_details["firstname"]."  "
                 .              $selected_candidate_details["lastname"]
                 .         "</p>"
                 .         "<p class=\"interestlist\">"
                 .              $selected_candidate_details["course_end"]
                 .         "</p>"
                 .         "<p class=\"interestlist\">From " 
                 .              $selected_candidate_details["availability"] 
                 .         "</p>"
                 .     "</div>"
                 . "</div>";
            # Assemble bottom section of candidate profile
            $res .="<div class=\"viewobjectbottom\">"
                 .     "<div class=\"objectleft\">"
                 .         "<center class=\"skills\">Email:</center>"
                 .         "<center class=\"skills\">Phone no. </center>"
                 .     "</div>"
                 .     "<div class=\"objectright\">"
                 .         "<p class=\"interestlist\">";
            if (!$on_con) {
                # Constructs back end of email from college and university
                $str = "******@";
                switch ($selected_candidate_details["university"]) {
                    case "":
                    case "Oxford":
                        $end = ".ox.ac.uk";
                        # Need to create method to get college email abbreviation from college
                        $mid = "chch";
                        break;
                    case "Durham":
                        break;
                    case "Cambridge":
                        break;
                }
                $res .=             $str . $mid . $end
                     .         "</p>"
                     .         "<p class=\"interestlist\">07********</p>"
                     .         "<button class=\"accessdetails-small\" onclick=\"access_details(" . $selected_candidate_id . ")\">Access details</button>";
            } else {
                if (strlen($contact_details["mob"]) == 0) {
                    $mob = "None provided";
                } else {
                    $mob = $contact_details["mob"];
                }
                $res .= $contact_details["email"] . "</p>"
                     .  "<p class=\"interestlist\">" . $mob . "</p>";
            }
            $res .=    "</div>"
                 . "</div>";
            $res .="<script>"
                 ."$('#avatar_name').on('click',function(){"
                 ."$('#full_name').html(\"<b>Hello world!</b>\");"
                 ."});"
                 ."</script>";  
            # Form tab buttons
            $res .="<div class=\"tab\">"
                 .     "<button class=\"tablinks2 active\" onclick=\"openTab(event, 2, 'details_tab')\">Details</button>"
                 .     "<button class=\"tablinks2\" onclick=\"openTab(event, 2, 'cv_tab')\">CV</button>"
                 . "</div>";
            # Populate details tab
            if ($selected_candidate_details["ind3"] == "") {
                $skill_set_of_cand = "None provided";
            } else {
                $skill_set_of_cand = json_decode($selected_candidate_details["ind3"]);
            }
            
            $res .="<div id=\"details_tab\" class=\"tabcontent2\" style=\"display: block;\">";
            if ($selected_candidate_details["descr"] != "") {
                $res.= "<div class=\"vdskills\">"
                     . $selected_candidate_details["descr"]
                     . "</div><hr/>";
            }
            if ($skill_set_of_cand != "None provided") {
                sort($skill_set_of_cand);
                $res.= "<h4>Skills</h4>"
                 .     "<div class=\"vdskills\">"
                 .         "<div class=\"inline\">";
                for ($i = 0; $i < sizeof($skill_set_of_cand); $i++) {
                    $res .= "<p class=\"badge badge-secondary\">" . ucfirst($skill_set_of_cand[$i]) . "</p>";
                }
                $res .=    "</div>"
                 .     "</div>"
                 .     "<hr style=\"margin-top: 0;\">";
            }
            $res.=     "<div class=\"vdskills\">"
                 .         "<div class=\"objectleft\">"
                 .             "<center class=\"skills\">Looking for:</center>"
                 .             "<center class=\"skills\">Degree Type:</center>"
                 .             "<center class=\"skills\">Grade:</center>"
                 .             "<center class=\"skills\">Education:</center>"
                 .         "</div>"
                 .     "<div class=\"objectright\" style=\"font-size: 100%\">"
                 .         "<p class=\"interestlist\">";
            # Make the career type more readable
            switch ($selected_candidate_details["type"]) {
                case "Career":
                case "Internship":
                    $res .= $selected_candidate_details["type"];
                    break;
                case "Both":
                    $res .= "Career or Internship";
                    break;
            }
            $res .=        "</p>"
                 .             "<p class=\"interestlist\">" 
                 .                  $selected_candidate_details["qualification"] 
                 .             "</p>"
                 .             "<p class=\"interestlist\">";
            # Check if predicted grade was provided 
            if (strlen($selected_candidate_details["grade"]) == 0) {
                $res .= "None provided";
            } else {
                $res .= $selected_candidate_details["grade"];
            }
            $res .=            "</p>"
                 .             "<p class=\"interestlist\">"
                 .                  $selected_candidate_details["school"]
                 .             "</p>"
                 .         "</div>"
                 .     "</div>"
                 .     "<h4>Interests</h4>"
                 .     "<div class=\"vdskills\">";
            # Very much need to sort parsing here!!
            $sectors = json_decode($selected_candidate_details["ind2"]);
            $sector_html = "";
            $sector_begin = "<div class=\"inline\">";
            switch (sizeof($sectors)) {
                case 0:
                    $res .="<div class=\"inline\">"
                         .     "<p class=\"badge badge-info\">"
                         .         "No sectors provided"
                         .     "</p>"
                         . "</div>";
                    break;
                default:
                    if (sizeof($sectors) > 3) {
                        $max = 3;
                    } else {
                        $max = sizeof($sectors);
                    }
                    $res .= "<div class=\"inline\">";
                    for ($i = 0; $i < $max; $i++) {
                        $res .=    "<p class=\"badge badge-info\">"
                             .         $sectors[$i]
                             .     "</p>";
                    }
                    $res .= "</div>";
                    break;
            }
            $res .=    "</div>"
                 .     "<h4>Suitable roles</h4>"
                 .     "<div class=\"vdskills\">"
                 .         "<div class=\"inline\">";
            $roles = json_decode($selected_candidate_details["ind1"]);
            switch (sizeof($roles)) {
                case 0:
                    $res .="<p class=\"badge badge-info\">"
                         .     "No roles provided"
                         . "</p>";
                    break;
                default:
                    if (sizeof($roles) > 3) {
                        $max = 3;
                    } else {
                        $max = sizeof($roles);
                    }
                    for ($i = 0; $i < $max; $i++) {
                        $res .="<p class=\"badge badge-info\">"
                             .     $roles[$i]
                             . "</p>";
                    }
                    break;
            }
            $res .=        "</div>"
                 .     "</div>"
                 . "</div>";
            $roles = json_decode($selected_candidate_details["ind1"]);
            # Provide CV tab
            $res .="<div id=\"cv_tab\" class=\"tabcontent2\" style=\"display:none\">"
                 .     "<embed class=\"cv_box\" src=\"components/cv_viewer.php?file=" . $f_name . "\"/>"
                 . "</div>";
            echo $res;
        } 
    }
?>
