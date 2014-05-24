<?php
$refineSerachFieldArr = array();
$refineModule = $_GET['module'];
$refineRel = $_GET['rel'];
if(isset($refineModule) && !empty($refineModule) && $refineModule=='company' && $refineRel=='common_listing')
{
	$refineSerachFieldArr = $refineSearch_company;
}
elseif(isset($refineModule) && !empty($refineModule) && $refineModule=='customer' && $refineRel=='common_listing')
{
	$refineSerachFieldArr = $refineSearch_customer;
}
$refineSerachFieldArrCount = count($refineSerachFieldArr);

// show refine search where it is required.
if($refineSerachFieldArrCount > 0){
?>
<td align="left" class="black11">&nbsp;&nbsp;&nbsp;In&nbsp;</td>
<td align="left">
	<select name="refine_search" id="refine_search" style="width:195px">
		<option value="noValueSelected" selected="selected">Please select search key</option>
			<?php foreach($refineSerachFieldArr as $val => $option ) {
			echo '<option value="'.$val.'">'.$option.'</option>';
			} ?>

	</select>
</td>
<?php } ?>
