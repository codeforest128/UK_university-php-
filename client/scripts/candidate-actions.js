function handleSelect(id) {
    
    if (!selected_candidate_ids.includes(id)) {
        update_selected_candidate(id);
        selected_candidate_ids.push(id);
    } else {
        latest_selected_candidate_id = 0;
        var ind = selected_candidate_ids.indexOf(id);
        if (ind > -1) {
            selected_candidate_ids.splice(ind, 1);
        }
    }
    console.log(selected_candidate_ids)
    var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
    document.getElementById("sel_count_basic").innerHTML = selected_candidate_ids.length + sel;
    document.getElementById("sel_count_smart").innerHTML = selected_candidate_ids.length + sel;
}

async function update_selected_candidate(id) {
    var key, url, vari, dest;
    latest_selected_candidate_id = id;
    key = document.getElementById('ajax_ver').innerHTML;
    url = "requests/current_candidate.php";
    vari = { "id": id, "key": key };
    dest = "selected_candidate";
    request(url, vari, dest, true);
}

function shortlist_candidate(id = latest_selected_candidate_id,ele) {

    // $(ele).attr('disabled','');
    // $(ele).attr('class','checked');
    // $(ele).html('<span><i class="fa fa-check"></i></span>');
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
    
    var key, url, vari, dest;
    key = document.getElementById('ajax_ver').innerHTML;
    url = "requests/shortlist_candidate.php";
    vari = {"id": id, "key": key,'checked':checked};
    dest = 'update'; 
    request(url, vari, dest, true);
}

function studentlist_candidate(id = latest_selected_candidate_id, ele){

    var checked = 0;
    id = String(id);
    console.log(id)
    if ($(ele).hasClass('checked')){
        checked = 1;
    }
    if (checked==1){
        $(ele).removeClass('checked');
        $(ele).html('');
        latest_selected_candidate_id = 0;
        var ind = selected_candidate_ids.indexOf(id);
        if (ind > -1) {
            selected_candidate_ids.splice(ind, 1);
        }
    }else{
        $(ele).addClass('checked');
        $(ele).html('<span><i class="fa fa-check"></i></span>');
        update_selected_candidate(id);
        selected_candidate_ids.push(id);
    }
    console.log(selected_candidate_ids)
    var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
    document.getElementById("sel_count_basic").innerHTML = selected_candidate_ids.length + sel;
    document.getElementById("sel_count_smart").innerHTML = selected_candidate_ids.length + sel;

}

function shortlist_selected_candidates() {
    selected_candidate_ids.forEach(function(x) {
        shortlist_candidate(x);
    });
    update_center();
}

function access_details(user_id,ele) {

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

    var key, url, vari, fin_url;
    key = document.getElementById('ajax_ver').innerHTML;
    url = "requests/access_details.php";
    vari = {"id": user_id, "key": key,'checked':checked};
    fin_url = createUrl(url, vari);
    try {
        xhr = new XMLHttpRequest();
    } catch (e) {
        return;
    }
    xhr.onreadystatechange = parse_contact_details;
    xhr.open("GET", fin_url, true);
    xhr.send();
}

function access_details_selected_candidates() {
    selected_candidate_ids.forEach(function(x) {
        access_details(x);
    });
    update_center();
}

function parse_contact_details() {
    if (xhr.readyState == 4) {
      //  update_center();
    }
}

function edit_student_notes(id) {
    var key, url, vari, fin_url;
    key = document.getElementById('ajax_ver').innerHTML;
    url = "requests/fetch_student_notes.php";
    vari = {"id": id, "key": key};
    fin_url = createUrl(url, vari);
    try {
        xhr = new XMLHttpRequest();
    } catch (e) {
        return e;
    }
    xhr.onreadystatechange = parse_student_notes;
    xhr.open("GET", fin_url, true);
    xhr.send();
    
    // Display notes modal
    $('#notes_modal').modal('show');
}

function parse_student_notes() {
    if (xhr.readyState == 4) {
        var response = JSON.parse(xhr.responseText);
        var parse_html = "";
        var counter = 0;
        response.forEach(function(x) {
            parse_html += "<input type='hidden' name='note-date-" + counter + "'>"
                        + "<label>" + x.date + "</label>"
                        + "<textarea name='note-" + counter + "' class='form-control'>" + x.cont + "</textarea><br/>";
            counter++;
        });
        parse_html += "<textarea name='note-" + counter + "' class='form-control'></textarea><br/><button type='submit' name='note-submit' id='note-submit'>Submit changes</button>"
        counter++;
        parse_html += "<input type='hidden' name='amount' value='" + counter + "'>"
                    + "<input type='hidden' name='stu_id'>";
        document.getElementById('student_notes_box').innerHTML = parse_html;
    }
}

function fetch_email_list() {
    document.getElementById('email-students-list').value = JSON.stringify(selected_candidate_ids);
}

function fetch_email_to() {
    document.getElementById('email-student-list').value = "[" + latest_selected_candidate_id + "]";
}

function view_cv() {
    var url = "https://oxbridgecareershub.co.uk/client/database.php?cv=true&latest=" + JSON.stringify(latest_selected_candidate_id) + "&selected=" + JSON.stringify(selected_candidate_ids);
    window.location = url;
}