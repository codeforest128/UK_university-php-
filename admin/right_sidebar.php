<?php

$all_clients = DB::query('SELECT * FROM clients ORDER by id desc');
$all_users = DB::query('SELECT * FROM users ORDER by id desc');

?>

            

                <div class="update-resume text-center">
                    <h2>Clients</h2>
                    <div class="upload-box">
                        <h1><span class="count"></span></h3><?php echo count($all_clients);?></span></h1>
                        <p>Clients</p>
                        <p style="font-size:13px;margin-top:-20px;">In Admin</p>
                        <div class="upload-btn-wrapper">
                            <br>
                    <!--      <button class="btn upload-img"
                          <input type="file" name="myfile" /><i class="fas fa-cloud-upload-alt"></i> Upload Resume
                          </button>-->
                       </div>
                    </div>
                </div>
                <div class="my-network text-center">
                    <h2>Students</h2>
                    <h3>Details accesses</h3>
                    <h1><span class="count"><?php echo count($all_users);?></span></h1>
                    <p>Studdents</p>
                        <p style="font-size:13px;margin-top:-40px;">In Admin</p>

                </div>          
                 
                 
                