function selectDropDown(evt, ddName) {
    var dropdowns, dd_boxes, c_sel;

    // Check if currently selected
    if (evt.currentTarget.classList.contains("active")) {
        c_sel = true;
    }

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

    // If it was selected before, now return before reactivating any
    if (c_sel) {
        return;
    }

    // Show current dropdowns
    document.getElementById(ddName).style.display = "inline-block";

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

    // Select the li tags within the associated ul
    ul = document.getElementById(type + "_ul");
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
    var c_total = parseInt(document.getElementById(type + '_filter_total').innerHTML);
    var n_total = c_total;
    if (evt.currentTarget.checked) {
        n_total = c_total + 1;
    } else {
        n_total = c_total - 1;
    }
    if (n_total == 1) {
        if (type != "gradyear") {
            document.getElementById(type + '_filter_total').innerHTML = n_total + " " + type + " ";
        } else {
            document.getElementById(type + '_filter_total').innerHTML = n_total + " year ";
        }
    } else {
        if (type != "gradyear") {
            document.getElementById(type + '_filter_total').innerHTML = n_total + " " + type + "s ";
        } else {
            document.getElementById(type + '_filter_total').innerHTML = n_total + " years ";
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