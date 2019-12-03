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
			
	
            <div class="col-md-9 account-form">
              <div class="personal-detaile-sec text-right" style="font-size: 90%;">
                <button class="btn btn-info" data-toggle="modal" data-target="#email_instructions"> Email Instructions</button>
              </div>


                <div class="personal-detaile-sec " style="font-size: 90%;">
                  <div class="row">
                    <div class="col"><h3>Clients</h3></div>
                    <div class="col text-right">
                      
                      <a href="add_client.php"><button class="btn btn-primary"> Add Client</button></a>
                    </div>
                  </div>

                  <?php


                  $all_clients = DB::query('SELECT * FROM clients ORDER by id desc');
                  $clients_details = DB::query('SELECT * FROM client_details');



                  ?>
                  

                 <table id="table_id" class="display" id="fuller">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Demo</th>
                          <th>Student Limit</th>
                          <th>Signer</th>
                          <th>Contacts</th>
                          <th>sign date</th>
                          <th>Signature</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php $countr=0; foreach ($all_clients as $keyCli => $valueCli) { 
                       $id = $valueCli['id'];
                        $conts = DB::query('SELECT * FROM contacts WHERE client_id = :client_id', array(':client_id'=>$id));
                        $noconts = count($conts);
                        $countr++;
                        ?>
                          <tr>
                            <td><?php echo $countr;?></td>
                            <td><?php echo $valueCli['username'];?></td>
                            <td><?php echo $valueCli['email'];?></td>
                            <td><?php  if($valueCli['is_demo']==1){ echo 'Yes'; }else{ echo '-';}?></td>
                            <td><?php  if($valueCli['is_demo']==1){ echo $valueCli['student_limit']; }else{ echo '-';}?></td>
                            <td><?php echo $valueCli['signer_name'];?></td>
                            <td><?php echo $noconts;  ?></td>
                            <td><?php echo $valueCli['sign_date'];?></td>
                            <td><?php if($valueCli['signature']!=''){ ?><img  src="../client/<?php echo $valueCli['signature'];?>" style="height:50px;"><?php } ?> </td>
                            <td><button class="btn btn-info" onclick="client_details(<?php echo $valueCli['id'];?>)">View Details</button></td>
                          </tr>
                        <?php } ?>
                        
                        
                      </tbody>
                    </table>
        
                      
                    
            </div>
                
            </div>
      
        </div>
    </div>
</section> 





<!-- The Modal -->
<div class="modal" id="client_details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Client details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div id="client_details_div"></div>
      </div>

    </div>
  </div>
</div>



<!-- The Modal -->
<div class="modal" id="email_instructions">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="process_update_email_instruction.php">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Email Instructions For Client</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php

        $ins = DB::query('SELECT * FROM settings WHERE name = :name', array(':name'=>'client_email_instructions'));

        ?>
        <?php

        foreach ($ins as $key => $value) { ?>
          <input type="hidden" name="id" value="<?php echo $value['id'];?>">
        <textarea class="form-control" rows="8" name="client_email_instructions" required=""><?php echo $value['value']; ?></textarea>  
       <?php } ?>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Save</button>
      </div>
      </form>

    </div>
  </div>
</div>




<?php include('footer.php'); ?>


<script type="text/javascript">
  
function client_details(ids) {

  $('#client_details_div').html('<center><i class="fa fa-spinner fa-4x fa-spin"></i></center>');
  $('#client_details').modal('show'); 

  $.post("ajax_client_details.php",
  {
    client_id: ids,
  },
  function(data, status){
    $('#client_details_div').html(data);
    //alert("Data: " + data + "\nStatus: " + status);
  });


}


</script>


<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

<script>
                        CKEDITOR.replace( 'client_email_instructions' );
                </script>


