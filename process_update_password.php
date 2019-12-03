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
                    
                    
                    
                    $password = DB::query('SELECT * FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password'];
                    
                    
                    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
                    
                    
                    if (password_verify($_POST['password'],$password)) {
                        
                        $update = DB::query('UPDATE users SET password=:password WHERE id=:id', array(':id'=>$userid,':password'=>$new_password));
                        
                        $_SESSION['flash'] = '<b class="text-success">Password Changed<b>';
                        
                     
                    }else{
                        $_SESSION['flash'] = '<b class="text-danger">Error ! Old Password Does Not Match<b>';
                      
                    }
                    
 
                    
                    
    


}

 header("Location: account.php");
      
          
?>