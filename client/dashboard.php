<?php
    # Drag in classes
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
    
    # Get constants
    include_once "../arrays.php";

    # Check if logged in      
    if (!Login::isClientLoggedIn()) {
        header("Location: login.php");
    } else {
        $cStrong = true;
        $ajax_token = bin2hex(openssl_random_pseudo_bytes(64, $cStrong));
        setcookie("ajax_ver", $ajax_token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
    }

    # Verify cookies
    if (isset($_COOKIE['SNID'])) {
        $token = $_COOKIE['SNID'];
        $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
        $sectors = "";
        $kind = "";
    }

    # Check if logout has been requested 
    if (array_key_exists('logout', $_POST)) {
        $sql = "DELETE FROM client_login_token "
             . "WHERE client_id = :clientid";
        DB::query($sql, array(':clientid' => Login::isClientLoggedIn()));
        header("Location: login.php");
    }
    
    # Sort out adding notes
    if (array_key_exists('note-submit', $_POST)) {
        
        # Fetch existing notes
        $sql = "SELECT `notes_on_students` FROM `client_details` WHERE `client_id`=:cid";
        $notes = json_decode(DB::query($sql, array(":cid" => $clientid))[0]["notes_on_students"]);
        
        # Update the notes
        $student_id = $_POST["stu_id"];
        $student_notes = array();
        $amount = $_POST["amount"] + 1;
        for ($i = 0; $i < $amount; $i++) {
            if (isset($_POST["note-date-" . $i])) {
                $date = $_POST["note-date-" . $i];
            } else {
                $date = date();
            }
            $c_data = array("date" => $date, "note" => $_POST["note-" . $i]);
            $student_notes[$i] = $c_data;
        }
        
        $notes[$student_id] = $student_notes;
        
        # Update database
        $sql = "UPDATE `client_details` SET `notes_on_students`=:notes WHERE `client_id`=:cid";
        DB::query($sql, array(":notes" => json_encode($notes), ":cid" => $clientid));
    }
    
    
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets_analytics/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets_analytics/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets_analytics/libs/css/style.css">
    <link rel="stylesheet" href="../assets_analytics/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets_analytics/vendor/vector-map/jqvmap.css">
    <link href="../assets_analytics/vendor/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets_analytics/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="../assets_analytics/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="../assets_analytics/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" type="text/css" href="../assets_analytics/vendor/daterangepicker/daterangepicker.css" />
    <title>VCH Clientside | Dashboard</title>
</head>

<?php
    # Begin forming document
    $page_title = "Analytics";
    include_once "components/header.php";
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
	
    # Get constants
    include_once "../arrays.php";
     # Check if logged in      
     if (!Login::isClientLoggedIn()) {
        header("Location: login.php");
    } else {
        $cStrong = true;
        $ajax_token = bin2hex(openssl_random_pseudo_bytes(64, $cStrong));
        setcookie("ajax_ver", $ajax_token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
    }

    # Verify cookies
    if (isset($_COOKIE['SNID'])) {
        $token = $_COOKIE['SNID'];
        $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
        $sectors = "";
        $kind = "";
    }

    # Check if logout has been requested 
    if (array_key_exists('logout', $_POST)) {
        $sql = "DELETE FROM client_login_token "
             . "WHERE client_id = :clientid";
        DB::query($sql, array(':clientid' => Login::isClientLoggedIn()));
        header("Location: login.php");
    }
?>

<?php
    # Begin forming document
    $page_title = "Account";
    include_once "components/header.php";
?>

<?php
    # Begin forming document
    $page_title = "Dashboard";
    include_once "components/header.php";
?>

<style>

.navbar-nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: inherit !important;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}
</style>

<body>

    <?php
        include_once "components/new_navbar.php";
    ?>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-finance">
                <div class="container-fluid dashboard-content" style="margin: -107px 0px 0px 0px;">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h3 class="mb-2">Recruitment Dashboard</h3>
                                <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                   
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                  
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Total Contacts</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"> 
										<?php
										
							$contacts = DB::query('SELECT * FROM contacts WHERE client_id="' . $clientid . '"');
							echo count($contacts);
							
							?>
			</h1>
                                    </div>
                            
                                </div>
                          
                            
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Total Shortlisted</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">
										<?php $shortlist = DB::query('SELECT * FROM short_list WHERE client_id="' . $clientid . '"');
										
										echo count($shortlist);
										?>
										</h1>
                                    </div>
                                 
                                </div>
               
                              
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Total emails</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">
										<?php 
										
										$total_email = DB::query('SELECT * FROM inhouse_email_tracking WHERE client_id="' . $clientid . '"');

										$emailed = array();

										foreach ($total_email as $keyTe => $valueTe) {

											try
								            {
								             $json_obj =   json_decode($valueTe['student_ids']);
								            }
								            catch (ErrorException $e)
								            {
								              $json_obj = array();
								            }

								            foreach ($json_obj as $key => $value) {
								            	$emailed[] = $value;
								            }
										
										}

										$emailed = array_unique($emailed);

										echo count($emailed);
										
										?></h1>
                                    </div>
                               
                                </div>
                            
                              
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Database count</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php 
										
										$users = DB::query('SELECT * FROM users ');
										echo count($users);
										
										?></h1>
                                    </div>
                               
                                </div>
                               
                           
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end revenue year  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- ap and ar balance  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Male to Female balance
                                </h5>
                                <p style="margin-left:20px;">The percentages will not add up 100 and the difference are those who prefer not to say/ other or non-binary</p>
                                <div class="card-body">
                                    <canvas id="chartjs_balance_bar_mf"></canvas>
                                    <!-- <canvas id="chartjs_balance_bar"></canvas> -->
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end ap and ar balance  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- gross profit  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Database: STEM Ratio</h5>
                                <div class="card-body">
                                    <div id="morris_gross" style="height: 272px;"></div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end gross profit  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- profit margin  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">STEM:Humanities Ratio</h5>
                                <div class="card-body">
                                    <div id="morris_profit" style="height: 272px;"></div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end profit margin -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- earnings before interest tax  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Weekly emails</h5>
                                <div class="card-body">
                                    <div id="ebit_morris"></div>
                                    <div class="text-center">
                                        <span class="legend-item mr-3">
                                                <span class="fa-xs text-secondary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                        <span class="legend-text">Weekly emails</span>
                                        </span>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end earnings before interest tax  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- cost of goods  -->
                        <!-- ============================================================== -->
                      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Types</h5>
                                <div class="card-body">
                                    <div id="account" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>


                        <!-- ============================================================== -->
                        <!-- end cost of goods  -->
                        <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">By Nationality Source</h5>
                                    <div class="card-body p-0" style="max-height: 300px; overflow-y: scroll;">
                                        <ul class="country-sales list-group list-group-flush">
                                        	<?php 

                                        	$region_contacted = DB::query('SELECT posts.nationality,COUNT(posts.nationality) as total FROM contacts LEFT JOIN posts ON contacts.student_id = posts.user_id WHERE contacts.client_id="' . $clientid . '" GROUP BY posts.nationality;');


                                        	foreach ($region_contacted as $keyRC => $valueRC) { if($valueRC['nationality']!=''){ ?>
                                        		<li class="country-sales-content list-group-item"><span class="mr-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> </span>
                                                <span class=""><?php echo $valueRC['nationality'];?></span><span class="float-right text-dark"><?php echo $valueRC['total'];?></span>
                                            </li>
                              

                                        <?php }	} ?>
                                            
                                        </ul>
                                    </div>
                                
                                </div>
                            </div>
                    </div>
                    <div class="row">



                    	                  		<?php

										
							$contacts = DB::query('SELECT contacts.*, posts.gender FROM contacts LEFT JOIN posts ON contacts.student_id = posts.user_id WHERE contacts.client_id="' . $clientid . '"');

							$short_list = DB::query('SELECT short_list.*, posts.gender FROM short_list LEFT JOIN posts ON short_list.student_id = posts.user_id WHERE short_list.client_id="' . $clientid . '"');

							$posts = DB::query('SELECT user_id,gender,nationality FROM posts');

                    	$steam_contacted = DB::query('SELECT posts.course,COUNT(posts.course) as total FROM contacts LEFT JOIN posts ON contacts.student_id = posts.user_id WHERE contacts.client_id="' . $clientid . '" GROUP BY posts.course;');

                    	$type_contacted = DB::query('SELECT posts.type,COUNT(posts.type) as total FROM contacts LEFT JOIN posts ON contacts.student_id = posts.user_id WHERE contacts.client_id="' . $clientid . '" GROUP BY posts.type;');


							$contact_male = 0;
							$contact_female = 0;
							$shortlist_male = 0;
							$shortlist_female = 0;
							$email_male = 0;
							$email_female = 0;






							$contact_percent = 0;
							$shortlist_percent = 0;

							if (count($contacts)!=0 && count($users)!=0) {
								$contact_percent = count($contacts)*100/count($users);
								
								$contact_percent = sprintf('%0.2f', $contact_percent); 
							}

							if (count($short_list)!=0 && count($users)!=0) {
								$shortlist_percent = count($short_list)*100/count($users);
								
								$shortlist_percent = sprintf('%0.2f', $shortlist_percent); 
							}

							


							foreach ($contacts as $keyC => $valueC) {
								if ($valueC['gender']=='Female') {
									$contact_female++;
								}
								if ($valueC['gender']=='Male') {
									$contact_male++;
								}
							}

							foreach ($short_list as $keyS => $valueS) {
								if ($valueS['gender']=='Female') {
									$shortlist_female++;
								}
								if ($valueS['gender']=='Male') {
									$shortlist_male++;
								}
							}


							foreach ($emailed as $keyEm => $valueEm) {
								foreach ($posts as $keyP => $valueP) {
									if($valueP['user_id']==$valueEm && $valueP['gender']=='Female'){
										$email_female++;
									}
									if($valueP['user_id']==$valueEm && $valueP['gender']=='Male'){
										$email_male++;
									}
								}
							}

							$days = [];
							$days[1] = 'Monday';
							$days[2] = 'Tuesday';
							$days[3] = 'Wednesday';
							$days[4] = 'Thursday';
							$days[5] = 'Friday';
							$days[6] = 'Saturday';
							$days[7] = 'Sunday';

							$week = array();

							$current_day_key = 0;

							foreach ($days as $keyD => $valueD) {
								if(date('l')==$valueD){
									$current_day_key = $keyD;
								}
							}

							foreach ($days as $keyD => $keyD) {

							   $difference = $keyD - $current_day_key;
							   	$date=date_create(date('Y-m-d'));
							   	if($difference<0){
							   		date_modify($date,$difference." days");
							   	}
							   	if($difference>0){
							   		date_modify($date,"+".$difference." days");
							   	}

							   	$week[$keyD] = array('day'=>$keyD,'date'=>date_format($date,"Y-m-d")) ;

							}


							foreach ($week as $keyWk => $valueWk) {
								$totals = 0;
							    foreach ($total_email as $keyEm => $valueEm) {
							    	if (date('Y-m-d',strtotime($valueEm['date_occured']))==$valueWk['date']) {
							    		$totals++;
							    	}
							    }
							    $week[$keyWk]['total'] = $totals;
							}


                            $Science = 0;
                            $Manage = 0;
                            $Engineering = 0;
                            $Maths = 0;
                            $total_subjects = 0;

                            $steam_total = 0;

                            foreach ($steam_contacted as $keySC => $valueSC) {


                                     if(stripos($valueSC['course'],"Science")>-1){
                                        $Science += $valueSC['total'];
                                     }

                                     if(stripos($valueSC['course'],"Engin")>-1){
                                        $Engineering += $valueSC['total'];
                                     }

                                     if(stripos($valueSC['course'],"Manage")>-1){
                                        $Manage += $valueSC['total'];
                                     }

                                     if(stripos($valueSC['course'],"Math")>-1){
                                        $Maths += $valueSC['total'];
                                     }

                                     $steam_total += $valueSC['total'];

                             }

                             $total_subjects = $Science+$Manage+$Engineering+$Maths;

                             $subjects = array();

                             $subjects['Science'] = 0;

                             if ($Science!=0 && $total_subjects!=0) {
                                $per = $Science*100/$total_subjects;
                                $subjects['Science'] = sprintf('%0.2f', $per);
                             }

                             $subjects['Management'] = 0;

                             if ($Science!=0 && $total_subjects!=0) {
                                $per = $Manage*100/$total_subjects;
                                $subjects['Management'] = sprintf('%0.2f', $per);
                             }

                             $subjects['Engineering'] = 0;

                             if ($Science!=0 && $total_subjects!=0) {
                                $per = $Engineering*100/$total_subjects;
                                $subjects['Engineering'] = sprintf('%0.2f', $per);
                             }


                             $subjects['Maths'] = 0;

                             if ($Science!=0 && $total_subjects!=0) {
                                $per = $Maths*100/$total_subjects;
                                $subjects['Maths'] = sprintf('%0.2f', $per);
                             }


                             $steam_percent = 0;
                             if ($total_subjects!=0 && $steam_total!=0) {
                                 $steam_percent = $total_subjects*100/$steam_total;
                                 $steam_percent = sprintf('%0.2f', $steam_percent);
                             }




?>



                    	
                        <!-- ============================================================== -->
                        <!-- overdue invoices  -->
                        <!-- ============================================================== -->
                       
                        <!-- ============================================================== -->
                        <!-- end overdue invoices  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- disputed invoices  -->
                        <!-- ============================================================== -->
                       
                        <!-- ============================================================== -->
                        <!-- end disputed invoices  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- account payable age  -->
                        <!-- ============================================================== -->
                       
                        <!-- ============================================================== -->
                        <!-- end account payable age  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- working capital  -->
                        <!-- ============================================================== -->
                 
                    <!-- ============================================================== -->
                    <!-- end inventory turnover -->
                    <!-- ============================================================== -->
                </div>
            </div>
            <!-- ============================================================== -->
 
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- jquery 3.3.1  -->
    <script src="../assets_analytics/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="../assets_analytics/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../assets_analytics/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chart chartist js -->
    <script src="../assets_analytics/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <script src="../assets_analytics/vendor/charts/chartist-bundle/Chartistjs.js"></script>
    <script src="../assets_analytics/vendor/charts/chartist-bundle/chartist-plugin-threshold.js"></script>
    <!-- chart C3 js -->
    <script src="../assets_analytics/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../assets_analytics/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <!-- chartjs js -->
    <script src="../assets_analytics/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="../assets_analytics/vendor/charts/charts-bundle/chartjs.js"></script>
    <!-- sparkline js -->
    <script src="../assets_analytics/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- dashboard finance js -->
    <script src="../assets_analytics/libs/js/dashboard-finance.js"></script>
    <!-- main js -->
    <script src="../assets_analytics/libs/js/main-js.js"></script>
    <!-- gauge js -->
    <script src="../assets_analytics/vendor/gauge/gauge.min.js"></script>
    <!-- morris js -->
    <script src="../assets_analytics/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../assets_analytics/vendor/charts/morris-bundle/morris.js"></script>
    <!-- <script src="../assets_analytics/vendor/charts/morris-bundle/morrisjs.html"></script> -->
    <!-- daterangepicker js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
    </script>
	
	<?php
    include_once "components/new_footer.php";
?>




<script type="text/javascript">
	

	 // ============================================================== 
    // Chart Balance Bar
    // ============================================================== 
    var ctx = document.getElementById("chartjs_balance_bar_mf").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',

        
        data: {
            labels: ["Contacts", "Shortlist", "Emailed"],
            datasets: [{
                label: 'Male',
                data: [<?php echo $contact_male; ?>, <?php echo $shortlist_male; ?>, <?php echo $email_male; ?>],
                backgroundColor: "#252772",
                borderColor: "#252772",
                borderWidth:2

            }, {
                label: 'Female',
                data: [<?php echo $contact_female; ?>, <?php echo $shortlist_female; ?>, <?php echo $email_female; ?>],
                backgroundColor: "#E1BA55",
                borderColor: "#E1BA55",
                borderWidth:2


            }]

        },
        options: {
            legend: {
                    display: true,

                    position: 'bottom',

                    labels: {
                        fontColor: '#000138',
                        fontFamily:'Circular Std Book',
                        fontSize: 14,
                    }
            },

                scales: {
                    xAxes: [{
                ticks: {
                    fontSize: 14,
                     fontFamily:'Circular Std Book',
                     fontColor: '#000138',
                }
            }],
            yAxes: [{
                ticks: {
                    fontSize: 14,
                     fontFamily:'Circular Std Book',
                     fontColor: '#000138',
                }
            }]
                }
    }



});



    	 // ============================================================== 
    // Contact chart
    // ============================================================== 




    // Morris.Donut({
    //             element: 'morris_gross',

    //             data: [
    //             <?php foreach ($steam_contacted as $keySc => $valueSc) {  if($valueSc['course']!=''){ 

    //             	$current_per = 0;

    //             	if ($valueSc['total']!=0 && count($contacts)!=0){
    //             		$current_per = $valueSc['total']*100/count($contacts);
    //             		$current_per = sprintf('%0.2f', $current_per);

    //             	}

    //             	?>
    //             	{ value: <?php  echo $current_per;?>, label: "<?php echo $valueSc['course'];?>" },
    //            <?php } } ?>
    //             ],
             
    //             labelColor: '#5969ff',

    //             colors: [
    //                 '#5969ff',
    //                 '#a8b0ff'
                   
    //             ],

    //             formatter: function(x) { return x + "%" },
    //               resize: true

    //         });


        Morris.Donut({
                element: 'morris_gross',

                data: [
                <?php foreach ($subjects as $keySc => $valueSc) { 

                    ?>
                    { value: <?php  echo $valueSc;?>, label: "<?php echo $keySc;?>" },
               <?php } ?>
                ],
             
                labelColor: '#000138',

                colors: [
                    '#A9B0FF',
                    '#252772'
                   
                ],

                formatter: function(x) { return x + "%" },
                  resize: true

            });

 	// ============================================================== 
    // shortlist
    // ============================================================== 



    Morris.Donut({
                element: 'morris_profit',

                data: [
                    { value: <?php echo $steam_percent; ?>, label: 'STEM' },
                    { value: <?php echo 100-$steam_percent; ?>, label: 'Humanities' }
                   
                ],
             
                labelColor: '#000138',


                colors: [
                    '#F7EBD1',
                    '#E1BA55'
                   
                ],

                formatter: function(x) { return x + "%" },
                  resize: true

            });

    // ============================================================== 
    // Weekly Email
    // ============================================================== 



    Morris.Bar({
        element: 'ebit_morris',
        data: [
        <?php foreach ($week as $keyWK => $valueWK) { ?>
            { x: '<?php echo $valueWK["date"]; ?>',y: <?php echo $valueWK['total']?> },
        <?php } ?>
        ],
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Emails'],
        barColors: ['#252772'],
        xLabelMargin: 10,
        preUnits: [""]

    });


        // ============================================================== 
    // Nationality
    // ============================================================== 


    var chart = c3.generate({
        bindto: "#account",
        color: { pattern: ["#282A7D", "#E6C574", "#A9B0FF", "#F7EBD1"] },
        data: {
            // iris data from R
            columns: [
            <?php  foreach ($type_contacted as $keyTC => $valueTC) { if($valueTC['type']!=''){ ?>
            	["<?php echo $valueTC['type'];?>", <?php echo $valueTC['total'];?>],
            <?php } } ?>

            ],
            type: 'pie',
            
        }
    });

    setTimeout(function() {
        chart.load({
            
        });
    }, 1500);

    setTimeout(function() {
        chart.unload({
            ids: 'data1'
        });
        chart.unload({
            ids: 'data2'
        });
    }, 
    2500
    );



</script>



</body>
</html>
