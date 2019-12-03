<?php


include('../classes/DB.php');
include('../classes/login.php');
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
                    
                    $path = 'uploads_pic/';
                    
                    
                    
                        if ($_FILES["userfile"]["error"] > 0) {
                              $image_url = '';
                              echo 'nope';
                        } else {
                            
                            $f_name = $_FILES["userfile"]["name"];
                            $f_name = $username.' '.time().$f_name;
                            move_uploaded_file($_FILES['userfile']['tmp_name'], $path.$f_name);
                            $image_url =  $path.$f_name;
                            
                            $file_fatch = DB::query('SELECT * FROM pic WHERE userid=:userid', array(':userid'=>$userid));
                    
                                if($file_fatch){
                                    $img_id = $file_fatch[0]['id'];
                                    
                                    $update = DB::query('UPDATE pic SET pic=:pic WHERE id=:id', array(':id'=>$img_id,':pic'=>$image_url));
                                    if($update){
                                        $_SESSION['flash'] = 'Resume Uploaded';
                                    }
                                    
                                }else{
                                    $insert = DB::query('INSERT into pic VALUES (\'\',  :userid,:pic \'\')', array(':pic'=>$image_url, ':userid'=>$userid));
                                    if($insert){
                                        $_SESSION['flash'] = 'Resume Uploaded';
                                    }
                                }
                            
                                
                    
                                
                            
                        }
    


}

 header("Location: account.php");
      
          
?>