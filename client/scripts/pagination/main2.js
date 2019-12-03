function update_center() {
    // Find max ajax ver
    var ajax_ver = document.getElementById("ajax_ver").innerHTML;

    // Create empty fields for data to go into
    create_candidate_slots(max_results);
    
    // Make ajax request to gather information
    var url = "requests/candidates_pagination2.php";
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
    if (table_view) {
        document.getElementById('card_view').style.display = "none";
        document.getElementById('table_view').style.display = "block";
    } else {
        document.getElementById('card_view').style.display = "block";
        document.getElementById('table_view').style.display = "none";
    }
    var elem_type = table_view ? "tr" : "label";
    var slot_destination = table_view ? "table_contents" : "candidates_container";
    var alt_slot_destination = !table_view ? "table_contents" : "candidates_container";
    var slots_html = "";
    console.log(max)
    for (i = 0; i < max; i++) {
        slots_html += "<" + elem_type + " id='stu_slot_" + i + "'></" + elem_type + ">";
    }
    document.getElementById(slot_destination).innerHTML = slots_html;
    document.getElementById(alt_slot_destination).innerHTML = "";
}


var global_ss = 0;

function populate_candidates() {


    if (xhr.readyState == 4 && xhr.status == 200 && !table_view) {
        
        // Debugging term
        // alert(xhr.responseText);

        //var response = JSON.parse(xhr.responseText);

        var response = [];

        if(xhr.responseText) {
            try {
                response = JSON.parse(xhr.responseText);
                global_ss = response.ss;
            } catch(e) {
                response = {'ss':global_ss,'students':[]};
            }
        }





        



        // Manage what clients can actually do
        total_selection_size = response.ss;
        console.log(total_selection_size);
        if (total_selection_size === 0) {
            html = "<div class='object' style='font-size: 1.5em; text-align: center; padding-bottom: 0; line-height: 3em; height: 3em;'>No students found...</div>";
            document.getElementById('stu_slot_0').innerHTML = html;
            return;
        } else if (response.ss === "smart" || response.ss === "smart_reduced") {
            //document.getElementById("listing_options_basic").style.display = "none";
           // document.getElementById("listing_options_smart").style.display = "block";
            document.getElementById('smart_search_button').click();
        } else {
            //document.getElementById("listing_options_basic").style.display = "block";
            //document.getElementById("listing_options_smart").style.display = "none";
        }
        
        var c_stu_html, slot_id = "";
        var c_stu, uni;

        


        for (i = 0; i < response.students.length; i++) {
            //console.log(response.students.length);
            c_stu = response.students[i];
            c_stu_html ="<div class='object'>" +
                            "<div class='objecttop'>" +
                                "<div class='objectleft'>" +
                                    // Checkbox to select student
                                    "<input type='checkbox' class='stu_chk' data-id='"+c_stu.itd+"' id='select-" + c_stu.itd + "'"; 
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
            c_stu_html +=       "<div class='circle uni-avatar-" + uni + "'>" +
                                    "<span>" +
                                        "<i class='fas fa-user-graduate'></i>" +
                                    "</span>" +
                                "</div>" +
                                "</div>" +
                                // General details
                                "<div class='objectright'>";
            if (c_stu.contacted_already != 0) {
                c_stu_html+=        "<span class='contacted_already_icon'><i class='fas fa-address-book'></i></span>";
            }
            c_stu_html+=            "<p class='candname'>" + c_stu.fname + " from " + c_stu.university + "</p>" +
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
                    console.log("okay")
                    handleSelect(event.target.id.substring(event.target.id.indexOf("-") + 1));
                }
            );
            if (response.ss === "smart_reduced" && i == response.students.length - 1) {
                var slot_num = i + 1;
                slot_id = "stu_slot_" + slot_num;
                var no_more_html = "<div class='object' style='padding: 20px; text-align: center;'>"
                                 +      "<h3>Sorry we couldn't find anymore candidates fitting your criteria</h3>"
                                 +      "<br/>"
                                 +      "<h4>Perhaps try relaxing your filters</h4>"
                                 + "</div>";
                document.getElementById(slot_id).innerHTML = no_more_html;
            }
        }
        if (response.students.length == 0) {
            slot_id = "stu_slot_0";
            var no_more_html =  "<div class='object' style='padding: 20px; text-align: center;'>"
                             +      "<h3>Sorry we couldn't find anymore candidates fitting your criteria</h3>"
                             +      "<br/>"
                             +      "<h4>Perhaps try relaxing your filters</h4>"
                             +  "</div>";
            document.getElementById(slot_id).innerHTML = no_more_html;
        }
        if (latest_selected_candidate_id.length > 0 && !block_sel_candidate) {
            update_selected_candidate(latest_selected_candidate_id);
        }
        update_offset_buttons();
        
    } else if (xhr.readyState == 4 && xhr.status == 200 && table_view) {
        
        // Debugging term
        // alert(xhr.responseText);
        var response = JSON.parse(xhr.responseText);
        
        var c_stu_html, slot_id = "";
        var c_stu, uni;
        for (i = 0; i < response.students.length; i++) {
            c_stu = response.students[i];
            console.log(c_stu)
            /* c_stu_html ="<label>" +
                            "<input type='checkbox' id='select-" + c_stu.itd + "'"; 
            if (selected_candidate_ids.includes(c_stu.itd)) {
                c_stu_html += " checked";
            }
            c_stu_html +=   ">"; */
            
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
            
            c_stu_html = "<td ><button  data-type='studentlist_btn' data-id='"+c_stu.itd+"'";
            var ind = selected_candidate_ids.indexOf(c_stu.itd);
            if (ind > -1) {
                c_stu_html+=" class='checked' ";
            } else {
                c_stu_html+=" class='' ";
            }
            c_stu_html+=" onclick='studentlist_candidate(" + c_stu.itd + ",this)'";
            c_stu_html+=    ">";
            if (ind > -1) {
                c_stu_html+="<span><i class='fa fa-check'></i></span>";
            }
            
            c_stu_html +=    "</button></td>"+
            
                            "<td>" + c_stu.fname + "</td>" +
                            "<td>" + c_stu.course + "</td>" +
                            "<td>" + c_stu.grade + "</td>" +
                            "<td>" + c_stu.university + "</td>" +
                            "<td>" + c_stu.college + "</td>" +
                            "<td>" + c_stu.course_end + "</td>" +
                            // Sort out shortlist button
                            "<td ><button  data-type='shortlist_btn' data-id='"+c_stu.itd+"'";
            if (c_stu.shortlisted != 0) {
                c_stu_html+=" class='checked' ";
            } else {
               c_stu_html+=" class='' ";
            }
             c_stu_html+=" onclick='shortlist_candidate(" + c_stu.itd + ",this)'";
            c_stu_html+=    ">";
            if (c_stu.shortlisted != 0) {
                c_stu_html+="<span><i class='fa fa-check'></i></span>";
            }
            c_stu_html+=    "</button></td>" +
                            "<td class='text-center'><a  onclick='email_fun("+c_stu.itd+")' data-toggle='modal' data-target='#bulk_email'><i class='fa fa-envelope-o'><i></a></td>" +
                            //Sort out contact button
                            "<td><button  data-type='contact_btn' data-id='"+c_stu.itd+"' ";
            if (c_stu.contacted_already != 0) {
                c_stu_html+=" class='checked' ";
            } else {
                c_stu_html+=" class='' ";
            }
            c_stu_html+=" onclick='access_details(" + c_stu.itd + ",this)'";
            c_stu_html+=    ">";
            if (c_stu.contacted_already != 0) {
                c_stu_html+="<span><i class='fa fa-check'></i></span>";
            }
            c_stu_html+=    "</button></td>" +
                            "<td class='cvs' data-id='"+c_stu.itd+"'></td>" +
                            "<!-------td><button onclick='edit_student_notesCCC(" + c_stu.itd + ")'></button></td-------------->" +
                        "</label>";
            /*if (c_stu.contacted_already != 0) {
                c_stu_html+=        "<span class='contacted_already_icon'><i class='fas fa-address-book'></i></span>";
            }
            c_stu_html+=            "<p class='candname'>" + c_stu.fname + " from " + c_stu.university + "</p>" +
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
            */
            slot_id = "stu_slot_" + i;
            document.getElementById(slot_id).innerHTML = c_stu_html;
            /*
            document.getElementById("select-" + c_stu.itd).addEventListener(
                "change",
                function(event) {
                    handleSelect(event.target.id.substring(event.target.id.indexOf("-") + 1));
                }
            ); */
            /* if (response.ss === "smart_reduced" && i == response.students.length - 1) {
                var slot_num = i + 1;
                slot_id = "stu_slot_" + slot_num;
                var no_more_html = "<div class='object'>"
                                 +      "<h3>Sorry we couldn't find anymore candidates fitting your criteria</h3>"
                                 +      "<h4>Perhaps try relaxing your filters</h4>"
                                 + "</div>";
                document.getElementById(slot_id).innerHTML = no_more_html;
            } */
        }
        
        // Clear up empty slots
        console.log(max_results)
        for (i = 0; i < max_results; i++) {
            slot_id = "stu_slot_" + i;
            var slot = document.getElementById(slot_id);
            if (slot.innerHTML == "") {
                slot.parentNode.removeChild(slot);
            }
        }
        
        if (latest_selected_candidate_id.length > 0 && !block_sel_candidate) {
            update_selected_candidate(latest_selected_candidate_id);
        }
        update_offset_buttons();
    }

    make_table(response.students);
}



