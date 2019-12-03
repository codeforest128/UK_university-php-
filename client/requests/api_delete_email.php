<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";

    print_r($_POST);

    $type = $_POST['type'];
    $data = $_POST['data'];

    try
    {
     $json_obj =   json_decode($data);
    }
    catch (ErrorException $e)
    {
      $json_obj = array();
    }

    if ($type=='draft') {
    	
    	foreach ($json_obj as $key => $value) {
    		
    		$file_fatch = DB::query("DELETE FROM email_draft WHERE id=".$value);
    	}
    }

    if ($type=='sent') {
        
        foreach ($json_obj as $key => $value) {
            
            $file_fatch = DB::query("DELETE FROM inhouse_email_tracking WHERE id=".$value);
        }
    }
    

    
?>