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
?>

<?php
    # Include search filter parsing
    include_once "search_parsing.php";
?>

<?php
    # Begin forming page
    include_once "components/header.php";
?>
    
<!-- Add main database page elements -->
<link href="css/database.css" type="text/css" rel="stylesheet" />
<script src="scripts/db_global_var.js"></script>
<script src="scripts/client_http_req.js"></script>
<script src="scripts/candidate-actions.js"></script>
<script src="scripts/aesthetic/tabs.js"></script>
<?php
    if (isset($_GET["cv"])) {
?>
<script>
    latest_selected_candidate_id = JSON.parse(<?php echo $_GET["latest"]; ?>);
    selected_candidate_ids = JSON.parse(<?php echo $_GET["selected"]; ?>)
    block_sel_candidate = true;
</script>
<?php
    }
    if (isset($_GET["cv_latest"])) {
?>
<script>
    block_sel_candidate = true;
    latest_selected_candidate_id = JSON.parse(<?php echo $_GET["cv_latest"]; ?>);
</script>
<?php
    }
?>
<section class="body">
    <div class="heading">
        <div class="leftheading">
          <div class="lhtop">
            <!-- Uncertain what to use this space for? -->
            </div>
            <div class="lhbottom">
                <!--<h3 id="page-title">OCH Client Platform</h3>-->
            </div>
        </div>
        <div class="rightheading">
            <div class="centerheading">
                <div class="chtop">
                    <div class="chtopleft">
                        <!-- Candidate count -->
                        <button class="deselect_all" id="deselect_all_button" onclick="deselect_all_cand()"></button>
                        <div style="display: none;width:100px;" id="deselect_info">
                            <p>Deselect all</p>
                        </div>
                        <p id="sel_count" style="margin-left: 25px;">0 candidates</p>
                        <p>selected</p>
                        <button class="select_all_button btn btn-primary" id="select_all-SHRT" onclick="select_all_cand(event)" style="display: none;">Select all</button>
                        <button class="select_all_button btn btn-primary" id="select_all-CNTCT" onclick="select_all_cand(event)" style="display: none;">Select all</button>
                        <input type="checkbox" name="use_filters" id="filter_check" checked/>
                        <div style="display: none;" id="use_filter_info">
                            <p>Toggle filters<p><br/>
                            <p>(Checked = Using filters)</p>
                        </div>
                        <script src="scripts/event_listeners/top_left_buttons.js"></script>
                    </div>
                    <div class="chtopright">
                        <!-- Candidates per page -->
                        <p class="cperpage">Max results per page</p>
                        <span id="max-results-info-hover">i</span>
                        <div class="invisible" id="max-results-info-container">
                            <h5>Decrease this to increase load speed</h5>
                            <p>N.B. Only results relevant to you will be shown</p>
                            <p>Hence maximum rather than actual results displayed</p>
                        </div>
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
                <div class="chbottom">
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
           <div class="fullrightheading">
                <h5 style="font-weight:bold; margin-bottom: 0;">Bulk Actions</h5>
                <div class="bulk_action_button">
                    <button class="accessdetails" onclick="access_details_selected_candidates()">Access details</button>
                </div>
                <div class="bulk_action_button">
                    <button class="downloadexcel" id="myBtn1" disabled>Download as Excel</button>
                    <div class="greyed-out-bulk-action"></div>
                </div>
                <div class="bulk_action_button">
                    <button class="sendemail" onclick="shortlist_selected_candidates()">Shortlist</button>
                </div>
                <div class="bulk_action_button">
                    <button data-toggle="modal" data-target="#bulk_email" data-backdrop="static" class="sendemail" id="myBtn">Email</button>
                </div>
            </div>
        </div>
    </div>
    <div class="leftbody">
        <!-- This has to handle all the searches et cetra -->
        <?php include_once "components/search_bar.php"; ?>
    </div>
    <div class="rightbody">
        <!-- This script handles all updating the center frame -->
        <script src="scripts/pagination/main.js"></script>
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

<?php
    # Close off page (includes some modals that may not apply?)
    include_once "components/footer.php";
?>

<div class="modal" id="bulk_email">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Please compose your email</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="helper-information-container">
                <span class="email-helper-info" id="bulk-email-helper">i</span>
                <div class="invisible" class="email-info" id="email-info-bulk">
                    <h4>Here are some tools to help you customise your email:</h4>
                    <p>1. The phrase "{{fname}}" will be replaced with the candidates first name</p>
                    <p style="text-indent: 40px">     a) For example "Dear {{fname}},"</p>
                    <p>2. You can also personalise your emails further using your own HTML formatting, if you would prefer plain text then all new lines will still be preserved.</p>
                </div>
            </div>
            <form action="dispatch_bulk_email.php" method="POST" class="bulk_email_form">
                <input type="hidden" name="bulk" value="1"/>
                <input type="hidden" name="student-ids" id="email-students-list"/>
                <label style="display: inline;">Html formatting:</label>
                <input type="checkbox" name="plain_text" value="off"/>
                <label class="btn-secondary">From</label>
                <input type="text" name="from"/>
                <label class="btn-secondary">Subject</label>
                <input type="text" name="email-subject"/>
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
                <span class="email-helper-info" id="ind-email-helper">i</span>
                <div class="invisible" class="email-info" id="email-info-individual">
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
                <label class="btn-secondary">From</label>
                <input type="text" name="from"/>
                <label class="btn-secondary">Subject</label>
                <input type="text" name="email-subject"/>
                <label class="btn-secondary">Body</label>
                <textarea id="email-body" name="email-body"></textarea> 
                <button type="submit" onclick="fetch_email_to()" class="btn btn-primary btn-email">Send</button>
            </form>
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