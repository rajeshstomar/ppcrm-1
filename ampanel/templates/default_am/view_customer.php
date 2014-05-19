<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];


if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from client_personal_details left join states on client_personal_details.state=states.StateID  where client_id= '".$id."' ";
	$client_data = am_select($sel_que);
	//my_print_R($client_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 
?>

<script>
$(function() {
$( "#date" ).datepicker({
dateFormat: 'yy-mm-dd',
});
});
</script>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2>View Customer For: <?php print $client_data[0]['f_name'].' '.$client_data[0]['l_name']; ?> </h2>
<form name="frm" method="post" action="index.php?rel=customer_action" >

	
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
  <?php  //$date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11"><?php  print $client_data[0]['client_updated_date'];  ?></td>
	
	    <td class="black11">Outlet Location:</td>
	    <td class="black11"><?php print $client_data[0]['place']?></td>
  </tr>
   <!--<tr>
	    <td class="black11"><input type="radio" name="sell" id="sell"  value="Sell/Rent Out" onclick="showhidediv();"></td>
	    <td class="black11">Sell/Rent Out</td>
	
	    <td class="black11"><input type="radio" name="sell" value="Buy/Rent In" onclick="showhidediv(this);"></td>
	    <td class="black11">Buy/Rent In</td>
  </tr>-->
   <tr>
	    <th>Personal Details</th>
  </tr>
  <tr>
	    <td class="black11" >First Name</td>
	    <td class="black11"><?php print $client_data[0]['f_name']?></td>
	     <td class="black11" >Last Name</td>
	    <td class="black11"><?php print $client_data[0]['l_name']?></td>
  </tr>
  
  
  <tr>
	    <th>Address</th>
  </tr>
  
  
   <tr>
	    <td class="black11" >Address line 1</td>
	    <td class="black11"><?php print $client_data[0]['add_line1']?></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 2</td>
	    <td class="black11"><?php print $client_data[0]['add_line2']?></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Address line 3</td>
	    <td class="black11"><?php print $client_data[0]['add_line3']?></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><?php print $client_data[0]['zip_code']?></td>
	     <td class="black11" >City Name</td>
	    <td class="black11"><?php print $client_data[0]['city']?></td>
  </tr>
  <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	<?php echo $client_data[0]['StateName']; ?>
	    </td>
	     
  </tr>
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><?php echo "India"; ?></td>
	     
  </tr>
  
   
  
    <tr>
	    <th>Contact</th>
  </tr>
  
     <tr>
	    <td class="black11" >Mobile</td>
	    <td class="black11"><?php print $client_data[0]['mobile_no']?></td>
	     <td class="black11" >Phone</td>
	    <td class="black11"><?php print $client_data[0]['office_no']?></td>
  </tr>
     <tr>
	    <td class="black11" >Email1</td>
	    <td class="black11"><?php print $client_data[0]['email1']?></td>
	     <td class="black11" >Email2</td>
	    <td class="black11"><?php print $client_data[0]['email2']?></td>
  </tr>
 
