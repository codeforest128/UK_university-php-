<style>
/*.clear_btn {
    position: absolute;
    left: 1.5vw !important;
    top: 145px !important;
    width: 7vw !important;
}*/
</style>
<!-- <label  style="margin-left:20px;" class="clear_btn" id="search_clear">
                                 <p style="display:inline">Clear Filter</p>
                    <i class="fa fa-refresh"></i>
</label> -->
<!----img src="../images/clear.png" class="clear_btn" id="search_clear"----------->

<div class="leftfilter">
   <div class="tab1">
        <button id="basic_search_button" class="tablinks1" onclick="openTab1(event, 1, 'search_tab')">Search</button>
        <button id="smart_search_button" class="tablinks1" onclick="openTab1(event, 1, 'smart_search_tab')">Smart Search</button>
    </div>
    <div id="search_tab" class="tabcontent1">
        <?php include_once "search/basic.php"; ?>
    </div>
	
    <div id="smart_search_tab" class="tabcontent1 closed_search_tab">
        <?php include_once "search/smart.php"; ?>
    </div>
</div>

<script>
	$('#search_clear').on('click',function(e){

                window.location.replace("database.php");
        return false;
	    
		
		$("#basicf").attr("method", "get");
        $("#basicf").submit();
        
        document.getElementById("basicf").reset();
		document.getElementById("smartf").reset();
    });
    
</script>