var data_table_maked = 0;


function make_table(dataSet){

    //$('#student_alls').DataTable().clear();



    var dataSet_2 = [
    [ Math.random(), "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800" ],
    [ "Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750" ],
    [ "Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000" ],
    [ "Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060" ],
    [ "Airi Satou", "Accountant", "Tokyo", "5407", "2008/11/28", "$162,700" ],
    [ "Brielle Williamson", "Integration Specialist", "New York", "4804", "2012/12/02", "$372,000" ],
    [ "Herrod Chandler", "Sales Assistant", "San Francisco", "9608", "2012/08/06", "$137,500" ],
    [ "Rhona Davidson", "Integration Specialist", "Tokyo", "6200", "2010/10/14", "$327,900" ],
    [ "Colleen Hurst", "Javascript Developer", "San Francisco", "2360", "2009/09/15", "$205,500" ],
    [ "Sonya Frost", "Software Engineer", "Edinburgh", "1667", "2008/12/13", "$103,600" ],
    [ "Jena Gaines", "Office Manager", "London", "3814", "2008/12/19", "$90,560" ],
    [ "Quinn Flynn", "Support Lead", "Edinburgh", "9497", "2013/03/03", "$342,000" ],
    [ "Charde Marshall", "Regional Director", "San Francisco", "6741", "2008/10/16", "$470,600" ],
    [ "Haley Kennedy", "Senior Marketing Designer", "London", "3597", "2012/12/18", "$313,500" ],
    [ "Tatyana Fitzpatrick", "Regional Director", "London", "1965", "2010/03/17", "$385,750" ],
    [ "Michael Silva", "Marketing Designer", "London", "1581", "2012/11/27", "$198,500" ],
    [ "Paul Byrd", "Chief Financial Officer (CFO)", "New York", "3059", "2010/06/09", "$725,000" ],
    [ "Gloria Little", "Systems Administrator", "New York", "1721", "2009/04/10", "$237,500" ],
    [ "Bradley Greer", "Software Engineer", "London", "2558", "2012/10/13", "$132,000" ],
    [ "Dai Rios", "Personnel Lead", "Edinburgh", "2290", "2012/09/26", "$217,500" ],
    [ "Jenette Caldwell", "Development Lead", "New York", "1937", "2011/09/03", "$345,000" ],
    [ "Yuri Berry", "Chief Marketing Officer (CMO)", "New York", "6154", "2009/06/25", "$675,000" ],
    [ "Caesar Vance", "Pre-Sales Support", "New York", "8330", "2011/12/12", "$106,450" ],
    [ "Doris Wilder", "Sales Assistant", "Sydney", "3023", "2010/09/20", "$85,600" ],
    [ "Angelica Ramos", "Chief Executive Officer (CEO)", "London", "5797", "2009/10/09", "$1,200,000" ],
    [ "Gavin Joyce", "Developer", "Edinburgh", "8822", "2010/12/22", "$92,575" ],
    [ "Jennifer Chang", "Regional Director", "Singapore", "9239", "2010/11/14", "$357,650" ],
    [ "Brenden Wagner", "Software Engineer", "San Francisco", "1314", "2011/06/07", "$206,850" ],
    [ "Fiona Green", "Chief Operating Officer (COO)", "San Francisco", "2947", "2010/03/11", "$850,000" ],
    [ "Shou Itou", "Regional Marketing", "Tokyo", "8899", "2011/08/14", "$163,000" ],
    [ "Michelle House", "Integration Specialist", "Sydney", "2769", "2011/06/02", "$95,400" ],
    [ "Suki Burks", "Developer", "London", "6832", "2009/10/22", "$114,500" ],
    [ "Prescott Bartlett", "Technical Author", "London", "3606", "2011/05/07", "$145,000" ],
    [ "Gavin Cortez", "Team Leader", "San Francisco", "2860", "2008/10/26", "$235,500" ],
    [ "Martena Mccray", "Post-Sales support", "Edinburgh", "8240", "2011/03/09", "$324,050" ],
    [ "Unity Butler", "Marketing Designer", "San Francisco", "5384", "2009/12/09", "$85,675" ]
];


var re = [];

$.each(dataSet, function( index, value ) {
  re.push(['<input type="checkbox" value="'+value.itd+'">',value.fname,value.course,value.grade,value.university,value.college,value.grad_year,value.shortlisted,]);
});


if (data_table_maked==0){

    $('#student_alls').DataTable( {
        data: re,
        columns: [
            { title: "<i class='fa fa-check'></i>" },
            { title: "Name" },
            { title: "Course" },
            { title: "Grade" },
            { title: "University" },
            { title: "College" },
            { title: "Grade Year" },
            { title: "<i class='fa fa-list-alt'></i>" },
            { title: "<i class='fa fa-envelope'></i>" },
            { title: "<i class='fa fa-envelope'></i>" },
            { title: "<i class='fa fa-envelope'></i>" },
        ]
    } );

    data_table_maked++;

    }

}