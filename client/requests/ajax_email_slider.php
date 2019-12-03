
<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";
    

    $send_email = DB::query('SELECT * FROM inhouse_email_tracking WHERE client_id="'.$_POST['client_id'].'" ORDER BY id desc');

    $drafts = DB::query('SELECT * FROM email_draft WHERE client_id="'.$_POST['client_id'].'" ORDER BY id desc');

    $users = DB::query('SELECT * FROM users');

    $client = DB::query('SELECT * FROM clients WHERE id='.$_POST['client_id']);

  //  print_r($users);

 //  print_r($send_email);

    
?>



<?php if ($_POST['type']=='compose' || $_POST['type']=='draft_view') { ?>

    <?php 

    $student_ids = '[]';
    $subject = '';
    $message = '';
    $students = array();

    if (isset($_POST['data'])) {

        $draft_id = $_POST['data'];

        $drafts = DB::query('SELECT * FROM email_draft WHERE id="'.$draft_id.'"');

        foreach ($drafts as $keyD => $valueD) {
            $student_ids = $valueD['student_ids'];
            $subject = $valueD['subject'];
            $message = $valueD['message'];

            try
            {
             $json_obj =   json_decode($valueD['student_ids']);
            }
            catch (ErrorException $e)
            {
              $json_obj = array();
            }
            foreach ($json_obj as $keyJo => $valueJO) {
                foreach ($users as $keyU => $valueU) {
                    if ($valueJO==$valueU['id']) {
                        $students[$valueU['email']] = $valueU['username'];
                       
                    }
                }
            }
        }
        
    }

    $student_display = '';
    foreach ($students as $keyEma => $valueNam) {
        $student_display.='<'.$valueNam.'>'.$keyEma.' , ';
    }

    ?>

    <div class="email-inbox-header">
                <div class="row">
                <!----div class="col-md-12">
                    <div class="helper-information-container">
                        <span style="cursor: pointer;" class="email-helper-info" id="bulk-email-helper">i</span>
                        <div style="display:none;" class="invisibles email-infos" id="email-info-bulks">
                            <h4>Here are some tools to help you customise your email:</h4>
                            <p>1. The phrase "{{fname}}" will be replaced with the candidates first name</p>
                            <p style="text-indent: 40px">     a) For example "Dear {{fname}},"</p>
                            <p>2. You can also personalise your emails further using your own HTML formatting, if you would prefer plain text then all new lines will still be preserved.</p>
                        </div>
                    </div>
                </div-------->
                <div class="col-md-12 text-center text-danger"><span id="email_error"></span></div>
                <div class="col-lg-12 col-md-12">
                <form action="dispatch_bulk_email.php" method="POST" class="bulk_email_form" onsubmit="check_students(event)">
                <input  type="hidden" name="bulk" value="1">
                <input type="hidden" name="student-ids" id="email-students-list" value='<?php echo $student_ids;?>'>
                <br>
                <input type="checkbox" checked name="plain_text" value="off" style="display:none;">
                <div class="row">
                    <div class="col-md-4"><label>Email sent to</label> </div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="from" id="sub_to_mail"  readonly ="" value="<?php echo $student_display;?>">
                    </div>
                </div>
                <br>

                <?php foreach ($client as $keyC => $valueC) { ?>
                <div class="row">
                    <div class="col-md-4"><label>CC</label></div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="cc" value="<<?php echo $valueC['username'];?>><?php echo $valueC['email'];?>"  readonly="">
                    </div>
                </div>
                <?php } ?>
                <br>

                <div class="row">
                    <div class="col-md-4"><label>Subject</label></div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" onkeyup="save_draft()" name="email-subject" id="email_subject" required="" value="<?php  echo $subject;?>" >
                    </div>
                </div>
                <br>
                
                
                <label>Body</label>
                <div class="message_body">
                <textarea id="email-body_x" class="form-control summernote" onkeyup="save_draft()" name="email-body" rows="7" required ><?php  echo $message;?></textarea>
                </div>
                <br>
                <div class="text-right">
                	<button type="button" data-toggle="modal" data-target="#email_instructions" class="btn btn-mail "><i class="fa fa-info"></i> Information</button>
                    <button type="button" onclick="preview_email()" class="btn btn-info "><i class="fa fa-image"></i> Preview</button>
                    <button type="submit" CCCC="fetch_email_list()" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send</button>
                </div>
                
                
                </form>
                </div>
                </div>
                </div>


                 <script>

                    var email_body = $('.summernote').summernote({
                        height: 250
                    });

                    $(".note-editable").keyup(function(){
                    save_draft();   
                    });

                    
       

    </script>


