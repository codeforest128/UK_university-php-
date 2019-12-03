<?php


include('../classes/DB.php');
include('../classes/login.php');


require __DIR__ . '/vendor/lib/ConvertApi/autoload.php';
use \ConvertApi\ConvertApi;
ConvertApi::setApiSecret('yVgxtPLYgRgWlScr');

if (!Login::isLoggedIn()) {
    header("Location: login.php");
}

if (isset($_COOKIE['SNID']))	{		
    $token = $_COOKIE['SNID'];
	$userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
	$username = DB::query('SELECT username FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['username'];
	$result = DB::query("SELECT * FROM posts WHERE user_id = $userid AND firstname != '' ");
	$no = count($result);
    //echo $no; die;
	$exists = DB::query('SELECT verified FROM verification WHERE userid=:code', array(':code'=>$userid))[0]['verified'];
}

if (isset($_POST)) {
    $path = '../temp/uploads/';
    if ($_FILES["userfile"]["error"] > 0) {
        $image_url = '';
        echo 'nope';
    } else {
        $f_name = $_FILES["userfile"]["name"];
 
        $ext = end((explode(".", $f_name)));
        $f_name = 'OCH'.$userid.' '.$username.' CV.'.$ext;
        move_uploaded_file($_FILES['userfile']['tmp_name'], $path.$f_name);
        $image_url =  $f_name;
        
        // $upload = new \ConvertApi\FileUpload($path.$f_name);
        // if ($ext == 'doc' || $ext == 'docx' )
        // {
        //     $outfile = 'OCH'.$userid.' '.$username.' CV.pdf';  
        //     $result = ConvertApi::convert('pdf', ['File' => $upload]);
        //     $savedFiles = $result->saveFiles('../temp/CVS_PDF/'.$outfile);
        //     $outfile = 'OCH'.$userid.' '.$username.' CV.txt';
        //     $result = ConvertApi::convert('txt', ['File' => $upload]);
        //     $savedFiles = $result->saveFiles('../temp/CVS_TEXT/'.$outfile);
        // }
        
        // if ($ext == 'pdf') {
        //     move_uploaded_file($_FILES['userfile']['tmp_name'], "../temp/CVS_PDF/" . $f_name);
        //     $outfile = 'OCH'.$userid.' '.$username.' CV.txt';
        //     $result = ConvertApi::convert('txt', ['File' => $upload]);
        //     $savedFiles = $result->saveFiles('../temp/CVS_TEXT/'.$outfile);
        // }
        
        $file_fatch = DB::query('SELECT * FROM images WHERE userid=:userid', array(':userid'=>$userid));
        
        if ($file_fatch) {
            $updated_date = date('Y-m-d H:i:s');
            $img_id = $file_fatch[0]['id'];
            $update = DB::query('UPDATE images SET 	file_name=:filename, updated_on=:updated_date WHERE id=:id', array(':id'=>$img_id,':filename'=>$image_url,':updated_date'=>$updated_date));
            if($update){
                $_SESSION['flash'] = 'Resume Uploaded';
            }
            
        } else {
            $insert = DB::query('INSERT into images VALUES (\'\', :file_name, NOW(), :userid, \'\', \'\' )', array(':file_name'=>$image_url, ':userid'=>$userid));
            if ($insert) {
                $_SESSION['flash'] = 'Resume Uploaded';
            }
        }
    }
}

 header("Location: account.php");
      
          
?>