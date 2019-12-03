<form action="" method="POST" id="smartf">
    <input type="hidden" name="search-type" value="smart"/>
    <?php
        $search_type = "smart";
        include "formblock/opp_type.php";
        include "formblock/smart_additions.php";
        include "formblock/dropdowns.php";
        include "formblock/submit_search.php";
    ?>
	<button class="submit-search" id="sub1" type="submit">Search</button>
</form>
<script>
	$('#sub1').on('click',function(e){
        $('#smartf').submit();
		e.preventDefault();
        $('#loader').css('display','block');
        $('body').css('opacity','.8');
        $('body').css('position','relative');
        setTimeout(function(){$('#smartf').submit()},3000);
		
	});
</script>