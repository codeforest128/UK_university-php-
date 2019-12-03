function update_center() {
    // Find max ajax ver
    var ajax_ver = document.getElementById("ajax_ver").innerHTML;
    // Create empty fields for data to go into
    create_candidate_slots(max_results);
    // Make ajax request to gather information
    var url = "requests/candidates_pagination.php";
    var vari = { "type": sel_type, "max": max_results, "offset": stu_offset, "key": ajax_ver, "filters": use_filters }
    if (sel_type == "SEL") {
        vari["ids"] = JSON.stringify(selected_candidate_ids);
    }
    var fin_url = createUrl(url, vari)
    try {
        xhr = new XMLHttpRequest();
    } catch (e) {
        return;
    }
    xhr.onreadystatechange = populate_candidates;
    xhr.open("GET", fin_url, true);
    xhr.send();
}

function create_candidate_slots(max) {
    var slots_html = "";
    for (i = 0; i < max; i++) {
        slots_html += "<label id='stu_slot_" + i + "'></label>";
    }
    document.getElementById("candidates_container").innerHTML = slots_html;
}

function populate_candidates() {
    if (xhr.readyState == 4) {
        // Debugging term
        // alert(xhr.responseText);
        var response = JSON.parse(xhr.responseText);
        total_selection_size = response.ss;
        if (total_selection_size == 0) {
            html = "<div class='object' style='font-size: 1.5em; text-align: center; padding-bottom: 0; line-height: 3em; height: 3em;'>No students found...</div>";
            document.getElementById('stu_slot_0').innerHTML = html;
            return;
        }
        var c_stu_html, slot_id = "";
        var c_stu, uni;
        for (i = 0; i < response.students.length; i++) {
            c_stu = response.students[i];
            c_stu_html ="<div class='object'>" +
                            "<div class='objecttop'>" +
                                "<div class='objectleft'>" +
                                    // Checkbox to select student
                                    "<input type='checkbox' id='select-" + c_stu.itd + "'"; 
            if (selected_candidate_ids.includes(c_stu.itd)) {
                c_stu_html += " checked";
            }
            c_stu_html +=           ">";
            switch(c_stu.university) {
                case "University of Oxford":
                    uni = "oxf";
                    break;
                case "University of Cambridge":
                    uni = "cmb";
                    break;
                case "University of Durham":
                    uni = "dhm";
                    break;
            }
            c_stu_html +=       "<div class='circle uni-avatar-" + uni + "'></div>" +
                                "</div>" +
                                // General details
                                "<div class='objectright'>" +
                                    "<p class='candname'>" + c_stu.fname + " from " + c_stu.university + "</p>" +
                                    "<p class='broaddetails'>" + c_stu.course + "</p>" +
                                    "<p class='broaddetails'>" + c_stu.college + "</p>"; 
            if (c_stu.contacted_already == 0) {
                c_stu_html+=            "<button class='accessdetails-small' onclick='access_details(" + c_stu.itd + ")'>Access details</button>";
            }
            c_stu_html+=        "</div>" +
                            "</div>" +
                            "<div class='objectmiddle'>" +
                                "<div class='objectleft'>" +
                                    "<center class='skills'>Grad year:</center>" +
                                    "<center class='skills'>Grade:</center>" +
                                    "<center class='skills'>Interests:</center>" +
                                "</div>" +
                                "<div class='objectright'>" +
                                    "<p class='interestlist'>" + c_stu.course_end + "</p>" +
                                    "<p class='interestlist'>" + c_stu.grade + "</p>" +
                                    // Remember to clean up on PHP side **
                                    "<p class='interestlist'>" + c_stu.interests + "</p>" +
                                "</div>" +
                            "</div>" +
                            "<div class='objectbottom'>" +
                                "<div class='objectleft'>" +
                                    "<center class='skillstop'>Skills:</center>" +
                                "</div>" +
                                "<div class='objectright'>" +
                                    "<p class='interestlist'>" + c_stu.skills + "</p>" +
                                "</div>" +
                                "<br/>" +
                            "</div>" +
                        "</div>";
            // End of cand slot
            slot_id = "stu_slot_" + i;
            document.getElementById(slot_id).innerHTML = c_stu_html;
            document.getElementById("select-" + c_stu.itd).addEventListener(
                "change",
                function(event) {
                    handleSelect(event.target.id.substring(event.target.id.indexOf("-") + 1));
                }
            );
        }
        if (latest_selected_candidate_id.length > 0 && !block_sel_candidate) {
            update_selected_candidate(latest_selected_candidate_id);
        }
        update_offset_buttons();
    }
}