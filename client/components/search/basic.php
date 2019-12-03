<form action="" method="POST" id="basicf">
    <input type="hidden" name="search-type" value="basic"/>
    <?php
        $search_type = "basic";
        include_once "formblock/opp_type.php";
        include_once "formblock/dropdowns.php";
        //include_once "formblock/submit_search.php";
    ?>
	<button class="submit-search" id="sub" type="submit">Search</button>
</form>
<script>
	
	$('#sub').on('click',function(e){
		$("#basicf").attr("method", "post");
        $("#basicf").submit();
		// e.preventDefault();
        // $('#loader').css('display','block');
        // $('body').css('opacity','.8');
        // $('body').css('position','relative');
        // setTimeout(function(){$('#basicf').submit()},3000);
		
	});
	
</script>