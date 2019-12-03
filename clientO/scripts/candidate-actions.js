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
    var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
    document.getElementById("sel_count").innerHTML = selected_candidate_ids.length + sel;
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

function shortlist_candidate(id = latest_selected_candidate_id) {
    var key, url, vari, dest;
    key = document.getElementById('ajax_ver').innerHTML;
    url = "requests/shortlist_candidate.php";
    vari = {"id": id, "key": key};
    dest = 'update'; 
    request(url, vari, dest, true);
}

function shortlist_selected_candidates() {
    selected_candidate_ids.forEach(function(x) {
        shortlist_candidate(x);
    });
    update_center();
}

function access_details(user_id) {
    var key, url, vari, fin_url;
    key = document.getElementById('ajax_ver').innerHTML;
    url = "requests/access_details.php";
    vari = {"id": user_id, "key": key};
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
        update_center();
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