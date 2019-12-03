<div class="filtersec" style="display: none;">
    <p style="font-size:16px;font-weight:bold">Skills</p>
    <button class="dd_box" onclick="selectDropDown(event, 'skill_dd'); return false;"><p id="skill_total" class="total_button_text">0</p> skills selected</button>
    <div class="dd_content" id="skill_dd">
        <input type="text" class="dd_search" id="skills_input" onkeyup="filterDropDown(event)" placeholder="Search for names..">
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Skills</p>
    <button class="dd_box" onclick="selectDropDown(event, 'skills_dd'); return false;"><p id="skill_filter_total" class="total_button_text">0 courses </p> selected</button>
    <div class="dd_content" id="skills_dd">
        <input type="text" class="dd_search" id="skills_input" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="skills_ul">
            <?php
                $skill_set_file = file_get_contents("../../temp/skill_set.csv");
                $skill_set = explode(",", $skill_set_file);
                for ($i = 0; $i < sizeof($skill_set); $i++) {
                    $c_skill = ltrim(rtrim($skill_set[$i]));
                    if ($c_skill == "") {
                        continue;
                    }
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' name='skill-" . strtolower($c_skill) . "'>" . $c_skill . "</label></li>";
                }
            /*
                *****COURSE SET TO MODEL OFF*****
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
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' name='course-" . $c_course . "'>" . $c_course . "</label></li>";
                }*/
            ?>
        </ul>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Courses</p>
    <button class="dd_box" onclick="selectDropDown(event, 'courses_dd'); return false;"><p id="course_filter_total" class="total_button_text">0 courses </p> selected</button>
    <div class="dd_content" id="courses_dd">
        <input type="text" class="dd_search" id="courses_input" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="courses_ul">
            <?php
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
                    echo "<li><label style='display: inline;'><input onchange='update_filter_total(event)' type='checkbox' style='display: inline;' name='course-" . $c_course . "'>" . $c_course . "</label></li>";
                }
            ?>
        </ul>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Grades</p>
    <button class="dd_box" onclick="selectDropDown(event, 'grades_dd'); return false;"><p id="grade_filter_total" class="total_button_text">0 grades </p> selected</button>
    <div class="dd_content" id="grades_dd">
        <input type="text" class="dd_search" id="grades_input" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="grades_ul">
            <li><label style='display: inline;'><input type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-1st">1st</label></li>
            <li><label style='display: inline;'><input type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-2:1">2:1</label></li>
            <li><label style='display: inline;'><input type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-2:2">2:2</label></li>
            <li><label style='display: inline;'><input type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name="grade-3rd">3rd</label></li>
        </ul>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Sectors</p>
    <button class="dd_box" onclick="selectDropDown(event, 'sectors_dd'); return false;"><p id="sector_filter_total" class="total_button_text">0 sectors </p> selected</button>
    <div class="dd_content" id="sectors_dd">
        <input type="text" class="dd_search" id="sectors_input" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="sectors_ul">
            <?php
                foreach ($SECTORS as $sector) {
                    echo "<li><label style='display: inline;'><input type='checkbox' onchange='update_filter_total(event)' style='display: inline;' name='sector-" . $sector . "'>" . $sector . "</label></li>";
                }
            ?>
        </ul>
    </div>
</div>
<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Graduation year</p>
    <button class="dd_box" onclick="selectDropDown(event, 'grad_dd'); return false;"><p id="gradyear_filter_total" class="total_button_text">0 years </p> selected</button>
    <div class="dd_content" id="grad_dd">
        <input type="text" class="dd_search" id="grad_input" onkeyup="filterDropDown(event)" placeholder="Search for names..">
        <ul class="dd_ul" id="grad_ul">
            <?php
                $c_year = date("Y") + 1;
                for ($i = 0; $i < 3; $i++) {
                    $t_year = $c_year + $i;
                    echo "<li><label style='display: inline;'><input type='checkbox' onchange='update_filter_total(event)' style='display:inline;' name='gradyear-" . $t_year ."'>"
                       . $t_year ."</label></li>";
                }
            ?>
        </ul>
    </div>
</div>
<script src='scripts/aesthetic/search_dropdowns.js'></script>