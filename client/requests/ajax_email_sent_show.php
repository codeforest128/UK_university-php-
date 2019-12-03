
<?php
    include_once "../../../classes/login.php";
    include_once "../../../classes/DB.php";

    

    $send_email = DB::query('SELECT * FROM inhouse_email_tracking WHERE id='.$_POST['id']);

    $users = DB::query('SELECT * FROM users');

  //  print_r($users);



   foreach ($send_email as $keySE => $valueSE) { 

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
                                        $students[$valueU['email']] = $valueU['username'];
                                       
                                    }
                                }
                            } ?>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>To</td>
                            <td>
                                    <?php foreach ($students as $keySTR => $valueSTR) { ?>
                                        <?php echo $valueSTR;?> ( <?php echo $keySTR;?> )<br/>
                                    <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Subject</td>
                            <td><?php echo $valueSE['subject'];?></td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td><?php echo $valueSE['date_occured'];?></td>
                        </tr>
                        
                    </tbody>
                </table>
                <br>
                <br>


                <style>
                    body {
                        font-family: Montserrat,sans-serif;
                    }
                </style>
                <div style="border: 1px solid black;">
                    <div style="height: 3em; background: #00003C; text-align: center;">
                    </div>
                    <div style="margin: 20px;"><?php echo $valueSE['content']; ?>
                    </div>
                    <hr/>
                    <div style="text-align: center">
                        <p style="font-size: 0.8em"><?php echo date('Y');?> Varsity Careers Hub</p>
                    </div>
                </div>
<?php }   ?>


