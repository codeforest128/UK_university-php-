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

<?php
    # Include search filter parsing
    include_once "search_parsing.php";
?>

<?php
    # Begin forming page
    $page_title = "Database";
    include_once "components/header.php";
?>
    
<!-- Add main database page elements -->
<link href="css/database.css" type="text/css" rel="stylesheet" />
<script src="scripts/db_global_var.js"></script>
<script src="scripts/client_http_req.js"></script>
<script src="scripts/candidate-actions.js"></script>
<script src="scripts/aesthetic/tabs.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script>
    $(document).on('change','#selection_type',function(e){
        
        var value = $(this).val();
        if(value=="ALL" || value=="SEL") {
            $('#select_all_info_basic').css('display','none');
      $('#smart_search_button').css({'background-color':'#fff','pointer-events':'visible'});
        }  else {
            $('#select_all_info_basic').css('display','block');
      $('#smart_search_button').css({'background-color':'#ddd','pointer-events':'none'});
        }
    });
    
    /*$(document).on('click','.submit-search',function(e) {
        e.preventDefault();
        $('#loader').css('display','block');
        $('body').css('opacity','.5');
        $('body').css('position','relative');
        //setTimeout(function(){$('#smartf').submit()},3000);
    });*/
  <?php if(isset($_POST['search-type'])){ ?>
  $(document).ready(function(){
    
    var sess = sessionStorage.getItem("tbname");
    if(sess=="search_tab") {
      $('#basic_search_button').addClass('active');
      $('#smart_search_button').removeClass('active');
      $('#smart_search_tab.closed_search_tab').css('right','-100%');
      $('#search_tab').css('right','0');
    } else if(sess=="smart_search_tab") {
      $('#search_tab').css('right','100%');
      $('#smart_search_tab.closed_search_tab').css('right','0');
      $('#smart_search_button').addClass('active');
      $('#basic_search_button').removeClass('active');
    }
    $('#loader').css('display','none');
  });  
    
  <?php } ?>
    
</script>
<Style>
  
  .load {
    left: 45%;
    position: fixed;
    margin: 50px auto;
    width: 100px;
    height: 80px;
    top: 30%;
    z-index: 9;
  }
  .load:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
  }
.gear {
  position: absolute;
  z-index: -10;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 5s infinite;
          animation: spin 5s infinite;
}

.two {
  left: 40px;
  width: 80px;
  height: 80px;
  -webkit-animation: spin-reverse 5s infinite;
          animation: spin-reverse 5s infinite;
}

.three {
  top: 45px;
  left: -10px;
  width: 60px;
  height: 60px;
}

@-webkit-keyframes spin {
  50% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}

