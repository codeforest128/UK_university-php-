document.getElementById('ind-email-helper').addEventListener(
    "mouseenter",
    function() {
        var info = document.getElementById("email-info-individual");
        info.classList.remove("invisible");
    }
)

document.getElementById('ind-email-helper').addEventListener(
    "mouseleave",
    function() {
        var info = document.getElementById("email-info-individual");
        info.classList.add("invisible");
    }
)

document.getElementById('bulk-email-helper').addEventListener(
    "mouseenter",
    function() {
        var info = document.getElementById("email-info-bulk");
        info.classList.remove("invisible");
    }
)

document.getElementById('bulk-email-helper').addEventListener(
    "mouseleave",
    function() {
        var info = document.getElementById("email-info-bulk");
        info.classList.add("invisible");
    }
)