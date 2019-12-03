function select_all_process_response() {
    if (xhr.readyState == 4) {
        selected_candidate_ids = JSON.parse(xhr.responseText);
        var sel = selected_candidate_ids.length == 1 ? " candidate" : " candidates";
        document.getElementById("sel_count_basic").innerHTML = selected_candidate_ids.length + sel;
        document.getElementById("sel_count_smart").innerHTML = selected_candidate_ids.length + sel;
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
    document.getElementById("sel_count_basic").innerHTML = "0 candidates";
    document.getElementById("sel_count_smart").innerHTML = "0 candidates";
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

 var view_check = document.getElementById('view_check');
view_check.addEventListener(
    "change",
    function(event) {
        table_view = event.currentTarget.checked;
        update_center();
    }
) 

var deselect = document.getElementById('deselect_all_button_basic');
deselect.addEventListener(
    "mouseenter",
    function() {
        document.getElementById('deselect_info_basic').style.display = "block";
    }
)

deselect.addEventListener(
    "mouseleave",
    function() {
        document.getElementById('deselect_info_basic').style.display = "none";
    }
)

var deselect_smart = document.getElementById('deselect_all_button_smart');
deselect_smart.addEventListener(
    "mouseenter",
    function() {
        document.getElementById('deselect_info_smart').style.display = "block";
    }
)
deselect_smart.addEventListener(
    "mouseleave",
    function() {
        document.getElementById('deselect_info_smart').style.display = "none";
    }
)

var select_alls = document.getElementsByClassName("select_all_button");
for (i = 0; i < select_alls.length; i++) {
    var elem = select_alls[i];
    elem.addEventListener(
        "mouseenter",
        function() {
            document.getElementById('select_all_info_basic').style.display = "block";
        }
    );
    /*elem.addEventListener(
        "mouseleave",
        function() {
            //document.getElementById('select_all_info_basic').style.display = "none";
        }
    );*/
    elem.addEventListener(
        "mouseenter",
        function() {
            document.getElementById('select_all_info_smart').style.display = "block";
        }
    );
    /*elem.addEventListener(
        "mouseleave",
        function() {
            //document.getElementById('select_all_info_smart').style.display = "none";
        }
    );*/
}

