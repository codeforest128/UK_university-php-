<?php
	include('../../classes/DB.php');
	include('../../classes/login.php');


	
			    error_reporting(1);
			    	  $ote =  DB::query('SELECT * FROM posts WHERE college!=""');	
                              $oteno = count($ote)-16;
				 $cv =  DB::query('SELECT * FROM images');	
                              $cvs = count($cv);

				$cols = array("Balliol College", "Blackfriars", "Brasenose College", "Campion Hall", "Christ Church", "Corpus Christi College", "Exeter College", "Harris Manchester College", "Hertford College", "Keble College", "Kellogg College", "Lady Margaret Hall", "Lincoln College", "Magdalen College", "Merton College", "New College", "Nuffield College", "Oriel College", "Pembroke College", "Regent's Park College", "Somerville College", "St Anne's College", "St Antony's College", "St Catherine's College", "St Cross College", "St Edmund Hall", "St Hilda's College", "St Hugh's College", "St John's College", "St Peter's College", "St Stephen's House", "The Queen's College", "Trinity College", "University College", "Wadham College", "Wolfson College", "Worcester College", "Wycliffe Hall", "Green templeton College", "Jesus College", "Linacre College", "Mansfield College", "St Benet's Hall");
		$stats = array( array("Brasenose College", 365), array("Christ Church", 432), array("Corpus Christi College", 252), array("Exeter College", 334), array("Green Templeton College", 94), array("Harris Manchester College", 108), array("Hertford College", 403), array("Jesus College", 346), array("Keble College", 427), array("Regent's Park College", "128"), array("Lady Margaret Hall", 401), array("Linacre College", "-"), array("Lincoln College", 304), array("Magdalen College", 400), array("Mansfield College", 235), array("Merton College", 297), array("New College", 424), array("Nuffield College", "-"), array("Oriel College", 316), array("Pembroke College", 366), array("The Queen's College", 333), array("St Anne's College", 440), array("St Antony's College", "-"), array("St Catherine's College", 502), array("St Cross College", "-"), array("St Edmund Hall", 407), array("St Hilda's College", 398), array("St Hugh's College", 420), array("St John's College", 397), array("St Peter's College", 355), array("Somerville College", 413), array("Trinity College", 289), array("University College", 381), array("Wadham College", 459), array("Wolfson College", "-"), array("Worcester College", 429) );
			
			
		/*		$sum = 0;
				foreach($cols as $col) {
                     $go =  DB::query('SELECT * FROM posts WHERE college=:college AND verified = 1', array(':college'=>$col));		
                      $no = count($go);
                      $tarcent = round(($no/($values[1]/10))*100);
                      echo('<tr><td>'.$col.' </td><td> '.$no.'</td><td>'.$tarcent.'%</td><td>'.$values[1].'</td></tr>');
                                           $sumt += $no;
				} */

			
			
				          
				
				
		
	
		

?>
<?php include('header.php');?>  
         
         <div style="float:right;margin-top:70px;width:48%">
  
    
</div>
	
            <div class="col-md-6 account-form">
       
                <div class="personal-detaile-sec ">
                    <h3>Student Advisory Portal</h3>
					
					
					<table id="table_id" class="display table-responsive">
						<thead>
				<tr>
								<th>Source</th>
								<th>Verified</th>
								<th>Date/time</th>
								<th>CV</th>
								<th>College</th>
								

							</tr>
						</thead>
						<tbody>
							<?php	
						
						$students =  DB::query('SELECT * FROM posts WHERE firstname != "" ORDER BY posts.posted_at DESC');	

							foreach($students as $student) {
                        $values = array_values($stat);
                        $value = $values[0];
                      $no = count($go);

                      $price = ceil(($no-($values[1]*0.1))*0.5);
                $cv =  DB::query('SELECT id FROM images WHERE userid=:id ', array(':id'=>$student['user_id']))[0]['id'];	
          if($cv > 10) {
              
              $ycv = "YES";
          } else {
              $ycv = "NO";
          }

                     if($price<0){
                         $price1=0;
                     } else {
                         $price1 = $price;
                     }
                      
                        
                      //  if ($no > $values[1]*0.25){
                        //  $price1 = $price+($no-$values[1]*0.25)*0.5;
                
            //            }
                      $tarcent = round(($no/($values[1]/10))*100);
                      echo('<tr><td>'.$student['hear'].'</td><td>'.$student['verified'].'</td><td>'.$student['posted_at'].'</td><td>'.$ycv.'</td><td>'.$student['college'].'</td></tr>');
                                           $sum += $no;
                      
                                           
                                           
                        
				} ?>
						
						</tbody>
					</table>
					
					
					
					
                   </div>
                   </div>

<?php include('footer.php'); 


			
              
?>