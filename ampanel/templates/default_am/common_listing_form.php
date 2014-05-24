<div id="adv_search" style="display:none;"><a class="button" href="javascript:void(0);" onClick="show_id('adv_search_a'); $('#adv_search').hide();$('.searchAlph').show();">Show Basic Search</a>
<br/>
<form name="adv_search_form" action="index.php?rel=common_listing&module=company" method="POST">
	<table id="mastertable">
		<tr id="master_row">
			<td>
				<select name="field[]">
					<option value="broker_name">Broker Name</option>
					<option value="company_name">Firm Name</option>
					<option value="mobile1_no">Mobile</option>
					<option value="area">Area</option>
					<option value="sector">Sector</option>
					<option value="category">Category</option>
					<option value="email">Email</option>
					<option value="pan_card_num">Pan Card No</option>
					<option value="address">Address</option>
				</select>
			</td>
			<td>
				<select name="adv_operation[]">
					<option value="LIKE">equals</option>
					<option value="NOT LIKE">not equals</option>
					<option value=">">greater than</option>
					<option value="<">less than</option>
					<option value="%">starts with</option>
				</select>
			</td>
			<td>
				<input name="value[]" type="text" placeholder="Input Value" />
			</td>
			<td id="and-or" style="display:none;">
				<select name="query_type[]">
					<option value="AND" selected="selected">and</option>
					<option value="OR">or</option>
				</select>
			</td>
		</tr>
		
	</table>
	<br/>
	<a href="#" class="button" id="addScnt">Add Condition</a><a href="javascript:void(0);" class="button" id="remScnt">Remove Last</a>
	<hr/>
	<input type="submit" style="margin:0 40% 0 40%" name="submit" value="Submit" />
</form>
</div>
<form name="frmlist" id="frmlist" method="post" action="">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="module" id="module" value="<?=$module;?>">


<table width="100%" border="0" cellspacing="2" cellpadding="5">

  <?php 
  /* file included showing modules headers as per selected modules.*/
  require_once("common_listing_headings.php");
  ?>  


