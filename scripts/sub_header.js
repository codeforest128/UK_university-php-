function initialise_sub_header() {
    sub_ul = document.getElementById('sub_header_ul');
    lis = sub_ul.getElementsByTagName('li');
    var a_target;
    for (i = 0; i < lis.length; i++) {
        c_li = lis[i];
        a_target = c_li.getElementsByTagName("a")[0];
        if (a_target == null) {
            continue;
        }
        a_target.addEventListener(
            "mouseenter",
            e => {
                handle_short_mouse_enter(e);
            }
        )
        a_target.addEventListener(
            "mouseleave",
            e => {
                handle_short_mouse_leave(e);
            }
        )
    }
}

function handle_short_mouse_enter(evt) {
    evt.currentTarget.classList.add("underline");
}
function handle_short_mouse_leave(evt) {
    evt.currentTarget.classList.remove("underline");
}

initialise_sub_header();