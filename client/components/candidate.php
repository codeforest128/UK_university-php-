<label>
    <div class="object">
        <div class="objecttop">
            <div class="objectleft">
                <!-- Select candidate simply needs some eventlisteners -->
                <input type="checkbox" class="checkbox" id="<?php echo "select-" . $candidate["itd"]; ?>">
                <script>
                    document.getElementById("select-<?php echo $candidate["itd"]; ?>").addEventListener(
                        "change",
                        function(event) {
                            var id = event.target.id.substring(event.target.id.indexOf("-")+1);
                            handleSelect(id);
                        }
                    );
                </script>
                <!-- Will be candidates image -->
                <div class="circle"></div>
            </div>
            <div class="objectright">
                <p class="candname"><?php 
                    if (sizeof($candidate["university"]) == 0) {
                        $uni = "Oxford";
                    } else {
                        $uni = $candidate["university"];
                    }
                    echo $candidate["firstname"] . " from " . $uni; 
                ?></p>
                <p class="broaddetails"><?php echo $candidate["course"]; ?></p>
                <p class="broaddetails"><?php echo $candidate["college"]; ?></p>
                <!-- Needs a lot of work -->
                <button class="accessdetails">Access details</button>
            </div>
        </div>
        <div class="objectmiddle">
            <div class="objectleft">
                <center class="skills">Grad year:</center>
                <center class="skills">Grade:</center>
                <center class="skillstop">Interests:</center>
            </div>
            <div class="objectright">
                <p class="interestlist"><?php echo $candidate["course_end"]; ?></p>
                <p class="interestlist"><?php echo "From " . $candidate["availability"]; ?></p>
                <p class="interestlisttop"><?php
                    $c_interests = json_decode($candidate["ind1"]);
                    $output = "";
                    foreach ($c_interests as $interest) {
                        $output .= $interest . ", ";
                    }
                    echo substr($output, 0, -2);
                ?></p>
            </div>
        </div>
        <!-- Needs work!! -->
        <div class="objectbottom">
            <div class="objectleft">
                <center class="skillstop">Skills:</center>
            </div>
            <div class="objectright">
                <p class="interestlisttop">PHP, HTML, CSS, Writing, Excel, Microsoft, Office</p>
            </div>
        </div>
    </div> 
</label>