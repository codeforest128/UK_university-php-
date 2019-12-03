/* Add hover event listeners */
function initialise_selectors() {
    var options_ul = document.getElementById('sel-options');
    var option_lis = options_ul.getElementsByTagName('li');
    var c_opt, target_a;
    for (var i = 0; i < option_lis.length; i++) {
        c_opt = option_lis[i];
        target_a = c_opt.getElementsByTagName('a')[0];
        target_a.addEventListener(
            "mouseenter",
            e => {
                handle_uni_selector_enter(e);
            }
        );
        target_a.addEventListener(
            "mouseleave",
            e => {
                handle_uni_selector_leave(e);
            }
        );
    }
}

function handle_uni_selector_enter(evt) {
    evt.currentTarget.classList.add("underline");
}
function handle_uni_selector_leave(evt) {
    evt.currentTarget.classList.remove("underline");
}

initialise_selectors();

function select_tm(uni) {
    /* Deal with aesthetics */
    var options_ul = document.getElementById('sel-options');
    var option_lis = options_ul.getElementsByTagName('li');
    for (i = 0; i < option_lis.length; i++) {
        option_lis[i].classList.remove("active");
    }
    document.getElementById('sel-' + uni).classList.add("active");
    
    /* Filter out people*/
    var types;
    switch(uni) {
        case "ox":
            types = ["OXFORD"];
            break;
        case "cam":
            types = ["CAMBRIDGE"];
            break;
        case "imp":
            types = ["IMPERIAL"];
            break;
        case "dur":
            types = ["DURHAM"];
            break;
        default:
            types = [];
    }
    var person, p_div_code, p_uni_code;
    var people = document.getElementsByClassName("team_grid_info");
    for (i = 0; i < people.length; i++) {
        person = people[i];
        p_uni_code = person.getElementsByClassName("uni-id")[0];
        if (types.length == "0") {
            person.style.display = "unset";
        } else if(!types.includes(p_uni_code.innerHTML)) {
            person.style.display = "none";
        } else {
            person.style.display = "unset";
        }
    }
}