@keyframes spin {
  50% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
@-webkit-keyframes spin-reverse {
  50% {
    -webkit-transform: rotate(-360deg);
            transform: rotate(-360deg);
  }
}
@keyframes spin-reverse {
  50% {
    -webkit-transform: rotate(-360deg);
            transform: rotate(-360deg);
  }
}
.lil-circle {
  position: absolute;
  border-radius: 50%;
  box-shadow: inset 0 0 10px 2px gray, 0 0 50px white;
  width: 100px;
  height: 100px;
  opacity: .65;
}

.blur-circle {
  position: absolute;
  top: -19px;
  left: -19px;
}

.text {
  color: lightgray;
  font-size: 18px;
  font-family: 'Open Sans', sans-serif;
  text-align: center;
}
</Style>
<body>
    <?php
        include_once "components/new_navbar.php";
    ?>

<section class="body">
    <div class="load" id="loader" style="display:none">
  <div class="gear one">
    <svg id="blue" viewbox="0 0 100 100" fill="#94DDFF">
      <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
    </svg>
  </div>
  <div class="gear two">
    <svg id="pink" viewbox="0 0 100 100" fill="#FB8BB9">
      <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
    </svg>
  </div>
  <div class="gear three">
    <svg id="yellow" viewbox="0 0 100 100" fill="#FFCD5C">
      <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
    </svg>
  </div>
  <div class="lil-circle"></div>
  <svg class="blur-circle">
    <filter id="blur">
      <fegaussianblur in="SourceGraphic" stddeviation="13"></fegaussianblur>
    </filter>
    <circle cx="70" cy="70" r="66" fill="transparent" stroke="transparent" stroke-width="40" filter="url(#blur)"></circle>
  </svg>
</div>
    <div class="heading">
        <div class="leftheading">
          <!--<div class="lhtop">-->
            <!-- Uncertain what to use this space for? -->
             <label style="margin-left:20px;" class="view_toggle" id="view_check_cont">
                    <p style="display:inline">Profile/table view</p>
                    <input type="checkbox" name="use_filters" id="view_check"/>
                    <i class="fa fa-toggle-on unchecked"></i>
                    <i class="fa fa-toggle-off checked"></i>
                </label>
            <div class="lhbottom">
                <!--<h3 id="page-title">OCH Client Platform</h3>-->
            </div>
        </div>
        <div class="rightheading">
            <div class="centerheading" id="listing_options_basic">
                <div class="chtop">
                    <div class="chtopleft">
                        <!-- Candidate count -->
                         <p id="sel_count_basic">0 candidates</p>
                        <p>selected</p>
                        
                        <!--<div style="display: none;" id="deselect_info_basic">
                            <p>Deselect all</p>
                        </div>-->
            <br/>
                <label><input type="checkbox" value="" id="che_all" onclick="chk_unchk(this)"> Select All/ Deselect All</label>
            

            <!----button class="deselect_all" id="deselect_all_button_basic" onclick="deselect_all_cand()"><span style="display:inline-flex;width:200px"><i class="fa fa-check-circle" style="padding-right:5px;padding-top:3px"></i>Select All/ Deselect All</span></button-------------->
                        <!--<button class="select_all_button" id="select_all-SHRT" onclick="select_all_cand(event)" style="display: none;"><span><i class="fa fa-check-circle"></i></span></button>
                        <button class="select_all_button" id="select_all-CNTCT" onclick="select_all_cand(event)" style="display: none;"><span><i class="fa fa-check-circle"></i></span></button>-->
          <!--  <button class="select_all_button" id="select_all-SHRT" onclick="select_all_cand(event)" style="display: none;"><input type="checkbox" /></button>
                        <button class="select_all_button" id="select_all-CNTCT" onclick="select_all_cand(event)" style="display: none;"><input type="checkbox" /></button>
                        <div style="display: none;" class="select_all_info" id="select_all_info_basic">
                            <p>Select all</p>
                        </div>-->
                        
                        <!--<span>
                            <input type="checkbox" name="use_filters" id="filter_check" style="background: none; border: none;" checked/>
                            <i class="fa fa-toggle-on"></i>
                        </span>-->
                        <!--<div style="display: none;" id="use_filter_info">
                            <p>Toggle filters<p><br/>
                            <p>(Checked = Using filters)</p>
                        </div>-->
            
                    </div>
          
                    <div class="chtopright">
                        <!-- Candidates per page -->
                        <p class="cperpage" style="">Max results per page</p>
                      <label class="filter_toggle" style="" id="filter_check">
                            <input type="checkbox" name="use_filters" id="filter_check"/>
                       <!--     <i class="fa fa-toggle-on checked"></i>
                            <i class="fa fa-toggle-off unchecked"></i> -->
                        </label>
                        <span id="max-results-info-hover"><i class="fa fa-question-circle"></i></span>
                       <!-- <div class="invisible" id="max-results-info-container">
                            <h5>Decrease this to increase load speed</h5>
                            <p>N.B. Only results relevant to you will be shown</p>
                            <p>Hence maximum rather than actual results displayed</p>
                        </div>-->
                        <script src="scripts/aesthetic/results_info.js"></script>
                        <select id="max_results" class="c_select_options">
                            <option value=25>25</option>
                            <option value=50>50</option>
                            <option value=75>75</option>
                            <option value=100>100</option>
                        </select><br/>
                        <!-- Select list you're viewing -->
                        <p class="cperpage">List to view</p>
                        <select id="selection_type" style="width: 50%;" class="c_select_options">
                            <option value="ALL">All</option>
              <option value="SHRT">Shortlist</option>
                            <option value="CNTCT">Contacts</option>
                            <option value="SEL">Selected</option>
                        </select>
                        <script src="scripts/event_listeners/list_options.js"></script>
                    </div>
                </div>
                <!-- Candidate navigation, i.e. which page -->
                <div class="chbottom" id="pagination_container_full">
                    <!-- Previous button -->
                    <div class="chbottomleft">
                        <button onclick="change_offset(0, -1)" id="prev_button" class="prev"><span class="fa fa-angle-left"></span></button>
                    </div>
                    <!-- Middle buttons -->
                    <div class="chbottomcentre">
                        <button id="nav-button-1" value="1" onclick="change_offset(1, event)">1</button>
                        <button id="nav-button-2" value="2" onclick="change_offset(1, event)">2</button>
                        <button id="nav-button-3" value="3" onclick="change_offset(1, event)">3</button>
                        <button id="nav-button-4" value="4" onclick="change_offset(1, event)">4</button>
                        <button id="nav-button-5" value="5" onclick="change_offset(1, event)">5</button>
                    </div>
                    <!-- Next button -->
                    <div class="chbottomright">
                        <button onclick="change_offset(0, 1)" id="next_button" class="next"><span class="fa fa-angle-right"></span></button>
                    </div>
                    <!-- Nagivation script -->
                    <script src="scripts/pagination/navigation.js"></script>
                </div>
            </div>
            <div class="centerheading" id="listing_options_smart" style="display: none;">
               <div class="chtop">
                   <div class="chtopleft">
                       <button class="deselect_all" id="deselect_all_button_smart" onclick="deselect_all_cand()"><span><i class="fa fa-trash"></i></span></button>
                        <div style="display: block;" id="deselect_info_smart">
                            <p>Deselect all</p>
                        </div>
                        <p id="sel_count_smart" style="margin-left: 25px;">0 candidates</p>
                        <p>selected</p>
                        <br/>
                        <button class="select_all_button" id="select_all-SMRT" onclick="select_all_cand(event)"><span><i class="fa fa-check-circle"></i></span></button>
                        <div style="display: block;" class="select_all_info" id="select_all_info_smart">
                            <p>Select all</p>
                        </div>
                   </div>
               </div>
               <div class="chtbottom">
                   
               </div>
            </div>
            <script src="scripts/event_listeners/top_left_buttons.js"></script>
            <div class="fullrightheading">
                <h5 style="font-weight:bold; margin-bottom: 0;">Bulk Actions</h5>
                <div class="top_ba">
                    <div id="shortlist_cand_bulk_cont" class="bulk_action_button">
                        <button class="sendemail" onclick="shortlist_selected_candidates()"><i class="fa fa-list-alt "></i> Shortlist</button>
                    </div>
                    <div id="email_cand_bulk_cont" class="bulk_action_button">
                        <button data-toggle="modal" data-target="#bulk_email" data-backdrop="static" class="sendemail"  onclick="set_student_ids()"  id="myBtn">Email</button>
                    </div>
          <div id="access_details_bulk_cont" class="bulk_action_button">
                        <button class="accessdetails" onclick="access_details_selected_candidates()">Access details</button>
                    </div>
                    <div id="download_excel_bulk_cont" class="bulk_action_button" style="display: none;">
                        <button class="downloadexcel" id="myBtn1" disabled>Download as Excel</button>
                        <div class="greyed-out-bulk-action"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="leftbody">
        <!-- This has to handle all the searches et cetra -->
        <?php include_once "components/search_bar.php"; ?>
    </div>
    <style>
        table {
            margin: 0 5%;
            margin-bottom: 0 !important;
            text-align: center;
            width: 90% !important;
            box-shadow: 1px 3px 5px rgba(134, 127, 127, 1);
            border: 1px solid grey;
            border-collapse: 0;
        }
        
        thead.table_header {
            border-bottom: 1px solid grey;
        }
        
        th {
            background: white;
            padding: 2px;
            margin: 0;
            border-left: 1px solid grey;
            font-size: 90%;
            height: 2.5em;
        }
        
        .icon_cont span i {
            height: 2.5em;
            transform: translate(0, 1.3em);
        }
        
        tbody#table_contents {
            overflow-y: scroll;
        }
            
        tbody#table_contents tr {
            height: 2em;
        }
    
        tbody#table_contents tr td {
            background: #fff;
            padding: 5px;
            margin: 0;
            border-left: 1px solid grey;
            font-size: 80%;
        }
        
        tr#stu_slot_0 td {
            border-top: 0;
        }
        
        div.table_container {
            height: 96.6%;
            overflow-y: scroll;
        }
        
        td button {
            border: 1px solid black;
            border-radius: 5px;
            height: 1.5em;
            width: 1.5em;
            background: #fff;
        }
        
        td button.checked {
            background: #04003c;
            color: #fff;
            padding: 0;
        }


        th button {
            border: 1px solid black;
            border-radius: 5px;
            height: 1.5em;
            width: 1.5em;
            background: #fff;
        }
        
        th button.checked {
            background: #04003c;
            color: #fff;
            padding: 0;
        }
    </style>


    <?php  if (isset($_SESSION['mail_sended'])) { ?>

<div class="modal" id="flash_mail">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Email Sended To,</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table">

          <?php foreach ($_SESSION['mail_sended'] as $keyES => $valueES) { ?>
            <tr>
              <td><?php echo $keyES;?></td>
              <td><?php echo $valueES;?></td>
            </tr>
           <?php } ?>
          
        </table>
        
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $('#flash_mail').modal('show');
  
</script>

<?php 

unset($_SESSION['mail_sended']);

} ?>

         

    <div id="table_view" class="rightbody" style="display: none;">
        <div class="table_container">

          <table id="student_alls" class="display" width="100%"></table>
          

            <table class="table">
                <thead class="table_header">
                    <tr>
            <th class="text-center">
                          <button id="all_stud" onclick="check_all(this,'studentlist')"></button>
                        </th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Grade</th>
                        <th>University</th>
                        <th>College</th>
                        <th>Grad Year</th>
                        <th class="text-center">
                        <button  onclick="check_all(this,'shortlist')"></button>
                        <span><i class="fas fa-list-alt" style="padding:8px 2px 0px 2px"></i></span>
                        </th>
                        <th class="icon_cont"><span><i class="fa fa-envelope"></i></span></th>
                        <th class="text-center">
                          <button  onclick="check_all(this,'contact')"></button><br>
                          <span><i class="fas fa-address-book" style="padding:8px 2px 0px 2px"></i></span>
                        </th>
                        <th class="icon_cont"><span><i class="fas fa-file-download"></i></span></th>
                       <!----th class="icon_cont"><span><i class="fas fa-file-alt"></i></span></th---->
                    </tr>
                </thead>
                <tbody id="table_contents"></tbody>
            </table>











