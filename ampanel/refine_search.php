<td align="left" class="black11">&nbsp;&nbsp;&nbsp;In&nbsp;</td>
<td align="left">
	<select name="refine_search" id="refine_search" style="width:195px">
		<option value="noValueSelected" selected="selected">Please select search key</option>
			<?php foreach( $advSearch_company as $val => $option ) {
			echo '<option value="'.$val.'">'.$option.'</option>';
			} ?>

	</select>
</td>