<?php } ?>





<?php if ($_POST['type']=='sent') { ?>

<div class="email-inbox-header">
          <div class="row">
              <div class="col-lg-6 col-md-6">
                  <div class="email-title"><span class="icon"><i class="fas fa-fw  fa-envelope"></i></span> Sent mail <span class="new-messages">( <?php echo count($send_email);?> Messages)</span> </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="email-search">
                      <div class="input-group input-search">
                          <input class="form-control" type="text" placeholder="Search mail..."><!-- <span class="input-group-btn">
                         <button class="btn btn-secondary" type="button"><i class="fas fa-search"></i></button></span> -->
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="email-filters">
                        <div class="email-filters-left">
                            <label class="custom-control custom-checkbox be-select-all" style="width: 10px;">
                                <input class="custom-control-input chk_all" onchange="email_ckeck_all(this,'sent_checkbox')" type="checkbox" name="chk_all"><span class="custom-control-label"></span>
                            </label>
                            <!-- <div class="btn-group">
                                <button class="btn btn-light dropdown-toggle" data-toggle="dropdown" type="button">
                                    With selected <span class="caret"></span></button>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Mark as rea</a><a class="dropdown-item" href="#">Mark as unread</a><a class="dropdown-item" href="#">Spam</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div> -->
                            <div class="btn-group">
                                <!-- <button class="btn btn-light" type="button">Archive</button>
                                <button class="btn btn-light" type="button">Span</button> -->
                                <button class="btn btn-light" onclick="delete_email('sent')" type="button">Delete</button>
                            </div>
                            <!-- <div class="btn-group">
                                <button class="btn btn-light dropdown-toggle" data-toggle="dropdown" type="button">Order by <span class="caret"></span></button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu"><a class="dropdown-item" href="#">Date</a><a class="dropdown-item" href="#">From</a><a class="dropdown-item" href="#">Subject</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Size</a>
                                </div>
                            </div> -->
                        </div>
                        <!-----div class="email-filters-right"><span class="email-pagination-indicator">1-50 of 253</span>
                            <div class="btn-group email-pagination-nav">
                                <button class="btn btn-light" type="button"><i class="fas fa-angle-left"></i></button>
                                <button class="btn btn-light" type="button"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div-------->
                    </div>

                    <div class="email-list">
                        <?php foreach ($send_email as $keySE => $valueSE) { 

                            $students = array();

                                        try
                                        {
                                         $json_obj =   json_decode($valueSE['student_ids']);
                                        }
                                        catch (ErrorException $e)
                                        {
                                          $json_obj = array();
                                        }
                            foreach ($json_obj as $keyJo => $valueJO) {
                                foreach ($users as $keyU => $valueU) {
                                    if ($valueJO==$valueU['id']) {
                                        $students[] = $valueU['username'];//"<".$valueU['email'].">".$valueU['cc'];
                                       
                                    }
                                }
                            }

                         //   print_r($students);



                            ?>
                        <div class="email-list-item email-list-item--unread">
                            <div class="email-list-actions">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkboxes sent_checkbox" type="checkbox" value="<?php echo $valueSE['id'];?>" id="one"><span class="custom-control-label"></span>
                                </label><a class="favorite active" href="#"><span><i class="fas fa-star"></i></span></a>
                            </div>
                            <div class="email-list-detail"><span class="date float-right"><span class="icon"><i class="fas fa-paperclip"></i> </span><?php echo date('d F Y',strtotime($valueSE['date_occured']));  ?>  </span><span class="from"><?php echo implode("  ,  ",$students); ?></span>
                                <p class="msg"><?php echo $valueSE['subject'];?></p>
                            </div>
                            <div class="email-list-actions">
                                <a class="favorite" onclick="show_sent_email(<?php echo $valueSE['id'];?>)" ><span><i class="fa fa-folder-open-o fa-2x"></i></span></a>
                            </div>
                        </div>
                        <?php } ?>
                        
                    </div>


<?php } ?>





