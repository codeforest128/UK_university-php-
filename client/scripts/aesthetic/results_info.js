document.getElementById('max-results-info-hover').addEventListener(
    "mouseenter",
    function() {
        var info = document.getElementById("max-results-info-container");
        info.classList.remove("invisible");
    }
)

document.getElementById('max-results-info-hover').addEventListener(
    "mouseleave",
    function() {
        var info = document.getElementById("max-results-info-container");
        info.classList.add("invisible");
    }
)

function reveal_select_all(type) {
    var selects = document.getElementsByClassName('select_all_button');
    for (i = 0; i < selects.length; i++) {
        selects[i].style.display = "none"
    }
    if (type == "SHRT" || type == "CNTCT") {
        document.getElementById('select_all-' + type).style.display = "block";
    }
}