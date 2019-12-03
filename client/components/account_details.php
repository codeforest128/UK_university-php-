<div class="personal-detaile-sec ">
    <h3 style="margin-bottom: 1em;">Account Details</h3>
    <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel">
            <style>
                #collapseOne {
                    overflow-y: hidden;
                    
                    transition-property: all;
                    transition-duration: 0.5s;
                    transition-timing-function: ease;
                    max-height: 20em;
                }
                #collapseOne.collapseG {
                    max-height: 0;
                }
                .rot180 {
                    transform: rotate(180deg);
                }
            </style>
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <button id="client_details_toggle">
                        Client Details<i class="fa fa-angle-down icon-right rot180"></i>
                    </button>
                </h4>
            </div>
            <script>
                function toggle_tab(evt) {
                    document.getElementById('collapseOne').classList.toggle('collapseG');
                    var i = evt.currentTarget.getElementsByTagName('i')[0];
                    i.classList.toggle('rot180');
                }
                document.getElementById('client_details_toggle').addEventListener(
                    "click",
                    e => {
                        toggle_tab(e);
                    }
                );
            </script>
            <div id="collapseOne" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="panel-body">
                    <div class="form-wrapper">
                        <?php
                            $token = $_COOKIE['SNID'];
                            $client_id = DB::query('SELECT * FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
                            $client_data = DB::query('SELECT * FROM client_details WHERE client_id="' . $client_id . '"')[0];
                        ?>
                        <!-- Panel Content -->
                        <div class="col">
	                        <div class="info">
		                        <div class="table-responsive">
			                        <table class="table m-0">
				                        <tbody>
			               	                <tr>
			               		                <th scope="row">Name:</th>
			                       	            <td><?php echo $client_data['contact_name']; ?></td>
					                        </tr>
			               	                <tr>
			               		                <th scope="row">Company name:</th>
			                                    <td><?php echo $client_data['company_name']; ?></td>
			                                </tr>
			                                <tr>
			                                    <th scope="row">Email:</th>
			                                    <td><?php echo $client_data['contact_email']; ?></td>
			                                </tr>
			                                <tr>
			                                    <th scope="row">Phone:</th>
			                                    <td><?php echo $client_data['contact_tel']; ?></td>
			                                </tr>
				                        </tbody>
			                        </table>
		                        </div>
	                        </div>
                        </div>
                        <!-- /Panel Content -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end of panel -->
    </div>
</div>