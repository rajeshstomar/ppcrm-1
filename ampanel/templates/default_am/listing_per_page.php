<form name="numofPagevalue" id="numofPagevalue" method="post" action="">
<input type="hidden" name="hidediv" id="hidediv" value="<?=$total_pages;?>">
<div id="selectdiv">				
Records per page: <select  id="show_max_row" name="show_max_row" onchange="doactionForlimit();">
	<option  value="25">25</option>
    <option  value="50">50</option>
	<option  value="100">100</option>
	<option  value="250">250</option>
	<option value="500">500</option>
	</select>
</div>
</form>