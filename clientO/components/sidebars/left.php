<?php
    $client_data = DB::query('SELECT * FROM client_details WHERE client_id="' . $client_id . '"')[0];
?>

<div class="personal-detaile-sec text-center">
    <h3>Client Profile</h3>
    <?php $pic = DB::query('SELECT * FROM pic WHERE userid=:userid', array(':userid' => $userid))[0]['pic']; ?>
    <div class="box-state">
        <!-- Little confused about all the comments here and their original purpose -->
        <!-- Figured what this is now... -->
        <img src="<?php // if($pic!=''){echo $pic; }else{ 
            ?> ../assets/img/avatars/avatar1.jpg <?php // } 
            ?>" alt="images" class="img-fluid">
        <!-- for pp data-toggle="modal" data-target="#upload_pic" -->
    </div>
</div>

<div class="personal-detaile-sec">
    <style>
        .smaalle {
            font-size: 70%;
        }
    </style>
    <div class="row smaalle">
        <div class="col-4">Name:</div>
        <div class="col-8"><?php echo $client_data['contact_name']; ?><br /><br /><br /></div>
    </div>
    <div class="row smaalle">
        <div class="col-4">Company name:</div>
        <div class="col-8"><?php echo $client_data['company_name']; ?><br /><br /><br /></div>
    </div>
    <div class="row smaalle">
        <div class="col-4">Email:</div>
        <div class="col-8" style="word-wrap: break-word;"><?php echo $client_data['contact_email']; ?><br /><br /><br /></div>
    </div>
    <div class="row smaalle">
        <div class="col-4">Phone:</div>
        <div class="col-8"><?php echo $client_data['contact_tel']; ?><br /><br /><br /></div>
    </div>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#update_profile" style="width: 200px;margin-right: 15px; "><i class="fas fa-user"></i> Update Profile</button>
            <br />
            <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#update_password" style="width: 200px;margin-right: 15px; "><i class="fas fa-key"></i> Change password</button>
        </div>
    </div>
</div>

<?php
    # Not entirely sure what the purpose of these are either??
    $null = DB::query('SELECT firstname FROM posts WHERE user_id=:userid', array(':userid' => $userid))[0]['firstname'];
    $email = DB::query('SELECT email FROM users WHERE id=:userid', array(':userid' => $userid))[0]['email'];
?>