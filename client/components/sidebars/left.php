<?php
    $client_data = DB::query('SELECT * FROM client_details WHERE client_id="' . $client_id . '"')[0];
?>

<div class="personal-detaile-sec text-center">
    <h3 style="margin-bottom: 1em;">Client Profile</h3>
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
    <div class="row">
        <div class="col-md-4">Name:</div>
        <div class="col-md-8"><?php echo $client_data['contact_name']; ?><br /><br /><br /></div>
    </div>
    <div class="row">
        <div class="col-md-4">Company name:</div>
        <div class="col-md-8"><?php echo $client_data['company_name']; ?><br /><br /><br /></div>
    </div>
    <div class="row">
        <div class="col-md-4">Email:</div>
        <div class="col-md-8" style="word-wrap: break-word;"><?php echo $client_data['contact_email']; ?><br /><br /><br /></div>
    </div>
    <div class="row">
        <div class="col-md-4">Phone:</div>
        <div class="col-md-8"><?php echo $client_data['contact_tel']; ?><br /><br /><br /></div>
    </div>
    <div class="row">
        <div class="col-12">
            <style>
                .up_prof_btn {
                    outline: none;
                    padding: 0.8em 0;
                    width: 90%;
                    text-align: center;
                    font-size: 1em;
                    margin-top: 1em;
                    margin: auto;
                    border: none;
                    color: #FFFFFF;
                    text-transform: uppercase;
                    cursor: pointer;
                    background: #04003c;
                    display: block;
                }
                .up_prof_btn:hover {
                    color: #fff;
                    background: #000;
                    transition: .5s all;
                    -webkit-transition: .5s all;
                }
                .c_pass_btn {
                    font-size: 1em;
                    outline: none;
                    border-radius: 0;
                    width: 90%;
                    display: block;
                    padding: 0.8em 0;
                    margin: auto;
                    background: #ccc;
                    border: none;
                }
            </style>
            <!--<button class="up_prof_btn" data-toggle="modal" data-target="#update_profile"><i class="fa fa-user"></i> Update Profile</button>-->
            <br />
            <script>
                function change_password() {
                    document.getElementById('update_pass').modal('show');
                }
            </script>
            <a href="change_password.php" style="text-decoration: none;">
                <button class="up_prof_btn"><i class="fa fa-key"></i> Change password</button>
                <!--<button class="c_pass_btn"><i class="fa fa-key"></i> Change password</button>-->
            </a>
        </div>
        <br />
    </div>
</div>

<?php
    # Not entirely sure what the purpose of these are either??
    $null = DB::query('SELECT firstname FROM posts WHERE user_id=:userid', array(':userid' => $userid))[0]['firstname'];
    $email = DB::query('SELECT email FROM users WHERE id=:userid', array(':userid' => $userid))[0]['email'];
?>