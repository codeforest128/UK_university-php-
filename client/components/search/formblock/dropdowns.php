
<?php 

	// echo "<pre>";
	// var_dump($_REQUEST);echo "</pre>";

$all_post = DB::query('SELECT * FROM posts');

$skills_full = array();

    foreach ($all_post as $keyM => $valueM) {

    	try
			{
			 $json_obj =   json_decode($valueM['ind3']);
			}
			catch (ErrorException $e)
			{
			  $json_obj = array();
			}

			foreach ($json_obj as $keyJSO => $valueJSO) {
				$skills_full[] = strtolower($valueJSO);
			}

    }

    $skills_full = array_unique($skills_full);
   //	asort($skills_full);



?>

<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Skills</p>
    <button type="button" class="dd_box" onclick="selectDropDown(event, 'skills_dd', '<?php echo $search_type; ?>'); return false;"><p id="skill_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 skills </p> selected</button>
    <div class="dd_content" id="skills_dd_<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="skills_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="skills_ul_<?php echo $search_type; ?>">
            <?php
                $skill_set_file = file_get_contents("../../../temp/skill_set.csv");
              /* $skill_set = explode(",", $skill_set_file);

               $rebuild = array();

               foreach ($skill_set as $keySS => $valueSS) {
	               	foreach ($skills_full as $keySf => $valueSf) {

	               		$obj = explode(" ",$valueSf);

	               		if (isset($obj[0])) {
	               			$matcher = $obj[0]." ";
	               		}else{
	               			$matcher = '#%$#$$$';
	               		}

	               		if (stripos($valueSS,$matcher)>-1){
	               			$rebuild[] = $valueSS;
	               		}
				    
				    }
               }*/


               $skill_set = array_unique($skills_full);

				$ck1="";
				$count=0;
                for ($i = 0; $i < sizeof($skill_set); $i++) {
                    $c_skill = ltrim(rtrim($skill_set[$i]));
                    if ($c_skill == "") {
                        continue;
                    }
					
					if(isset($_REQUEST['skill-'.strtolower(str_replace(" ","_",$c_skill))]) && $_REQUEST['skill-'.strtolower(str_replace(" ","_",$c_skill))]!==""){
						$ck1 = "checked";
						$count = $count+1;
						
					} else {
						//unset($_REQUEST['skill-'.strtolower(str_replace(" ","_",$c_skill))]);
						$ck1="";
					}
					
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' ".$ck1." name='skill-" . strtolower($c_skill) . "'>" . ucfirst($c_skill) . "</label></li>";
					
                }
				echo '
					<script>
						$("#skill_filter_total_'.$search_type.'").html("'.$count.' skills");
					</script>
				';
            ?>
        </ul>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Courses</p>
    <button type="buttton" class="dd_box" onclick="selectDropDown(event, 'courses_dd', '<?php echo $search_type; ?>'); return false;"><p id="course_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 courses </p> selected</button>
    <div class="dd_content" id="courses_dd_<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="courses_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="courses_ul_<?php echo $search_type; ?>">
            <?php
				$ck2="";
				$count2=0;
                $course_set = DB::query("SELECT DISTINCT `course` FROM `posts`", null);
                $fixed_course_set = array();
				
                for ($i = 0; $i < sizeof($course_set); $i++) {
                    $fixed_course_set[$i] = $course_set[$i]["course"];
                }
                sort($fixed_course_set);
                for ($i = 0; $i < sizeof($fixed_course_set); $i++) {
                    $c_course = $fixed_course_set[$i];
                    if ($c_course == "") {
                        continue;
                    }
					
					if(isset($_REQUEST['course-'.str_replace(" ","_",$c_course)]) && $_REQUEST['course-'.str_replace(" ","_",$c_course)]!=""){
						$ck2 = "checked";
						$count2 = $count2+1;
						
					} else {
						//unset($_REQUEST['course-'.str_replace(" ","_",$c_course)]);
						$ck2="";
					}
					
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' ".$ck2." name='course-" . $c_course . "'>" . $c_course . "</label></li>";
                }
				echo '
					<script>
						$("#course_filter_total_'.$search_type.'").html("'.$count2.' courses");
					</script>
				';
				
            ?>
        </ul>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Grades</p>
    <button type="buttton" class="dd_box" onclick="selectDropDown(event, 'grades_dd', '<?php echo $search_type; ?>'); return false;"><p id="grade_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 grades </p> selected</button>
    <div class="dd_content" id="grades_dd_<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="grades_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="grades_ul_<?php echo $search_type; ?>">
			<?php 
				$grcount = 0;
				if(isset($_REQUEST['grade-1st'])){
					$grcount+=1;
					$checked="checked";
				} else {$checked="";}
			?>
            <li><label style='display: inline;'><input <?php echo $checked; ?> type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-1st">1st</label></li>
			<?php 
				
				if(isset($_REQUEST['grade-2:1'])){
					$grcount+=1;
					$checked1="checked";
				} else {$checked1="";}
			?>
            <li><label style='display: inline;'><input <?php echo $checked1; ?> type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-2:1">2:1</label></li>
			<?php 
				if(isset($_REQUEST['grade-2:2'])){
					$grcount+=1;
					$checked2="checked";
				} else {$checked2="";}
			?>
            <li><label style='display: inline;'><input <?php echo $checked2; ?> type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-2:2">2:2</label></li>
			<?php 
				if(isset($_REQUEST['grade-3rd'])){
					$grcount+=1;
					$checked3="checked";
				} else {$checked3="";}
			?>
            <li><label style='display: inline;'><input <?php echo $checked3; ?> type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-3rd">3rd</label></li>
        </ul>
		<?php echo '
					<script>
						$("#grade_filter_total_'.$search_type.'").html("'.$grcount.' grades");
					</script>
				';
				?>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Sectors</p>
    <button type="buttton" class="dd_box" onclick="selectDropDown(event, 'sectors_dd', '<?php echo $search_type; ?>'); return false;"><p id="sector_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 sectors </p> selected</button>
    <div class="dd_content" id="sectors_dd_<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="sectors_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="sectors_ul_<?php echo $search_type; ?>">
            <?php
				$scount=0;
                foreach ($SECTORS as $sector) {
					if(isset($_REQUEST['sector-'.str_replace(" ","_",$sector)])) {
						$ch="checked";
						$scount+=1;
					} else {
						$ch="";
					}
                    echo "<li><label style='display: inline;'><input ".$ch." type='checkbox' onchange='update_filter_total(event)' style='display: inline;' name='sector-" . $sector . "'>" . $sector . "</label></li>";
                }
				
            ?>
        </ul>
		<?php 
			echo '
					<script>
						$("#sector_filter_total_'.$search_type.'").html("'.$scount.' sectors");
					</script>
				';
		?>
    </div> 
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Graduation year</p>
    <button type="buttton" class="dd_box" onclick="selectDropDown(event, 'grad_dd', '<?php echo $search_type; ?>'); return false;"><p id="gradyear_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 years </p> selected</button>
    <div class="dd_content" id="grad_dd_<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="grad_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="grad_ul_<?php echo $search_type; ?>">
            <?php
                $c_year = date("Y") + 1;
				$ycount=0;
                for ($i = 0; $i < 3; $i++) {
					if(isset($_REQUEST['gradyear-'.$t_year])) {
						$ch2="checked";
						$ycount+=1;
					} else {
						$ch2="";
					}
                    $t_year = $c_year + $i;
                    echo "<li><label style='display: inline;'><input ".$ch2." type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name='gradyear-" . $t_year ."'>"
                       . $t_year ."</label></li>";
                }
            ?>
        </ul>
		<?php 
			echo '
					<script>
						$("#gradyear_filter_total_'.$search_type.'").html("'.$ycount.' years");
					</script>
				';
		?>
    </div>
