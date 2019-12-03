
 <?php

 $token = $_COOKIE['SNID'];
            $admin_id = DB::query('SELECT admin_id FROM admin_login_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['admin_id'];

$admin_details = DB::query('SELECT * FROM admin WHERE id="'.$admin_id.'"');

 ?>     
<div class="personal-detaile-sec text-center">
                    
                    <h3>Admin Profile</h3>
                    
                    
                    <div class="box-state">
                        <img src=" ../assets/img/avatars/avatar1.jpg " alt="images" class="img-fluid">
                        <!-- for pp data-toggle="modal" data-target="#upload_pic" -->
                    </div>
                 


                    
                </div>
                

                
                <div class="personal-detaile-sec">

                                     <style>
                  .smaalle{
                    font-size: 70%;
                  }
                </style>


                                    <div class="row smaalle">
                                        <div class="col-4">Name:</div>
                                        <div class="col-8"><?php echo $admin_details[0]['username'];?><br><br><br></div>
                                    </div>
                                    <div class="row smaalle">
                                        <div class="col-4">Email:</div>
                                        <div class="col-8"><?php echo $admin_details[0]['email'];?><br><br><br></div>
                                    </div>
                                    <div class="row smaalle">
                                        <div class="col">
                                            <button class="btn btn-secondary " data-toggle="modal" data-target="#update_password" style="width: 200px;margin-right: 15px; "><i class="fas fa-key"></i> Change password</button>
                                        </div>
                                    </div>



                                    
                   
                    
                    
                </div>
                
                                      
         