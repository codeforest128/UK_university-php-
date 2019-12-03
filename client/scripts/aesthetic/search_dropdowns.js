function selectDropDown(evt, ddName, s_type) {
    var dropdowns, dd_boxes, c_sel;

    // Check if currently selected
    if (evt.currentTarget.classList.contains("active")) {
        c_sel = true;
    }

    // Hide all current dropdowns
    dropdowns = document.getElementsByClassName("dd_content");
    console.log(dropdowns);
    for (i = 0; i < dropdowns.length; i++) {
        c_dd = dropdowns[i];
        c_dd.style.display = "none";
    }

    // Deactivate all current boxes
    dd_boxes = document.getElementsByClassName("dd_box");
    for (i = 0; i < dd_boxes.length; i++) {
        dd_boxes[i].classList.remove("active");
    }

    // If it was selected before, now return before reactivating any
    if (c_sel) {
        return;
    }

    // Show current dropdowns
    document.getElementById(ddName + "_" + s_type).style.display = "inline-block";

    // Highlight current box
    evt.currentTarget.classList.add("active");
}

function filterDropDown(evt) {
    var filter, type, tid, ul;

    // Get value of search
    filter = evt.currentTarget.value.toLowerCase();

    // Find field it's searching
    tid = evt.currentTarget.id;
    type = tid.substring(0, tid.indexOf("_"));
    s_type = tid.substring(tid.length - 5);

    // Select the li tags within the associated ul
    ul = document.getElementById(type + "_ul_" + s_type);
    li = ul.getElementsByTagName("li");

    // Loop through selected tags and correct formatting
    for (i = 0; i < li.length; i++) {
        c_val_slot = li[i].getElementsByTagName("label")[0];
        c_val = c_val_slot.textContent || c_val_slot.innerText;
        if (c_val.toLowerCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

document.getElementById("basic_search_button").classList.add("active");

function update_filter_total(evt) {
    var type = evt.currentTarget.name.substring(0, evt.currentTarget.name.indexOf('-'));
    var ul_id = evt.currentTarget.parentElement.parentElement.parentElement.id;
    var s_type = ul_id.substring(ul_id.length - 5);
    var total_container = document.getElementById(type + '_filter_total_' + s_type);
    var c_total = parseInt(total_container.innerHTML);
    var n_total = c_total;
    if (evt.currentTarget.checked) {
        n_total = c_total + 1;
    } else {
        n_total = c_total - 1;
    }
    
    if (n_total == 1) {
        if (type != "gradyear") {
            total_container.innerHTML = n_total + " " + type + " ";
        } else {
            total_container.innerHTML = n_total + " year ";
        }
    } else {
        if (type != "gradyear") {
            total_container.innerHTML = n_total + " " + type + "s ";
        } else {
            total_container.innerHTML = n_total + " years ";
        }
    }
    
}
// Try to get this to work...
/*
document.getElementById('search_tab').addEventListener(
    "onmouseleave",
    function(event) {
        alert("trigger");
        // Hide all current dropdowns
        dropdowns = document.getElementsByClassName("dd_content");
        for (i = 0; i < dropdowns.length; i++) {
            c_dd = dropdowns[i];
            c_dd.style.display = "none";
        }

        // Deactivate all current boxes
        dd_boxes = document.getElementsByClassName("dd_box");
        for (i = 0; i < dd_boxes.length; i++) {
            dd_boxes[i].classList.remove("active");
        }        
    }
);
*/