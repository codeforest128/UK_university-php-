<?php
	include('../../classes/DB.php');
	include('../../classes/login.php');
	
        if (!Login::isClientLoggedIn()) {
         header("Location: login.php");
		}
		if (isset($_COOKIE['SNID']))	{			
			$token = $_COOKIE['SNID'];
			$clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token'=>sha1($token)))[0]['client_id'];
	
			$file_name = DB::query('SELECT file_name FROM images WHERE userid=:userid', array(':userid'=>$userid))[0]['file_name'];
				$sectors = "";
			$kind = "";
			
		}



		$id = $_POST['id'];


		$role = DB::query('SELECT * FROM role WHERE id="'.$id.'"');

		foreach ($role as $key => $value) {

			?>


			<form action="" method="post">
          <input type="hidden" name="edit_add_form">
          <input type="hidden" name="id" value="<?php echo $value['id'];?>">
          <div class="row">
            <div class="col-md-12">
              <label>Role name</label>
              <input type="text" name="name" class="form-control" value="<?php echo $value['name'];?>" required>
              <br/>
              
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
            </div>
            <div class="col-md-6">
               <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
          </div>

        </form>





			<?php
		
		}
		
		







    
		

?>