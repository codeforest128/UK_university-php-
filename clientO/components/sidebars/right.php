<?php
    $shortlist = DB::query('SELECT * FROM short_list WHERE client_id="' . $client_id . '"');
    $contacts = DB::query('SELECT * FROM contacts WHERE client_id="' . $client_id . '"');
    $click = DB::query('SELECT * FROM student_click WHERE client_id="' . $client_id . '"');
?>


<div class="update-resume text-center">
    <h2>Contacts</h2>
    <div class="upload-box">
        <h3>You have accessed the details of</h3>
        <h3><span class="resume-count"><?php echo count($contacts); ?></span> students</h3>
        <!--    
            <p>Contacts</p>
            <p style="font-size:13px;margin-top:-20px;">Your have</p>
        -->
        <div class="upload-btn-wrapper">
            <br />
            <!--      
                <button class="btn upload-img"
                <input type="file" name="myfile" /><i class="fas fa-cloud-upload-alt"></i> Upload Resume
                </button>
            -->
        </div>
    </div>
</div>
<div class="my-network text-center">
    <h2>Shortlist</h2>
        <p>You have shortlisted</p>
    <h1><span class="count"><?php echo count($shortlist); ?></span> students</h1>
    <br/>
    <!--   <p style="font-size:13px;margin-top:-40px;">Your have</p> -->
</div>

<!--
    <div class="my-network text-center">
        <h2>Student Clicked</h2>
        <h1><span class="count"><?php echo count($click); ?></span> students</h1>
        <p>Clicked</p>
        <p style="font-size:13px;margin-top:-40px;">On Email Link</p>
    </div>
-->