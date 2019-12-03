<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Keyword search</p>
    <input type="text" class="keyword" name="keywords"  placeholder="e.g. neural net, machine learning, etc..." value="<?php echo isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";?>" style="text-indent: 5px;">
</div>
<!--<input type="hidden" class="keyword" name="keywords"  id="smart_search_input_original" placeholder="e.g. neural net, machine learning, etc..." value="<?php echo isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";?>" style="text-indent: 5px;">-->

<div class="filtersec">
    <p style="font-size:16px;font-weight:bold">Amount of candidates to display</p>
	<?php 
		$ck="";
		$ck = isset($_REQUEST['amount_required'])?$_REQUEST['amount_required']:"";
	?>
    <select name="amount_required" class="form-control">
        <option <?php if($ck!="" && $ck=='5') echo "selected"; ?> value='5'>5</option>
        <option <?php if($ck!="" && $ck=='10') echo "selected"; ?> value='10'>10</option>
        <option <?php if($ck!="" && $ck=='15') echo "selected"; ?> value='15'>15</option>
        <option <?php if($ck!="" && $ck=='20') echo "selected"; ?> value='20'>20</option>
        <option <?php if($ck!="" && $ck=='25') echo "selected"; ?> value='25'>25</option>
    </select>
</div>