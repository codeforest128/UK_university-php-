/*document.getElementById('ind-email-helper').addEventListener(
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
)*/




$("#ind-email-helper").click(function(){
  if($('#email-info-individual').hasClass('invisible')==true){
      $("#email-info-individual").removeClass("invisible");
  }else{
      $("#email-info-individual").addClass("invisible");
  }
});


$("#email-info-individual").click(function(){
  $("#email-info-individual").addClass("invisible");
});



$("#bulk-email-helper").click(function(){
  if($('#email-info-bulk').hasClass('invisible')==true){
      $("#email-info-bulk").removeClass("invisible");
  }else{
      $("#email-info-bulk").addClass("invisible");
  }
});


$("#email-info-bulk").click(function(){
  $("#email-info-bulk").addClass("invisible");
});