</div>



<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Location</p>
    <button type="buttton" class="dd_box" onclick="$('#location_add<?php echo $search_type; ?>').toggle(),event.preventDefault()"><p id="location_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 Location </p> selected</button>
    <div class="dd_content" id="location_add<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="courses_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="courses_ul_<?php echo $search_type; ?>">
            <?php
				$ck2="";
				$count2=0;
                $course_set = DB::query("SELECT DISTINCT location FROM `posts`", null);
                $fixed_course_set = array();
				
                for ($i = 0; $i < sizeof($course_set); $i++) {
                    $fixed_course_set[$i] = $course_set[$i]["location"];
                }
                sort($fixed_course_set);
                for ($i = 0; $i < sizeof($fixed_course_set); $i++) {
                    $c_course = $fixed_course_set[$i];
                    if ($c_course == "") {
                        continue;
                    }
					
					if(isset($_REQUEST['location-'.str_replace(" ","_",$c_course)]) && $_REQUEST['location-'.str_replace(" ","_",$c_course)]!=""){
						$ck2 = "checked";
						$count2 = $count2+1;
						
					} else {
						//unset($_REQUEST['course-'.str_replace(" ","_",$c_course)]);
						$ck2="";
					}
					
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' ".$ck2." name='location-" . $c_course . "'>" . $c_course . "</label></li>";
                }
				echo '
					<script>
						$("#location_filter_total_'.$search_type.'").html("'.$count2.' locations");
					</script>
				';
				
            ?>
        </ul>
    </div>