<?if($_GET['msg'] != "") {?>
<tr>
	<td align="center" colspan="7" style="color:red;" ><?=$_GET['msg'];?></td>
</tr>
<? } ?>
<? if($modulearray[$module]['addlink'] != ""){ ?>
  <tr>
  
  <?php if($_GET['module'] == 'company') { ?>
 
  <td colspan="4"><input value="Add New Firm" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
  <td colspan="4"><a class="button" id="adv_search_a" onClick="show_id('adv_search'); $(this).hide();$('.searchAlph').hide();">Show Advanced Search</a></td>
  
  <?php } else if($_GET['module'] == 'broker')  { ?>
    <td colspan="8"><input value="Add New Broker" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
   <?php } else if($_GET['module'] == 'customer')  { ?>
    <td colspan="8"><input value="Add New Customer" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'owner')  { ?>
    <td colspan="8"><input value="Add New Owner" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'site_visit_report')  { ?>
    <td colspan="8"><input value="Add New Report" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'interaction_report')  { ?>
    <td colspan="8"><input value="Add New Property" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
    <?php } else if($_GET['module'] == 'property')  { ?>
    <td colspan="8"><a href="index.php?&rel=edit_property&customer_id=<?php echo $_GET['customer_id']; ?>"><input value="Add Requirement" name="addnew" id="addnew" type="button"></td>
    

<?php } else if($_GET['module'] == 'broker_property')  { ?>
    <td colspan="8"><a href="index.php?&rel=edit_property&customer_id=<?php echo $_GET['customer_id']; ?>"></td>
    

<?php } else if($module == 'call_log' || $module == 'other_call_log' )  { 
	if($_REQUEST['shortlist_id'] != '')
	{
		if(isset($_REQUEST['id_customer']))
			$cust_id = $_REQUEST['id_customer'];
		else
			$cust_id = $_REQUEST['id_bc'];
		$addlink = "index.php?rel=edit_call_log&customer_id=".$cust_id."&shortlist_id=".$_REQUEST['shortlist_id'];
	}
	else
	{
		$addlink = $modulearray[$module]['addlink'];
	}
	if( ($module == 'call_log' && ( isset($_REQUEST['id_bc'])|| isset($_REQUEST['shortlist_id']))) || $module == 'other_call_log' )
	{
?>
	<td colspan="8"><input value="Add New Call Log" name="addnew" id="addnew" onclick="javascript:window.location='<?php echo $addlink; ?>';"  type="button"></td>
    
  <?php } } else { ?>
    <td colspan="8"><input value="Add New" name="addnew" id="addnew" onclick="javascript:window.location='<?=$modulearray[$module]['addlink'];?>';"  type="button"></td>
  
  <?php } ?>
  </tr>
<? } ?>
  
  <tr>
	<td colspan="10">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>
	<select name="action" id="action">
	<option value="" >Bulk Actions</option>
        <? for($j=0,$nj=count($status_array);$j<$nj;$j++){ ?>
		<option value="<?=$status_array[$j];?>"><?=$status_array[$j];?></option>
	<? } ?>
	<option value="Delete">Delete</option>
	</select>&nbsp;
	<input value="Apply" name="doaction1" id="doaction1" onclick="return doaction();"   type="button">
	</td>
	
	<td align="right" >
		<input id="keyword" size="50" placeholder="Search for...." name="keyword" onkeypress="return checkcode(event);" value="<?=am_display($_GET['keyword']);?>" type="text">
		<input value="Search"  type="button" onclick="searchrec();" >
	</td>
	<?php 
	// file included for refine search
		include('refine_search.php');
	 ?>
	</tr>
	</table>
	</td>
  </tr>
  <?php if($_GET['keyword'] != '') { ?>
  <tr>
  	<th  colspan="5">Search Results for: <?php echo $_GET['keyword']; ?> </th>
  </tr>	
  <?php } ?>
  
  
  <tr>
    <th scope="col"  class="black11_bold"><div align='left'><input name='checkall' id='checkall' type='checkbox'></div></th>
    <?php
    
    //print_R($fieldarray);exit;
    
    for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
    {
    
        if($fieldarray[$i][5] == 'users_log' && isset($_REQUEST['id_bc']))
        	continue;
        	    
	if($fieldarray[$i][0] !=  $_GET['sort_option'])
	{
		$show_sort_image = "";
	}
	else
	{
		$show_sort_image = $sort_image;
	}
## showing the heading fields for listing data.
	if($fieldarray[$i][7] == "N")
	{
          echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='".$fieldarray[$i][2]."'>".$fieldarray[$i][1].$show_sort_image."</div></th>";
       }
       else
       {
          if($fieldarray[$i][6] =='listing_count')
          {
          	  echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='". $fieldarray[$i][2]."'><a href=\"".$sortlink."&sort_option=".$fieldarray[$i][6]."&sort=".$sort."\">".$fieldarray[$i][1]."</a>".$show_sort_image."</div></th>";
          }	
          else
          {
          	  echo "<th scope='col' width='".$fieldarray[$i][3]."%' class='black11_bold'><div align='". $fieldarray[$i][2]."'><a href=\"".$sortlink."&sort_option=".$fieldarray[$i][0]."&sort=".$sort."\">".$fieldarray[$i][1]."</a>".$show_sort_image."</div></th>";
          }
        
       }   
      
           
           
    }
    
    if($lastfield != '')
    {
     echo "<th scope='col' width='5%' class='black11_bold'><div align='left'>".$lastfield."</div></th>"; 
     }
    ?>

  </tr>
  <?php
    for($j=0,$nj=count($result_arr);$j<$nj;$j++)
    {    
        echo "<tr><td class='black11' width='5%' ><input id='chkme' name='chk[]' value='".$result_arr[$j][$primaryid]."' type='checkbox'></td>";
        for($i=0,$ni=count($fieldarray);$i<$ni;$i++)
        { 
	//	echo"<pre>"; print_r($fieldarray);
		 if($fieldarray[$i][5] == 'users_log' && isset($_REQUEST['id_bc']))
        		continue;
		if(trim($fieldarray[$i][5]) != "")
		{
			$val = call_user_func($fieldarray[$i][5] , $result_arr[$j][$fieldarray[$i][0]]);
			
			
		}
		else
		{
			//echo"<pre>";print_r($result_arr[$j]);echo"$j====".$fieldarray[$i][0]."<br>";
			$val = $result_arr[$j][$fieldarray[$i][0]];
		}
		
	          if($module=='company' && $fieldarray[$i][0] == company_id)
	          {
	          	 echo "<td class='black11' align='".$fieldarray[$i][2]."'></td>"; 
	          }
	          else
	          {
	            echo "<td class='black11' align='".$fieldarray[$i][2]."'>".$val."</td>"; 
	          } 

        }
        if($module == 'company' || $module == 'customer'  || $module == 'interaction_report' || $module == 'site_visit_report' )
        {    
		//echo"<pre>";print_r($result_arr);
        if($module == 'company')
        {
        	$arrFieldKey = 'company_id';
        }
        else if($module == 'customer')
        {
        	$arrFieldKey = 'client_id';
        }
        else
        {
        	$arrFieldKey = $primaryid;
        }	

        echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$arrFieldKey]."' >View / Edit</a>";
        }
        
        else if($module == 'property')
        {
        echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."&customer_id=".$_GET['customer_id']."' >View / Edit</a>";
        }
       else if( $module == 'owner_property' )
       {
       	echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."&owner_id=".$_GET['customer_id']."' >View / Edit</a>";
       } 
       else if($module == 'call_log')
	{
		if(isset($_REQUEST['id_bc']))
			echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >Edit</a>";
	}
	else if($module == 'log')
	{
		echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >View Detail</a>";
	}
   	else
	{
	echo "<td class='black11' nowrap width='5%' ><a href='".$editlink.$result_arr[$j][$primaryid]."' >Edit</a>";
	}
        echo "</td>";
        echo "</tr>"; 
    } 
    ?>
<? if(count($result_arr) == 0) {?>
<tr>
	<td align="center" colspan="7" height="70" style="color:red;" >No records found</td>
</tr>
<? } else {?>
<tr><td colspan="2" ><?=$total_pages.' Records';?></td><td colspan="5" align="right" ><?=$paginate;?></td></tr>

<tbody><tr><td class="navigation_separator"></td><td>
<!--<div class="save_edited hide">save_edited hide
<input type="submit" value="Save edited data"><div class="navigation_separator">|</div></div> --></td>
<td><div class="restore_column hide" style="display: none;"><input type="submit" value="Restore column order">
<div class="navigation_separator">|</div></div></td>
<td class="navigation_goto">
</td>
<td class="navigation_separator"></td></tr></tbody>
<? } ?>
</table>
</form>