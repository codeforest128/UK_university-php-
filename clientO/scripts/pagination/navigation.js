update_offset_buttons();

function change_offset(type, amount) {
    if (type == 0) {
        stu_offset += amount;
    } else {
        stu_offset = parseInt(amount.target.value);
    }
    update_center();
    /* Moved update_offset_buttons to be called in update center as it allowed the post information to be used */
}

function update_offset_buttons() {
    var prev = document.getElementById('prev_button');
    var next = document.getElementById('next_button');
    // alert(total_selection_size);
    // alert(max_results);
    var cap_offset = Math.floor(total_selection_size / max_results);
    // Debugging    
    // alert(cap_offset);
    // Sort prev button
    if (stu_offset == 0) {
        prev.style.display = "none";
    } else {
        prev.style.display = "inline-block";
    }
    // Sort next button
    if (stu_offset == cap_offset) {
        next.style.display = "none";
    } else {
        next.style.display = "inline-block";
    }
    // Sort individual buttons
    var val_shift; 
    var highest_page = 5;
    if (cap_offset < 4) {
        highest_page = cap_offset + 1;
    }
    switch (stu_offset) {
        case 0:
        case 1:
            val_shift = 0;
            break;
        case cap_offset - 2:
        case cap_offset - 1:
        case cap_offset:
            val_shift = cap_offset - (highest_page - 1);
            break;
        default:
            val_shift = stu_offset - 2;
    }
    for (i = 1; i <= 5; i++) {
        var visible = i <= highest_page;
        var high;
        if (val_shift == 0) {
            high = stu_offset + 1;
        } else if (val_shift == cap_offset - 4) {
            high = stu_offset - cap_offset + 5
        } else {
            high = 3;
        }
        var but = document.getElementById('nav-button-' + i);
        but.value = i + val_shift - 1;
        but.innerHTML = i + val_shift;
        if (i == high) {
            but.classList.remove("noselpagination");
            if (!but.classList.contains("pagination")) {
                but.classList.add("pagination");
            }
        } else {
            but.classList.remove("pagination");
            if (!but.classList.contains("noselpagination")) {
                but.classList.add("noselpagination")
            }
        }
        if (!visible) {
            but.style.display = "none";
        } else {
            but.style.display = "block";
        }
    }
}