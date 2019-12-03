<?php
	header("Access-Control-Allow-Origin: *");


    // include_once "../../../classes/SearchEngine.php";
    // Gather parameters from get request

    //Fetch Student Data


//     $token = $_COOKIE['SNID'];
//     $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];

//     $students = DB::query('SELECT users.id as itd,posts.firstname as fname,posts.university,posts.course,posts.college,posts.course_end,posts.course_end,posts.availability as grad_year,posts.ind1 as interests,posts.grade,posts.ind3 as skills,posts.type,posts.location,posts.qualification FROM users INNER JOIN posts ON users.id = posts.user_id WHERE NOT posts.course="" ORDER BY users.id desc');

//     $contacts = DB::query('SELECT * FROM contacts WHERE client_id="'.$clientid.'"');
//     $short_list = DB::query('SELECT * FROM short_list WHERE client_id="'.$clientid.'"');

//     $rebuild_v1 = array();

//     foreach ($students as $keyST => $valueST) {
//         $rebuild_v1[$keyST] = $valueST;
//         $contacted_already = 0;
//         $shortlisted = 0;

//         foreach ($contacts as $keyC => $valueC) {
//             if($valueC['student_id']==$valueST['itd']){
//                 $contacted_already++;
//             }
//         }
//         foreach ($short_list as $keySH => $valueSH) {
//             if($valueSH['student_id']==$valueST['itd']){
//                 $shortlisted++;
//             }
//         }

//         $rebuild_v1[$keyST]['contacted_already'] = $contacted_already;
//         $rebuild_v1[$keyST]['shortlisted'] = $shortlisted;

//         try
//         {
//          $interests =   json_decode($valueST['interests']);
//          $skills =   json_decode($valueST['skills']);
//         }
//         catch (ErrorException $e)
//         {
//           $interests = array();
//           $skills = array();
//         }

//         if (count($interests)>0) {
//             $rebuild_v1[$keyST]['interests'] = implode(",",$interests);
//         }else{
//             $rebuild_v1[$keyST]['interests'] = "Not Found";
//         }

//         if (count($skills)>0) {
//             $rebuild_v1[$keyST]['skills'] = implode(",",$skills);
//         }else{
//             $rebuild_v1[$keyST]['skills'] = "Not Found";
//         }

//         $rebuild_v1[$keyST]['search_type'] = "basic";



//     }

//     $students = $rebuild_v1;


//       //Filtering Students

//         $smart = "";
//         $des_amt = 0;

//     if (isset($_SESSION['filters'])) {

//         $o_type = ""; 
        
//         $course = array();
//         $grade = array();
//         $sector = array();
//         $gradyear = array();
//         $skill = array();
//         $keywords = array();
//         $location = array();
//         $qualification = array();

//         if (isset($_SESSION['filters']['o-type'])) {
//             $o_type = $_SESSION['filters']['o-type'];
//         }
//         if (isset($_SESSION['filters']['smart'])) {
//             $smart = $_SESSION['filters']['smart'];
//         }
//         if (isset($_SESSION['filters']['course'])) {
//             $course = $_SESSION['filters']['course'];
//         }
//         if (isset($_SESSION['filters']['grade'])) {
//             $grade = $_SESSION['filters']['grade'];
//         }
//         if (isset($_SESSION['filters']['sector'])) {
//             $sector = $_SESSION['filters']['sector'];
//         }
//         if (isset($_SESSION['filters']['gradyear'])) {
//             $gradyear = $_SESSION['filters']['gradyear'];
//         }
//         if (isset($_SESSION['filters']['skill'])) {
//             $skill = $_SESSION['filters']['skill'];
//         }
//         if (isset($_SESSION['filters']['keywords'])) {
//             $keywords = $_SESSION['filters']['keywords'];
//         }
//         if (isset($_SESSION['filters']['location'])) {
//             $location = $_SESSION['filters']['location'];
//         }
//         if (isset($_SESSION['filters']['qualification'])) {
//             $qualification = $_SESSION['filters']['qualification'];
//         }

        


//         if (isset($_SESSION['filters']['des_amt'])) {
//             $des_amt = $_SESSION['filters']['des_amt'];
//         }

//         $rebuild_v2 = array();


//         foreach ($students as $keyST => $valueST) {
//             $push_check = 0;

//             if ($o_type!="" && $valueST['type']==$o_type) { $push_check++;}

