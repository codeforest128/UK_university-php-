function select_all_process_response() {
    if (xhr.readyState == 4) {
        selected_candidate_ids = JSON.parse(xhr.responseText);
        var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
        document.getElementById("sel_count").innerHTML = selected_candidate_ids.length + sel;
        update_center();
    }
}

function select_all_cand(evt) {
    var ajax_ver = document.getElementById("ajax_ver").innerHTML;
    var type = evt.currentTarget.id;
    type = type.substring(type.indexOf('-') + 1, type.length);
    var url = "requests/select_all.php";
    var vari = {"type" : type, "key" : ajax_ver};
    var fin_url = createUrl(url, vari);
    try {
        xhr = new XMLHttpRequest();
    } catch(e) {
        return;
    }
    xhr.onreadystatechange = select_all_process_response;
    xhr.open("GET", fin_url, true);
    xhr.send();
}

function deselect_all_cand() {
    selected_candidate_ids = [];
    update_center();
    document.getElementById("sel_count").innerHTML = "0 candidates";
}

var filter_check = document.getElementById('filter_check');
filter_check.addEventListener(
    "change",
    function(event) {
        if (event.currentTarget.checked) {
            use_filters = true;
        } else {
            use_filters = false;
        }
        update_center();
    }
);

filter_check.addEventListener(
    "mouseenter",
    function() {
        document.getElementById('use_filter_info').style.display = "block";
    }
);
filter_check.addEventListener(
    "mouseleave",
    function() {
        document.getElementById('use_filter_info').style.display = "none";
    }
)

var deselect = document.getElementById('deselect_all_button');
deselect.addEventListener(
    "mouseenter",
    function() {
        document.getElementById('deselect_info').style.display = "block";
    }
)

deselect.addEventListener(
    "mouseleave",
    function() {
        document.getElementById('deselect_info').style.display = "none";
    }
)