<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Email</h4>
      </div>
      <div class="modal-body">
        <label>Email</label>
        <input type="readonly" id="email_input" readonly="" class="form-control">
        <br>
        <label>Message</label>
        <textarea class="form-control" rows="8" id="message_input"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="send_email()" class="btn btn-default" >Send</button>
      </div>
    </div>

  </div>
</div>


        
        </div>
    </div>
    <div id="card_view" class="rightbody">
        <!-- This script handles all updating the center frame -->
        <script src="scripts/pagination/main2.js"></script>
        <!-- This div contains all the students filtered/selected -->
        <div class="center" id="candidates_container"></div>
        <div class="right">
            <!-- Simply displays the one candidate selected -->
            <div class="rightview" id="selected_candidate">
                <?php
                    if (isset($_GET["cv"]) && $_GET["cv"] == "true") {
                        include_once "components/selected_candidate_and_cv.php";
                    } else if (isset($_GET["cv_latest"])) {
                        include_once "components/selected_candidate_and_cv.php";
                    } else {
                ?> 
                    <div class="sel_cand_placeholder"><h4>Select a candidate to view more details</h4></div>
                <?php
                    }
                ?>
            </div>
            <div id="ajax_ver"><?php echo $ajax_token; ?></div>
            <script src="scripts/aesthetic/tabs.js"></script>
        </div>
    </div>
