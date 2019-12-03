<div class="personal-detaile-sec ">
    <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Client Details <i class="fas fa-angle-down icon-right"></i>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="form-wrapper">
                        <?php
                            $token = $_COOKIE['SNID'];
                            $client_id = DB::query('SELECT * FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
                            $client_data = DB::query('SELECT * FROM client_details WHERE client_id="' . $client_id . '"')[0];
                        ?>
                        <div class="col">
                            <div class="info">
                                <h3 style="margin: 8px 0px 8px;">Client Details</h3>
                                <div class="row">
                                    <div class="col-6">Name:</div>
                                    <div class="col-6"><?php echo $client_data['contact_name']; ?><br /><br /></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Company name:</div>
                                    <div class="col-6"><?php echo $client_data['company_name']; ?><br /><br /></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Email:</div>
                                    <div class="col-6"><?php echo $client_data['contact_email']; ?><br /><br /></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Phone:</div>
                                    <div class="col-6"><?php echo $client_data['contact_tel']; ?><br /><br /></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of panel -->
    </div>
</div>