//             foreach ($course as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['course'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($grade as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['grade'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($sector as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['interests'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($gradyear as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['course_end'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($skill as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['skills'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($keywords as $key => $value) {
//                 $word = str_replace("_"," ",$value);
//                 $check_on = stripos($valueST['fname'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($location as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['location'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

//             foreach ($qualification as $key => $value) {
//                 $word = str_replace("_"," ",$key);
//                 $check_on = stripos($valueST['qualification'],$word);
//                 if ($check_on>-1) { $push_check++;}
//             }

            

//             if ($push_check!=0) {
//                 $rebuild_v2[] = $valueST;
//             }
            

//         }


//         $students = $rebuild_v2;

//     }

//     // Counting 

//     $total_students = count($students);

//     $max = $_GET['max'];
//     if ($smart==1) {
//         $max = $des_amt;
//     }
//     $offset = $_GET['offset'];
//     $start_from = $offset * $max;


//     $client_data  = DB::query('SELECT * FROM clients WHERE id="'.$clientid.'"');

//     $student_limit = 0;
//     $is_demo = 0;

//     foreach ($client_data as $keyCD => $valueCD) {
//       $student_limit = $valueCD['student_limit'];
//       $is_demo = $valueCD['is_demo'];
//     }

//     if ($is_demo==1) {
//         $total_students = $student_limit-1;
//         $students = array_slice($students, $start_from, $student_limit);
//     }else{
//         $students = array_slice($students, $start_from, $max);
//     }


//      //Json Response


//     $json_respo = json_encode(array('ss'=>$total_students,'students'=>$students));

//     if ($_GET["key"] == $_COOKIE["ajax_ver"]) {

//     echo $json_respo;

//     }

    