</section>
<script>
    update_center();
</script>

<style>
.invisibles.email-infos.collapsed.pressed {
    position: absolute;
    background: #fff;
    top: 4%;
    right: 1rem;
    border-radius: 5px;
    z-index: 4;
    border: 1px solid rgb(169, 169, 169);
    padding: 5px;
    transform: translate(1px, -1px);
    width: 90%;
    padding-top: 20px;
}
</style>


<?php
    # Close off page (includes some modals that may not apply?)
    include_once "components/new_footer.php";
?>

<div class="modal" id="bulk_email">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Please compose your email</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="helper-information-container">
                <span style="cursor: pointer;" class="email-helper-info" id="bulk-email-helper">i</span>
                <div style="display:none;" class="invisibles email-infos" id="email-info-bulks">
                    <h4>Here are some tools to help you customise your email:</h4>
                    <p>1. The phrase "{{fname}}" will be replaced with the candidates first name</p>
                    <p style="text-indent: 40px">     a) For example "Dear {{fname}},"</p>
                    <p>2. You can also personalise your emails further using your own HTML formatting, if you would prefer plain text then all new lines will still be preserved.</p>
                </div>
            </div>
      
            <form action="dispatch_bulk_email.php" method="POST" class="bulk_email_form">
                <input type="hidden" name="bulk" value="1"/>
                <input type="hidden" name="student-ids" id="email-students-list"/>
                <!--<span id="email_show"></span>-->
                <br>
                <label style="display: inline;">Html formatting:</label>
                <input type="checkbox" name="plain_text" value="off"/>
                <label class="btn-secondary">To</label>
                <input type="text" name="from" id="sub_to_mail" style="width : 600px" disabled/>
                <label class="btn-secondary">Subject</label>
                <input type="text" name="email-subject" style="width : 600px"/>
                <label class="btn-secondary">Body</label>
                <textarea id="email-body" name="email-body"></textarea> 
                <button type="submit" onclick="fetch_email_list()" class="btn btn-primary btn-email">Send</button>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="individual_email">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Please compose your email</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="helper-information-container">
                <span style="cursor: pointer;" class="email-helper-info" id="ind-email-helper">i</span>
             <div style="display:none;" class="invisibles email-infos" id="email-info-individuals">
                   <h4>Here are some tools to help you customise your email:</h4>
                    <p>1. The phrase "{{fname}}" will be replaced with the candidates first name</p>
                    <p style="text-indent: 40px">     a) For example "Dear {{fname}},"</p>
                    <p>2. You can also personalise your emails further using your own HTML formatting, if you would prefer plain text then all new lines will still be preserved.</p>
                </div>
            </div>
            <form action="dispatch_bulk_email.php" method="POST" class="bulk_email_form">
                <input type="hidden" name="student-ids" id="email-student-list"/>
                <label style="display: inline;">Html formatting:</label>
                <input type="checkbox" name="plain_text" value="off"/>
                <label class="btn-secondary">To</label>
                <input type="text" name="from" style="width:400px" id="ind_to_mail" disabled/>
                <label class="btn-secondary">Subject</label>
                <input type="text" name="email-subject" style="width : 600px"/>
                <label class="btn-secondary">Body</label>
                <textarea id="email-body" name="email-body"></textarea> 
                <button type="submit" onclick="fetch_email_to()" class="btn btn-primary btn-email">Send</button>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-header h4 {
        display: inline-block;
    }
    
    .modal-header button.close {
        position: absolute;
        top: 1%;
        right: 1%;
        color: black;
    }
    
    form#student_notes_box textarea {
        font-size: 80%;
        min-height: 5em;
    }
    
    button#note-submit {
        float: right;
        background: white;
        border: 1px grey solid;
    }
    
    button#note-submit:hover {
        color: white;
        background: #04003c;
    }