</div>


<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Qualification</p>
    <button type="buttton" class="dd_box" onclick="$('#qualification_add<?php echo $search_type; ?>').toggle(),event.preventDefault()"><p id="qualification_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 qualification </p> selected</button>
    <div class="dd_content" id="qualification_add<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="courses_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="courses_ul_<?php echo $search_type; ?>">
            <?php
				$ck2="";
				$count2=0;
                $course_set = DB::query("SELECT DISTINCT qualification FROM `posts`", null);
                $fixed_course_set = array();
				
                for ($i = 0; $i < sizeof($course_set); $i++) {
                    $fixed_course_set[$i] = $course_set[$i]["qualification"];
                }
                sort($fixed_course_set);
                for ($i = 0; $i < sizeof($fixed_course_set); $i++) {
                    $c_course = $fixed_course_set[$i];
                    if ($c_course == "") {
                        continue;
                    }
					
					if(isset($_REQUEST['qualification-'.str_replace(" ","_",$c_course)]) && $_REQUEST['qualification-'.str_replace(" ","_",$c_course)]!=""){
						$ck2 = "checked";
						$count2 = $count2+1;
						
					} else {
						//unset($_REQUEST['course-'.str_replace(" ","_",$c_course)]);
						$ck2="";
					}
					
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' ".$ck2." name='qualification-" . $c_course . "'>" . $c_course . "</label></li>";
                }
				echo '
					<script>
						$("#qualification_filter_total_'.$search_type.'").html("'.$count2.' qualifications");
					</script>
				';
				
            ?>
        </ul>
    </div>
</div>

<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">University</p>
    <button type="buttton" class="dd_box" onclick="$('#university_add<?php echo $search_type; ?>').toggle(),event.preventDefault()"><p id="university_filter_total_<?php echo $search_type; ?>" class="total_button_text">0 University </p> selected</button>
    <div class="dd_content" id="university_add<?php echo $search_type; ?>">
        <input type="text" class="dd_search" id="courses_input_<?php echo $search_type; ?>" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="courses_ul_<?php echo $search_type; ?>">
            <?php
				$ck2="";
				$count2=0;
                $course_set = DB::query("SELECT DISTINCT university FROM `posts`", null);
                $fixed_course_set = array();
				
                for ($i = 0; $i < sizeof($course_set); $i++) {
                    $fixed_course_set[$i] = $course_set[$i]["university"];
                }
                sort($fixed_course_set);
                for ($i = 0; $i < sizeof($fixed_course_set); $i++) {
                    $c_course = $fixed_course_set[$i];
                    if ($c_course == "") {
                        continue;
                    }
					
					if(isset($_REQUEST['university-'.str_replace(" ","_",$c_course)]) && $_REQUEST['university-'.str_replace(" ","_",$c_course)]!=""){
						$ck2 = "checked";
						$count2 = $count2+1;
						
					} else {
						//unset($_REQUEST['course-'.str_replace(" ","_",$c_course)]);
						$ck2="";
					}
					
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' ".$ck2." name='university-" . $c_course . "'>" . $c_course . "</label></li>";
                }
				echo '
					<script>
						$("#university_filter_total_'.$search_type.'").html("'.$count2.' universities");
					</script>
				';
				
            ?>
        </ul>
    </div>
</div>

<script src='scripts/aesthetic/search_dropdowns.js'></script>