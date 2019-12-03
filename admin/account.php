<?php




	include('../../classes/DB.php');
	include('../../classes/login.php');
	
    if (!Login::isAdminLoggedIn()) {
         header("Location: login.php");
		}



		if (isset($_COOKIE['SNID']))	{			
			$token = $_COOKIE['SNID'];
			$admin_id = DB::query('SELECT admin_id FROM admin_login_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['admin_id'];

			
		}
		
		
		if(array_key_exists('logout',$_POST)){
			  DB::query('DELETE FROM admin_login_tokens WHERE admin_id=:admin_id', array(':admin_id'=>Login::isAdminLoggedIn()));
			  header("Location: login.php");
		}

    
		

?>
<?php include('header.php');?>  
         
<section class="account-pages bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
      <?php include 'left_sidebar.php'; ?>
                
            </div>
			
	
            <div class="col-md-6 account-form">

                <div class="personal-detaile-sec ">
                  <div style="min-height: 400px;"></div>
                    <form action="remind_graduates.php" method="POST" style="display: none;">
                      <input type="submit" class="btn-primary" value="Remind Graduates" disabled>
                    </form>
                    <!-----------div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                             Client Details <i class="fas fa-angle-down icon-right"></i>
                            </a>
                          </h4>
                        </div>
                        <div id="collapseOne"  class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                                <div class="form-wrapper">

                                  
                                    
                                      <div class="col">
                                <div class="info">
                                    <h3 style="margin: 8px 0px 8px;">Client Details</h3>
                                   
                                    
                         
                            </div>
                        </div> 
                        </div>
                        </div>

                        
                   
                   
                  
                </div>
              </div>
  
        
            </div----------------------->
                    
            </div>
                
            </div>
           <div class="col-md-3">

            <?php include 'right_sidebar.php';?>
                
                 
                 
                
            </div>
        </div>
    </div>
</section> 

<!--section class="footer-send-btn">
    <div class="container-fluid">
        <div class="submit-details d-flex justify-content-end">
            <button type="button" class="btn btn-dark1" id="submit" method="post" action="#">Submit</button>
            <button type="button" class="btn btn-dark2">Reset</button>
        </div>
    </div>
</section-->



<?php include('footer.php'); ?>