</style>
<div class="modal" id="notes_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add student notes</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="student_notes_box"></form>
            </div>
        </div>
    </div>
</div>

<script src="scripts/aesthetic/email_helper.js"></script>

<section class="smaller-media-cover">
    <h4>Sorry but currently we only support desktop devices</h4>
</section>

<?php
   $token = $_COOKIE['SNID'];
    $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];

    $client_data = DB::query('SELECT * FROM clients WHERE id=' . $clientid . '');

    if ($client_data[0]['privacy'] == 0) {
?>
  <!-- The Modal -->
  <div class="modal" id="privacy_mdl">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Privacy Policy</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body text-center">

          <style type="text/css">
            .und {
              border: 0;
              outline: 0;
              background: transparent;
              border-bottom: 1px solid black;

            }

            .eql {
              width: 66%;
            }
          </style>

          <form action="" onsubmit="get_image_data(event)" method="post">

            <!----p><input type="text" class="und" name="p1" required>, a company incorporated in <input type="text" class="und" name="p2" required> under registration number <input type="text" class="und" name="p3" required> whose registered office is at <input type="date" class="und" name="p4" required></p------------>
            <p> By continuing to use the site you agree to the Oxbridge Careers Hub <a href="Agreement_for_the_Sharing_of_Data.pdf">Agreement for the Sharing of Data</a>, <a href="../TermsofUse.pdf">Terms of Use</a> and <a href="../Privacypolicy.pdf">Privacy Policy</a>. Please read these before accessing the site, particularly the Agreement for the Sharing of Data.</p>
            <center>
              <input type="text" class="form-control text-center eql" name="company_name" placeholder="Company name" required>
              <br />
              <input type="text" class="form-control text-center eql" name="signer_name" placeholder="Signer name" required>
              <br />
            </center>

            <label>Sign Here (use mouse)</label>

            <center>
              <div id="captureSignature" class="kbw-signature"></div>
            </center>
            <br />
            <button class="btn btn-info" type="button" id="clear2Button">Clear Sign Area</button>
            <br />
            <br />

            <textarea id="signatureJSON" name="signature" rows="5" cols="50" readonly="" class="ui-state-active" style="display: none;"></textarea>

            <button type="submit" class="btn btn-primary btn-block">Accept</button>
          </form>
          <!--------p style="clear: both;"><span class="demoLabel">&nbsp;</span>
        As <label><input type="radio" name="syncFormat" value="JSON" checked=""> JSON</label>
              <label><input type="radio" name="syncFormat" value="SVG"> SVG</label>
        (<input type="checkbox" id="svgStyles"> <label for="svgStyles">with style attribute</label>)
              <label><input type="radio" name="syncFormat" value="PNG"> PNG</label>
              <label><input type="radio" name="syncFormat" value="JPEG"> JPEG</label></p>
              <p><span class="demoLabel">Signature Output:</span>
        </p---------------->

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        </div>

      </div>
    </div>
  </div>
  
  <script type="text/javascript">
    setInterval(function() {
      $('#privacy_mdl').modal('show');
    }, 1000);
  </script>

  <script type="text/javascript">
    
    $(document).ready(function() {

      $('#captureSignature').signature({
        syncField: '#signatureJSON'
      });

      $('#clear2Button').click(function() {
        $('#captureSignature').signature('clear');
      });

      $('input[name="syncFormat"]').change(function() {
        var syncFormat = $('input[name="syncFormat"]:checked').val();
        $('#captureSignature').signature('option', 'syncFormat', syncFormat);
        console.log($('#signatureJSON').val());

        $('#dummy_img').attr('src', $('#signatureJSON').val());
      });

      $('#svgStyles').change(function() {
        $('#captureSignature').signature('option', 'svgStyles', $(this).is(':checked'));
      });



      var syncFormat = 'PNG';
      $('#captureSignature').signature('option', 'syncFormat', syncFormat);
      console.log($('#signatureJSON').val());

      $('#dummy_img').attr('src', $('#signatureJSON').val());


    });

    function get_image_data(eve) {

      if ($(captureSignature).signature('isEmpty') == true) {
        alert('The Signature is Empty');
        eve.preventDefault();
      }
    }
    
  </script>
<?php
    }