<?php if ($_POST['type']=='draft') { ?>

<div class="email-inbox-header">
          <div class="row">
              <div class="col-lg-6 col-md-6">
                  <div class="email-title"><span class="icon"><i class="fas fa-fw fa-file"></i></span> Draft <span class="new-messages">( <?php echo count($drafts);?> Messages)</span> </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="email-search">
                      <div class="input-group input-search">
                          <input class="form-control" type="text" placeholder="Search mail..."><!-- <span class="input-group-btn">
                         <button class="btn btn-mail" type="button"><i class="fas fa-search"></i></button></span> -->
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="email-filters">
                        <div class="email-filters-left">
                            <label class="custom-control custom-checkbox be-select-all" style="width: 10px;">
                                <input class="custom-control-input" onchange="email_ckeck_all(this,'draft_checkbox')" type="checkbox" name="chk_all"><span class="custom-control-label"></span>
                            </label>
                            <!-- <div class="btn-group">
                                <button class="btn btn-light dropdown-toggle" data-toggle="dropdown" type="button">
                                    With selected <span class="caret"></span></button>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Mark as rea</a><a class="dropdown-item" href="#">Mark as unread</a><a class="dropdown-item" href="#">Spam</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" onclick="delete_email('draft')">Delete</a>
                                </div>
                            </div> -->
                            <div class="btn-group">
                                <!-- <button class="btn btn-light" type="button">Archive</button>
                                <button class="btn btn-light" type="button">Span</button> -->
                                <button class="btn btn-light" onclick="delete_email('draft')" type="button">Delete</button>
                            </div>
                            <!-- <div class="btn-group">
                                <button class="btn btn-light dropdown-toggle" data-toggle="dropdown" type="button">Order by <span class="caret"></span></button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu"><a class="dropdown-item" href="#">Date</a><a class="dropdown-item" href="#">From</a><a class="dropdown-item" href="#">Subject</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Size</a>
                                </div>
                            </div> -->
                        </div>
                        <!-----div class="email-filters-right"><span class="email-pagination-indicator">1-50 of 253</span>
                            <div class="btn-group email-pagination-nav">
                                <button class="btn btn-light" type="button"><i class="fas fa-angle-left"></i></button>
                                <button class="btn btn-light" type="button"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div-------->
                    </div>

                    <div class="email-list">
                        <?php foreach ($drafts as $keySE => $valueSE) { 

                            $students = array();

                                        try
                                        {
                                         $json_obj =   json_decode($valueSE['student_ids']);
                                        }
                                        catch (ErrorException $e)
                                        {
                                          $json_obj = array();
                                        }
                            foreach ($json_obj as $keyJo => $valueJO) {
                                foreach ($users as $keyU => $valueU) {
                                    if ($valueJO==$valueU['id']) {
                                        $students[] = $valueU['username'];//"<".$valueU['email'].">".$valueU['cc'];
                                       
                                    }
                                }
                            }

                         //   print_r($students);



                            ?>
                        <div class="email-list-item email-list-item--unread">
                            <div class="email-list-actions">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkboxes draft_checkbox" type="checkbox" value="<?php echo $valueSE['id'];?>" id="one"><span class="custom-control-label"></span>
                                </label><a class="favorite active" href="#"><span><i class="fas fa-star"></i></span></a>
                            </div>
                            <div class="email-list-detail"><span class="date float-right"><span class="icon"><i class="fas fa-paperclip"></i> </span><?php echo date('d F Y',strtotime($valueSE['created_at']));  ?>  </span><span class="from"><?php echo implode("  ,  ",$students); ?></span>
                                <p class="msg"><?php echo $valueSE['subject'];?></p>
                            </div>
                            <div class="email-list-actions">
                                <a class="favorite" onclick="email_setup(this,'draft_view',<?php echo $valueSE['id'];?>);" ><span><i class="fa fa-folder-open-o fa-2x"></i></span></a>
                            </div>
                        </div>
                        <?php } ?>
                        
                    </div>


<?php } ?>