<tr>
    	
	    <th colspan="4">Lead source</th>
    </tr>
     <tr>
	    
	    <td class="black11" colspan="2"><?php  if($client_data[0]['internet']=='1') { ?>  Internet/web <?php } ?>  </td>
	    
	    <td class="black11" colspan="2"><?php  if($client_data[0]['internet']=='2') { ?>  Newspaper Advertise <?php } ?> </td>
	</tr>
	<tr>	    
	    <td class="black11" colspan="2"><?php  if($client_data[0]['internet']=='3') { ?>  Friends/Relatives <?php } ?> </td>
	     
	     <td class="black11" colspan="2"><?php  if($client_data[0]['internet']=='4') { ?>  Other <?php } ?> </td>
  </tr>


    <tr>
    	
	    <th colspan="4">Check Below Check box For Notification Via Multiple Options.</th>
    </tr>
     <tr>
	    
	    <td class="black11"><?php  if($client_data[0]['calls_noti']=='1') { ?>  Calls <?php } ?> </td>
	    
	</tr>
	<tr>	    
	    
	    <td class="black11"><?php  if($client_data[0]['sms_noti']=='1') { ?>  SMS's <?php } ?></td>
	    
  </tr>
  <tr>	    
	    
	    <td class="black11"><?php  if($client_data[0]['email_noti']=='1') { ?>  Email's <?php } ?> </td>
	    
  </tr>
  
  <!--<tr>
  	<td class="black11" colspan="4">Terms and conditions agreed</td>
  </tr>
   <tr>	    
	    
	    
	    <td class="black11">Yes</td>
	    <td class="black11"><input <?php if($client_data[0]['term_agree']=='1') { ?>  checked <?php } ?>  type="radio" name="term_con" id="term_con" value="1"></td>
	    	
	     <td class="black11">No</td>
	    <td class="black11"><input <?php if($client_data[0]['term_agree']=='2') { ?>  checked <?php } ?>  type="radio" name="term_con" id="term_con" value="2"></td>
  </tr>	-->
  
  <tr>
	    <td class="black11">Transaction Time</td>
	    <td class="black11">
	    	<?php print $client_data[0]['trans_time']?>
	    	
	    
	    </td>
	    	
	   
	   
  </tr>
  
  <tr>
	    <td class="black11">Client Category</td>
	    <td class="black11">
	    	<?php print $client_data[0]['client_cat']?>
	    	
	    
	    </td>
	    	
	   
	   
  </tr>
  <tr>
       <td class="black11">Customer Form: </td>
    
    <td class="black11">
    <?if( $client_data[0]['cust_form'] != "")
    { 
    	 $jpg_pdf=explode(".",$client_data[0]['cust_form']);
    	// print_R($jpg_pdf);exit;
    	 
    	 if($jpg_pdf[1]=='pdf' || $jpg_pdf[1]=='PDF' )
    	 {
    ?>
    <a href="<?php echo HTTP_ROOT_HOME.'/customer_images/'.$client_data[0]['cust_form'];?>" width="50px" height="50px;">View</a>
    
    <?php } else { ?>
    
     
      <img src="<?php echo HTTP_ROOT_HOME.'/customer_images/'.$client_data[0]['cust_form'];?>" width="100px" height="80px;">
   <?php
   	}
    }  ?>	
    	</td>
    
	
  </tr>
    <tr>	    
	    
	    <td class="black11">Client Remark</td>
	    <td class="black11" colspan="3">
	    
	    <?php print $client_data[0]['remark']?>
	 
	    </td>
  </tr>
  
  <tr>	    
	    
	    <td class="black11">Executive Name</td>
	    <td class="black11" colspan="3">
	    
	    <?php echo am_get_executive_name($client_data[0]['executive_id']); ?>
	 
	    </td>
  </tr>
  
  <tr>	    
	    
	    <td class="black11">Executive Remark</td>
	    <td class="black11" colspan="3">
	    
	    <?php print $client_data[0]['executive_remark']?>
	 
	    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="black11" colspan="3"><a href="index.php?rel=edit_customer&id=<?php echo $client_data[0]['client_id']?>"><input type="button" name="submit" onclick="return validate();" value="<?=$mode;?> Customer" /></a>&nbsp;<a href="index.php?rel=edit_property&customer_id=<?php echo $client_data[0]['client_id']?>"><input type="button" name="addproperty"  value="Add Property" /></a>&nbsp;<input type="button" name="call_log" onclick="javascript:window.location='index.php?rel=common_listing&module=call_log&id=<?php echo $client_data[0]['client_id']?>&user_is=customer';" value="Call Log" /><!--<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
  </tr>
</table>
</form>

<script type="text/javascript">
function validate()
{
	if(document.getElementById('page_title').value == "")
	{
		alert("Please enter page title");
		document.getElementById('page_title').focus();
		return false;
	}
	return true;
}
</script>
