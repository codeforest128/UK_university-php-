<?php


header("Access-Control-Allow-Origin: *");




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


$client_id = $_POST['client_id'];
$clients_user = DB::query('SELECT * FROM clients WHERE id="'.$client_id.'"');
$clients_details = DB::query('SELECT * FROM client_details WHERE client_id="'.$client_id.'"');	

?>

<form action="process_update_client.php" method="post" id="client_form_update">
		

<table class="table table-bordered">
	

<?php 

foreach ($clients_user as $keyCli => $valueCli) {
?>

<tr>
	<td><input type="hidden" name="id" value="<?php echo $valueCli['id'];?>">Client User name</td>
	<td><?php echo $valueCli['username'];?></td>
</tr>

<tr>
	<td>Client email</td>
	<td><?php echo $valueCli['email'];?></td>
</tr>
<tr>
	
	<td>Demo mode</td>
	<td><select class="form-control" name="is_demo" >
			<option <?php if($valueCli['is_demo']==1){ echo 'selected'; } ?> value="1">Yes</option>
			<option <?php if($valueCli['is_demo']==0){ echo 'selected'; } ?> value="0">No</option>
		</select>
	</td>
</tr>
<tr>
	
	<td>Student Limit</td>
	<td>
		<input type="number" class="form-control" name="student_limit" value="<?php echo $valueCli['student_limit'];?>">
	</td>
</tr>

<?php } ?>
<?php
foreach ($clients_details as $keyCli => $valueCli) {
?>

<tr>
	<td>Contact name</td>
	<td><?php echo $valueCli['contact_name'];?></td>
</tr>

<tr>
	<td>Contact Email</td>
	<td><?php echo $valueCli['contact_email'];?></td>
</tr>

<tr>
	<td>Contact Telephone</td>
	<td><?php echo $valueCli['contact_tel'];?></td>
</tr>


<tr>
	<td>Contact Name</td>
	<td><?php echo $valueCli['company_name'];?></td>
</tr>

<tr>
	<td>Contact All Email</td>
	<td><?php echo $valueCli['all_email'];?></td>
</tr>


<tr>
	<td>Contact Note</td>
	<td><?php echo $valueCli['note'];?></td>
</tr>

<tr>
	<td>Created Time</td>
	<td><?php echo $valueCli['created_at'];?></td>
</tr>


<?php
}
?>

</table>




	<div class="text-right">
		   <button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>
		<button  type="submit" class="btn btn-primary" >Save</button>
	</div>

		</form>