// die;

    
// 	include 'test.php';
// 	die();
	include '../../vendor/autoload.php';
	include_once "../../../classes/SearchEngine.php";
     // Gather parameters from get request
	
	//echo"<pre>"; print_r($_SESSION); die();
	
     $token = $_COOKIE['SNID'];
     $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];

     $client_data  = DB::query('SELECT * FROM clients WHERE id="'.$clientid.'"');

     $student_limit = 0;
     $is_demo = 0;
     foreach ($client_data as $keyCD => $valueCD) {
       $student_limit = $valueCD['student_limit'];
       $is_demo = $valueCD['is_demo'];
     }
     if ($_GET["key"] == $_COOKIE["ajax_ver"]) {
         if (isset($_SESSION["filters"]) && $_SESSION["filters"]["smart"] === 1) {
             $limit = $_SESSION["filters"]['des_amt'];
             $students = smart_search_re();
            
             $total = count($students);
             $start_from = $_GET["offset"] * $limit;
             $students = array_slice($students, $start_from, $limit);
             if ($is_demo==1) {
                 $total = $student_limit-1;
                 $students = array_slice($students, $start_from, $student_limit);
             }
             $returner = array('ss'=>$total,'students'=>$students);
             echo json_encode($returner);

             die();
    
             /*$limit = $_SESSION["filters"]['des_amt'];
             $result_json = SE::smart_search($_GET["offset"]);
             $result_obj = json_decode($result_json);

             $students = array();

             $start_from = $_GET["offset"] * $limit;

             foreach ($result_obj->students as $key => $value) {
                 $students[] = (array) $value;
             }

             $students = array_slice($students, $start_from, $limit);
             $returner = array('ss'=>'smart_reduced','students'=>$students);
             echo json_encode($returner);
             die();*/

         } else if (isset($_GET["offset"]) && isset($_GET["max"])) {
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

             if ($_GET["type"]=='SHRT' || $_GET["type"]=='CNTCT' || $_GET["type"]=='SEL') {
               echo $response;  
             }else{
                 $result_obj = json_decode($response);
                     $students = array();

                     foreach ($result_obj->students as $key => $value) {
                         $students[] = (array) $value;
                     }

                     $ttl_student = count($students);

                     $students = array_slice($students, $start_from, $max);
                     if ($is_demo==1) {
                         $ttl_student = $student_limit-1;
                         $students = array_slice($students, $start_from, $student_limit);
                     }
                     $returner = array('ss'=>$ttl_student,'students'=>$students);
                     echo json_encode($returner);

             }
            
         }
     }



     function smart_search_re()
     {
         
         $parser = new \Smalot\PdfParser\Parser();
         $token = $_COOKIE['SNID'];
         $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];


         $short_list = DB::query("SELECT * FROM short_list WHERE client_id='".$client_id."'");
         $contacts = DB::query("SELECT * FROM contacts WHERE client_id='".$client_id."'");

         $filters = $_SESSION['filters'];
         $smart = $_SESSION['filters']['smart'];

         if (isset($_SESSION['filters']['course'])) {
             $course = $_SESSION['filters']['course'];
         }else{
             $course = array();
         }

         if (isset($_SESSION['filters']['grade'])) {
             $grade = $_SESSION['filters']['grade'];
         }else{
             $grade = array();
         }

         if (isset($_SESSION['filters']['sector'])) {
             $sector = $_SESSION['filters']['sector'];
         }else{
             $sector = array();
         }

         if (isset($_SESSION['filters']['gradyear'])) {
             $gradyear = $_SESSION['filters']['gradyear'];
         }else{
             $gradyear = array();
         }
         
         if (isset($_SESSION['filters']['university'])) {
             $university = $_SESSION['filters']['university'];
         }else{
             $university = array();
         }
         
         if (isset($_SESSION['filters']['location'])) {
             $location = $_SESSION['filters']['location'];
         }else{
             $location = array();
         }

         if (isset($_SESSION['filters']['skill'])) {
             $skill = $_SESSION['filters']['skill'];
         }else{
             $skill = array();
         }

         if (isset($_SESSION['filters']['keywords'])) {
             $keywords = $_SESSION['filters']['keywords'];
         }else{
             $keywords = array();
         }

         if (isset($_SESSION['filters']['des_amt'])) {
             $des_amt = $_SESSION['filters']['des_amt'];
         }else{
             $des_amt = 25;
         }

    
         $sql = "SELECT user_id as itd, firstname as fname, university,location, course, college, course_end, availability as grad_year, ind1, ind3, grade, times_contacted_this_month FROM posts INNER JOIN users ON users.id = posts.user_id WHERE verified = 1 ORDER BY itd desc";

         $students = DB::query($sql);
         $rebuild_student = array();
         foreach ($students as $keyST => $valueST) {

             try
             {
              $student_sector =  json_decode($valueST['ind1']);
             }
             catch (ErrorException $e)
             {
               $student_sector = array();
             }

             try
             {
              $student_skill =  json_decode($valueST['ind3']);
             }
             catch (ErrorException $e)
             {
               $student_skill = array();
             }



             $checked = 0;

             /*course*/

             foreach ($course as $key => $value) {
                 if ($key==$valueST['course']) {
                     $checked++;
                 }
             }

             /*grade*/

             foreach ($grade as $key => $value) {
                 if ($key==$valueST['grade']) {
                     $checked++;
                 }
             }

             /*sector*/
            
             foreach ($sector as $key => $value) {
                 foreach ($student_sector as $keySS => $valueSS) {
                     if ($key==$valueSS) {
                         $checked++;
                     }
                 }
             }
             /*university*/
             foreach ($university as $key => $value) {
                 $key = str_replace("_", " ", $key);
                 if ($key==$valueST['university']) {
                     $checked++;
                 }
             }
             
             foreach ($location as $key => $value) {
                 $key = str_replace("_", " ", $key);
                 if ($key==$valueST['location']) {
                     $checked++;
                 }
             }
             
             /*Grade Year*/

             foreach ($gradyear as $key => $value) {
                 if ($key==$valueST['grad_year']) {
                     $checked++;
                 }
             }

             /*skill*/

             foreach ($skill as $key => $value) {
                 foreach ($student_skill as $keySSK => $valueSSK) {
                     if ($key==$valueSSK) {
                         $checked++;
                     }
                 }
             }

             /*Keywords*/
             foreach ($keywords as $key => $value) {
                 if ($value!='') {
                     // if (stripos($valueST['fname'],$value)>-1) {
                     // $checked++;
                     // }
                     // if (stripos($valueST['university'],$value)>-1) {
                     // $checked++;
                     // }
                     // if (stripos($valueST['course'],$value)>-1) {
                     // $checked++;
                     // }
                     // if (stripos($valueST['college'],$value)>-1) {
                     // $checked++;
                     // }
                     // if (stripos($valueST['course_end'],$value)>-1) {
                     // $checked++;
                     // }
                     // if (stripos($valueST['availability'],$value)>-1) {
                     // $checked++;
                     // }
                     
                     $filename = DB::query('SELECT file_name FROM images WHERE userid="' . $valueST['itd'] . '"');
                     if($filename)
                     {
                         $file = "../../../temp/uploads/". $filename[0]['file_name'];
                         $file1 = "../../../temp/CVS_PDF/". $filename[0]['file_name'];
                         $content1 = file_get_contents($file);
                         $content2 = file_get_contents($file1);
                         if($content1){
                             try{
                                 $pdf    = $parser->parseFile($file);
                                 $text = $pdf->getText();
                                 if (stripos($text, $value) > -1) {
                                     $checked++;
                                 }
                             }
                             catch(\Exception $e){
                                
                             }
                         }
                         else if($content2){
                             try{
                                 $pdf    = $parser->parseFile($file1);
                                 $text = $pdf->getText();
                                 if (stripos($text, $value) > -1) {
                                     $checked++;
                                 }
                             }
                             catch(\Exception $e){
                                
                             }
                         }
                        
                     }
                
                 }                
             }

             $contacted_already = 0;

             foreach ($contacts as $keyC => $valueC) {
                 if ($valueC['student_id']==$valueST['itd']) {
                     $contacted_already++;
                 }
             }

             $shortlisted = 0;

             foreach ($short_list as $keySL => $valueSL) {
                 if ($valueSL['student_id']==$valueST['itd']) {
                     $shortlisted++;
                 }
             }

             if (implode(",",$student_skill)!='') {
                 $valueST['skills'] = " ".implode(",",$student_skill);    
             }else{
                 $valueST['skills'] = 'None Found';
             }

             if (implode(",",$student_sector)!=''){
                 $valueST['interests'] = ' '.implode(",",$student_sector);    
             }else{
                 $valueST['interests'] = 'None Found';
             }

             $valueST['contacted_already'] = $contacted_already;
             $valueST['shortlisted'] = $shortlisted;

            


             if ($checked!=0) {
                $rebuild_student[] = $valueST;
             }
         }
         // while(count($rebuild_student) <= 5)
         // {
         //     foreach ($students as $keyST => $valueST) {
         //         $rebuild_student[] = $valueST;
         //     }
         // }
         if(count($rebuild_student) < $_SESSION["filters"]['des_amt'])
         {
             foreach ($students as $keyST => $valueST) {
                 if($keyST == 0) {$valueST['other'] = 1;}
                 try
                 {
                  $student_sector =  json_decode($valueST['ind1']);
                 }
                 catch (ErrorException $e)
                 {
                   $student_sector = array();
                 }
    
                 try
                 {
                  $student_skill =  json_decode($valueST['ind3']);
                 }
                 catch (ErrorException $e)
                 {
                   $student_skill = array();
                 }
                  $contacted_already = 0;

                 foreach ($contacts as $keyC => $valueC) {
                     if ($valueC['student_id']==$valueST['itd']) {
                         $contacted_already++;
                     }
                 }
    
                 $shortlisted = 0;
    
                 foreach ($short_list as $keySL => $valueSL) {
                     if ($valueSL['student_id']==$valueST['itd']) {
                         $shortlisted++;
                     }
                 }
    
                 if (implode(",",$student_skill)!='') {
                     $valueST['skills'] = " ".implode(",",$student_skill);    
                 }else{
                     $valueST['skills'] = 'None Found';
                 }
    
                 if (implode(",",$student_sector)!=''){
                     $valueST['interests'] = ' '.implode(",",$student_sector);    
                 }else{
                     $valueST['interests'] = 'None Found';
                 }
    
                 $valueST['contacted_already'] = $contacted_already;
                 $valueST['shortlisted'] = $shortlisted;
                 $rebuild_student[] = $valueST;
                 if($keyST == $_SESSION["filters"]['des_amt']) 
                 {break;}
             }
             // for($otherkey = 0; $otherkey < 25; $otherkey++)
             // {
             //     $randkey = mt_rand(0,1000);
             //     if($otherkey == 0) {
             //         $students[$randkey]['other'] = 1;
             //     }
             //     $rebuild_student[] = $students[$randkey];
             //     if($otherkey == $_SESSION["filters"]['des_amt']) break;
             // }
         }
         return $rebuild_student;


     }
?>