?>



<script type="text/javascript">




  var cv_obj = [];

  var users = [];


   $.post("requests/api_get_cv.php",
  {
    name: "Donald Duck",
    city: "Duckburg"
  },
  function(data, status){
    cv_obj = JSON.parse(data);
  });


   $.post("requests/api_get_all_users.php",
  {
    hash: "<?php echo md5(time()); ?>",
  },
  function(data, status){
    users = JSON.parse(data);
    
  });



  $(".view_toggle,.pagination,.noselpagination").click(function(){

  set_cv_download();

  });



  function set_cv_download(){

   var btcx = setInterval(function(){

    var counte = 0;

        $(".cvs").each(function(){
            var element = $(this);
            $.each(cv_obj, function( index, value ) {
              if (value.userid==element.attr('data-id')){
                element.html('<a target="_blank"  href="download_cv.php?file='+value.file_name+'"><i class="fa fa-download"></i></a>');
              }
            });
            counte++;
          });

        if (counte!=0){
          clearInterval(btcx);
        }

        console.log('remap');


         }, 500);


  }



  function check_all(ele,type){

  
   console.log('success');
   
   
    var checked = 0;

    if ($(ele).hasClass('checked')){
      checked = 1;
    }

    if (checked==1){
      $(ele).removeClass('checked');
      $(ele).html('');
    }else{
      $(ele).addClass('checked');
      $(ele).html('<span><i class="fa fa-check"></i></span>');
    }

    if (type == 'studentlist'){
      var id;
      $("[data-type=studentlist_btn]").each(function(){
        if (checked == 1){
            $(this).removeClass('checked');
            $(this).html('')
            $(che_all).prop('checked', false);
            id = $(this).attr('data-id');
            var ind = selected_candidate_ids.indexOf(id);
            if (ind > -1) {
                selected_candidate_ids.splice(ind, 1);
            }
        }
        else{
            $(this).addClass('checked');
            $(this).html('<span><i class="fa fa-check"></i></span>')
            $(che_all).prop('checked', true);
            id = $(this).attr('data-id');
            if (!selected_candidate_ids.includes(id)) {
                update_selected_candidate(id);
                selected_candidate_ids.push(id);
            } 
        }

      })
        var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
        document.getElementById("sel_count_basic").innerHTML = selected_candidate_ids.length + sel;
        document.getElementById("sel_count_smart").innerHTML = selected_candidate_ids.length + sel;
    }
    console.log(selected_candidate_ids)
    if (type=='shortlist'){

      $("[data-type=shortlist_btn]").each(function(){

      if (checked==1){
        shortlist_candidate_api($(this).attr('data-id'),'remove');
        $(this).removeClass('checked');
        $(this).html('');
      }else{
        shortlist_candidate_api($(this).attr('data-id'),'add');
        $(this).addClass('checked');
        $(this).html('<span><i class="fa fa-check"></i></span>');
      }

      });

    }


    if (type=='contact'){

      $("[data-type=contact_btn]").each(function(){

        if (checked==1){

        $(this).removeClass('checked');
        $(this).html('');
        console.log($(this).attr('data-id'));
        access_details($(this).attr('data-id'),this);

        }else{

          $(this).addClass('checked');
        $(this).html('<span><i class="fa fa-check"></i></span>');
        console.log($(this).attr('data-id'));
        access_details($(this).attr('data-id'),this);


        }

      

      });
      
    }

  }


  function shortlist_candidate_api(ids,type){

    $.post("requests/short_unshort.php",
      {
        id: ids,
        type: type
      },
      function(data, status){
        console.log(data);
      });
  }

  function email_fun(ids){

    var students = [];

    var emails = [];

    students.push(ids);



    $.each(students, function( indexS, valueS ) {

      $.each(users, function( indexU, valueU ) {
      if (valueS==valueU.id){
        emails.push(valueU.email);
      }
      });
    });

    var email_str = '';
    // email_str = emails.join('<br/>');

    // $('#email_show').html(email_str);
    $('#email-students-list').val(JSON.stringify(students));

    $('#sub_to_mail').val(emails.join('; '));
    
    /*$.each(users, function( index, value ) {
      if (value.id==ids){
        $('#email_input').val(value.email);
      }
    });*/

  }



  function send_email(){

    var email = $('#email_input').val();
    var message = $('#message_input').val();

    $.post("requests/api_send_email.php",
      {
        email: email,
        message: message,
        hash: '<?php echo md5(time());?>'
      },
      function(data, status){
        console.log(data);
        $('#myModal').modal('hide');
      });

  }


  function chk_unchk(ele){

    var id;
    check_all(all_stud, 'studentlist')
    
    if ($(ele).prop('checked')==true){
        $(".stu_chk").each(function(){
            $(this).prop('checked',true);
            id = $(this).attr('data-id');
            if (!selected_candidate_ids.includes(id)) {
                update_selected_candidate(id);
                selected_candidate_ids.push(id);
            } 
        });
    }
    
    if ($(ele).prop('checked')==false){
        $(".stu_chk").each(function(){
            $(this).prop('checked',false);
            id = $(this).attr('data-id');
            var ind = selected_candidate_ids.indexOf(id);
            
            if (ind > -1) {
                selected_candidate_ids.splice(ind, 1);
            }
        });
      
    }
    var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
    document.getElementById("sel_count_basic").innerHTML = selected_candidate_ids.length + sel;
    document.getElementById("sel_count_smart").innerHTML = selected_candidate_ids.length + sel;

  }



  function set_student_ids(){

    var students = [];

    var emails = [];

    $(".stu_chk").each(function(){
      if ($(this).prop('checked')==true){
        students.push($(this).attr('data-id'));
      }
    });


    // $.each(students, function( indexS, valueS ) {

    //   $.each(users, function( indexU, valueU ) {
    //   if (valueS==valueU.id){
    //     emails.push(valueU.email);
    //   }
    //   if (latest_selected_candidate_id == valueU.id){
    //       $('#ind_to_mail').val(valueU.email)
    //   }
    //   });
    // });
    
    $.each(selected_candidate_ids, function( indexS, valueS ) {

      $.each(users, function( indexU, valueU ) {
        if (valueS==valueU.id){
          emails.push(valueU.email);
        }
        if (latest_selected_candidate_id == valueU.id){
            $('#ind_to_mail').val(valueU.email)
        }
      });
    });

    var email_str = '';
    email_str = emails.join('<br/>');

    // $('#email_show').html(email_str);
    $('#sub_to_mail').val(emails.join('; '));
    // $('#ind_to_mail').val(latest_selected_candidate_id);

    $('#email-students-list').val(JSON.stringify(selected_candidate_ids));

    if (selected_candidate_ids.length==0){
      alert('please select a student !');
    }


  }
  
  //$(".invisibles").toggle();
  
   $('.email-helper-info').on('click', function(e) {
      $('.invisibles').toggleClass("collapsed pressed"); //you can list several class names 
    $(".invisibles").toggle();
      e.preventDefault();
    });

</script>