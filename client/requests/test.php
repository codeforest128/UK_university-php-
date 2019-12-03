<?php
    header("Access-Control-Allow-Origin: *");
    include_once "../../../classes/SearchEngine.php";
    // Gather parameters from get request

    //Fetch Student Data


    $token = $_COOKIE['SNID'];
    $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];

    $students = DB::query('SELECT users.id as itd,posts.firstname as fname,posts.university,posts.course,posts.college,posts.course_end,posts.course_end,posts.availability as grad_year,posts.ind1 as interests,posts.grade,posts.ind3 as skills,posts.type FROM users INNER JOIN posts ON users.id = posts.user_id ORDER BY users.id desc');

    $contacts = DB::query('SELECT * FROM contacts WHERE client_id="'.$clientid.'"');
    $short_list = DB::query('SELECT * FROM short_list WHERE client_id="'.$clientid.'"');

    $rebuild_v1 = array();

    foreach ($students as $keyST => $valueST) {
        $rebuild_v1[$keyST] = $valueST;
        $contacted_already = 0;
        $shortlisted = 0;

        foreach ($contacts as $keyC => $valueC) {
            if($valueC['student_id']==$valueST['itd']){
                $contacted_already++;
            }
        }
        foreach ($short_list as $keySH => $valueSH) {
            if($valueSH['student_id']==$valueST['itd']){
                $shortlisted++;
            }
        }

        $rebuild_v1[$keyST]['contacted_already'] = $contacted_already;
        $rebuild_v1[$keyST]['shortlisted'] = $shortlisted;

        try
        {
         $interests =   json_decode($valueST['interests']);
         $skills =   json_decode($valueST['skills']);
        }
        catch (ErrorException $e)
        {
          $interests = array();
          $skills = array();
        }

        if (count($interests)>0) {
            $rebuild_v1[$keyST]['interests'] = implode(",",$interests);
        }else{
            $rebuild_v1[$keyST]['interests'] = "Not Found";
        }

        if (count($skills)>0) {
            $rebuild_v1[$keyST]['skills'] = implode(",",$skills);
        }else{
            $rebuild_v1[$keyST]['skills'] = "Not Found";
        }

        $rebuild_v1[$keyST]['search_type'] = "basic";



    }

    $students = $rebuild_v1;


      //Filtering Students

        $smart = "";
        $des_amt = 0;

    if (isset($_SESSION['filters'])) {

        $o_type = ""; 
        
        $course = array();
        $grade = array();
        $sector = array();
        $gradyear = array();
        $skill = array();
        $keywords = array();

        if (isset($_SESSION['filters']['o-type'])) {
            $o_type = $_SESSION['filters']['o-type'];
        }
        if (isset($_SESSION['filters']['smart'])) {
            $smart = $_SESSION['filters']['smart'];
        }
        if (isset($_SESSION['filters']['course'])) {
            $course = $_SESSION['filters']['course'];
        }
        if (isset($_SESSION['filters']['grade'])) {
            $grade = $_SESSION['filters']['grade'];
        }
        if (isset($_SESSION['filters']['sector'])) {
            $sector = $_SESSION['filters']['sector'];
        }
        if (isset($_SESSION['filters']['gradyear'])) {
            $gradyear = $_SESSION['filters']['gradyear'];
        }
        if (isset($_SESSION['filters']['skill'])) {
            $skill = $_SESSION['filters']['skill'];
        }
        if (isset($_SESSION['filters']['keywords'])) {
            $keywords = $_SESSION['filters']['keywords'];
        }
        if (isset($_SESSION['filters']['des_amt'])) {
            $des_amt = $_SESSION['filters']['des_amt'];
        }

        $rebuild_v2 = array();


        foreach ($students as $keyST => $valueST) {
            $push_check = 0;

            if ($o_type!="" && $valueST['type']==$o_type) { $push_check++;}

            foreach ($course as $key => $value) {
                $word = str_replace("_"," ",$key);
                $check_on = stripos($valueST['course'],$word);
                if ($check_on>-1) { $push_check++;}
            }

            foreach ($grade as $key => $value) {
                $word = str_replace("_"," ",$key);
                $check_on = stripos($valueST['grade'],$word);
                if ($check_on>-1) { $push_check++;}
            }

            foreach ($sector as $key => $value) {
                $word = str_replace("_"," ",$key);
                $check_on = stripos($valueST['interests'],$word);
                if ($check_on>-1) { $push_check++;}
            }

            foreach ($gradyear as $key => $value) {
                $word = str_replace("_"," ",$key);
                $check_on = stripos($valueST['course_end'],$word);
                if ($check_on>-1) { $push_check++;}
            }

            foreach ($skill as $key => $value) {
                $word = str_replace("_"," ",$key);
                $check_on = stripos($valueST['skills'],$word);
                if ($check_on>-1) { $push_check++;}
            }

            foreach ($keywords as $key => $value) {
                $word = str_replace("_"," ",$value);
                $check_on = stripos($valueST['fname'],$word);
                if ($check_on>-1) { $push_check++;}
            }

            if ($push_check!=0) {
                $rebuild_v2[] = $valueST;
            }
            

        }


        $students = $rebuild_v2;

    }

    // Counting 

    $total_students = count($students);

    $max = $_GET['max'];
    if ($smart==1) {
        $max = $des_amt;
    }
    $offset = $_GET['offset'];
    $start_from = $offset * $max;


    $client_data  = DB::query('SELECT * FROM clients WHERE id="'.$clientid.'"');

    $student_limit = 0;
    $is_demo = 0;

    foreach ($client_data as $keyCD => $valueCD) {
      $student_limit = $valueCD['student_limit'];
      $is_demo = $valueCD['is_demo'];
    }

    if ($is_demo==1) {
        $total_students = $student_limit-1;
        $students = array_slice($students, $start_from, $student_limit);
    }else{
        $students = array_slice($students, $start_from, $max);
    }


     //Json Response


    $json_respo = json_encode(array('ss'=>$total_students,'students'=>$students));

    if ($_GET["key"] == $_COOKIE["ajax_ver"]) {

    echo $json_respo;

    }

    

die;
    
    
?>