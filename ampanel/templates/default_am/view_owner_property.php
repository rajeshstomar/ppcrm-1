<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];
if($_REQUEST['shortlist_id'] !="")
{
	$sql = "SELECT * FROM short_listed_prop WHERE id_shortlist=".$_REQUEST['shortlist_id'];
	$short_data = am_select($sql);
}
if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from property_requirement left join building_database on property_requirement.near_building_id=building_database.id_building where broker_property_id= '".$id."' ";
	$broker_data = am_select($sel_que);
	//my_print_R($broker_data);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
	
	
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ; 

$build="select id_building,b_name,b_near_road,b_street_name,b_location_landmark,b_city from building_database";
$build_data = am_select($build);

//print_R($build_data);exit;
$build_array = array();

for($i=0;$i<count($build_data);$i++)
{
	
	$build_array[]='{'.'"label":"'.$build_data[$i]['b_name'].'","val":"'.$build_data[$i]['b_city'].'|'.$build_data[$i]['id_building'].'|'.$build_data[$i]['b_near_road'].'|'.$build_data[$i]['b_street_name'].'|'.$build_data[$i]['b_location_landmark'].'"'.'}';
}

 $cnt = '['.implode(',',$build_array).']';

//echo $cnt;exit;

?>




<link rel="stylesheet" href="<?php echo HTTP_ROOT_HOME; ?>css/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="<?php echo HTTP_ROOT_HOME; ?>js/jquery-ui.js"></script>
  
 
  
  <script>
  $(function() {
    var availableTags = <?php echo $cnt; ?>;
    $( "#nearest_building" ).autocomplete({
      source: availableTags,
      
      select: function(event, ui) {
                var selectedObj = ui.item;
		var tmp1 = selectedObj.val.split("|");
		$("#city").val(tmp1[0]); 
		$("#near_buil_id").val(tmp1[1]); 
		$("#add_line3").val(tmp1[2]); 
		$("#add_line1").val(tmp1[3]); 
		$("#add_line2").val(tmp1[4]); 
		//$("#add_line2").val(tmp1[3]+','+tmp1[4]); 

		
	}
      
    });
  });
  </script>
<script language="JavaScript" type="text/javascript">
function showhidediv(){

	if (document.getElementById('residential').checked)
	{
	document.getElementById('apartment1').style.display = 'block';
	document.getElementById('furn').style.display = 'block';
	document.getElementById('cell').style.display = 'none';
	}
	else
	{
	document.getElementById('apartment1').style.display = 'none';
	}
	
	if (document.getElementById('commercial').checked)
	{
	document.getElementById('off_ret').style.display = 'block';
	document.getElementById('cell').style.display = 'none';
	document.getElementById('furn').style.display = 'none';
	}
	else
	{
	document.getElementById('off_ret').style.display = 'none';
	}
	


}

function off_retfun(){

	
	if (document.getElementById('office_check').value=='1')
	{
		document.getElementById('furn').style.display = 'block';
		document.getElementById('cell').style.display = 'none';
	
	}
	else if(document.getElementById('office_check').value=='2')
	{
		
		document.getElementById('furn').style.display = 'none';
		document.getElementById('cell').style.display = 'block';
	}
	


}


function transaction1(){

	
	
	if (document.getElementById('transaction').value=='sell')
	{
		document.getElementById('price_exp').style.display = 'block';
		document.getElementById('price_rent').style.display = 'none';
	
	}
	else if(document.getElementById('transaction').value=='rent_out')
	{
		
		document.getElementById('price_exp').style.display = 'none';
		document.getElementById('price_rent').style.display = 'block';
	}
	


}
$(document).ready(function(){
	
	/*var office_retail = $('#office_check').val();
	var is_office = (office_retail == '1' || office_retail == '2') ? 1 : 0;
	//alert(is_office);
	if(is_office == '1')
	{
		$('#off_ret').show();
		$('#cell').hide();
		$('#furn').hide();
		$('#apartment1').hide();
	}
	else
	{
		$('#apartment1').show();
		$('#furn').show();
		$('#off_ret').hide();
		$('#cell').hide();
	}*/
	showhidediv();
	off_retfun();
	transaction1();
}); 

</script>


<script>
$(function() {
$( "#date" ).datepicker({
dateFormat: 'dd/mm/yy',
showOn: "button",
buttonImage: "images/calendar.gif",
buttonImageOnly: true,
});
});
</script>


<?php

$customer="select date,place,f_name,l_name,mobile_no,email1 from client_personal_details where client_id='".$_GET['owner_id']."'";
$customer_data = am_select($customer);

?>


<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2> View Owner Property For: <?php print $customer_data[0]['f_name']." ".$customer_data[0]['l_name']; ?> </h2>
<form name="frm" method="post" action="index.php?rel=owner_property_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="broker_property_id" value="<?php print $broker_data[0]['broker_property_id']?>" />
<input type="hidden" name="broker_owner_id" value="<?php print $broker_data[0]['broker_owner_id'] ?>" />
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
 
 
 <tr><h3>Owner Details </h3></tr>
 
 <tr>
  
  <?php  $date=date('d/m/Y'); ?>
	    <td class="black11">Date:</td>
	    <td class="black11" ><label  id="date2" ><?php print $customer_data[0]['date']?> </label> </td>
	
	    <td class="black11">Outlet Location:</td>
	    <td class="black11"> <label for="place" id="place" > <?php print $customer_data[0]['place']?></label> </td>
  </tr>
  
   
  <tr>
	    <td class="black11" >First Name</td>
	    <td class="black11"><label for="f_name" id="f_name" ><?php print $customer_data[0]['f_name']?> </label> </td>
	     <td class="black11" >Last Name</td>
	    <td class="black11"><label for="l_name" id="l_name" ><?php print $customer_data[0]['l_name']?> </label></td>
  </tr>
  
  
  
  
     <tr>
	    <td class="black11" >Mobile</td>
	    <td class="black11"> <label for="mobile" id="mobile"><?php print $customer_data[0]['mobile_no']?></label></td>
	    
	    <td class="black11" >Email1</td>
	    <td class="black11"> <label for="email1" id="email1" ><?php print $customer_data[0]['email1']?></label> </td>
	    
  </tr>

   <tr>
  <?php  $date=date('d/m/Y'); ?>
	    <td class="black11" style="width: 20%;">Date:</td>
	    <td class="black11" style="width: 15%;"><?php echo $broker_data[0]['date'] ?></td>
	
	   
  </tr>
   <tr>
	    <td class="black11" style="width: 20%;">Owner ID:</td>
	    <td class="black11" style="width: 15%;"><?php echo $broker_data[0]['broker_owner_id']; ?></td>
	
	    <td class="black11" style="width: 20%;">Owner Mobile no:</td>
	    <td class="black11" style="width: 15%;"><?php echo $customer_data[0]['mobile_no']; ?></td>
  </tr>
   
   
 
  
  <tr>
	    <th>Properties</th>
  </tr>
  
   <tr>
	    <td class="black11"> Property Type </td>
	    <td class="black11">
	  
	    <?php if($broker_data[0]['property_main_type']=="residential") { ?>
	    	  <label onclick="showhidediv();">Residential  </label>
	    <?php } else if($broker_data[0]['property_main_type']=="commercial") { ?>
	    	 <label onclick="showhidediv(this);">Commercial </label>
	    <?php }  ?>
	    </td>
	   
  </tr>
  
  </table>
  
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1" <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  style="display:none;" <?php } ?> >
   <tr>
	    <th class="black11">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 15%;" > <?php if($broker_data[0]['onerk']=='1') { ?>  1RK <?php } ?>  </td>
	   		

<td class="black11" style="width: 15%;"> <?php if($broker_data[0]['onerk']=='2') { ?>  1BHK <?php } ?></td>
		

	  </tr>  
	  <tr>
	 <td class="black11" style="width: 15%;"><?php if($broker_data[0]['onerk']=='3') { ?>  2BHK <?php } ?></td>
	    	
<td class="black11" style="width: 15%;"><?php if($broker_data[0]['onerk']=='4') { ?>  3BHK <?php } ?> </td>
			

	  </tr>  
	  <tr>
	  
	 <td class="black11"><?php if($broker_data[0]['onerk']=='5') { ?>  4BHK+ <?php } ?></td>
	    <td class="black11"></td>		
	  </tr>  
	   
   </table>
  
  <table  width="80%" border="0" cellspacing="2" cellpadding="2" >
    
      
     <!-- <tr>
	    <td class="black11">Specify Area:</td>
	    <td class="black11">
	    	<input type="text" name="specify_area" id="specify_area" value="<?php print $broker_data[0]['specify_area']?>" />
	    </td>
    </tr>-->
    
   <!--<tr>
	    <td class="black11">Carpet:</td>
	    <td class="black11">
	    	<input type="text" name="carpet" id="carpet" value="<?php print $broker_data[0]['carpet']?>" />
	    </td>
    </tr>-->
  
  
  <tr id="off_ret" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?> >
	    <td class="black11">Office/Retail</td>
	    <td class="black11">
	    	
	     <?php if($broker_data[0]['office']=='1') { ?> Office <?php } ?>
	     <?php if($broker_data[0]['office']=='2') { ?> Retail <?php } ?> 
	    
	    </td>
	    	
	   
	   
  </tr>
   <tr>
	    <td class="black11">Approximate Area (SQFT):</td>
	    <td class="black11">
	    	<?php print $broker_data[0]['scaleble']?>
	    </td>
    </tr>
     <tr id="furn" <?php if($broker_data[0]['office']=='2') { ?> style="display:none;" <?php } ?> >
	  
	    <td class="black11"> <?php if($broker_data[0]['furnished']=='1') { ?>  Furnished <?php } ?> </td>
	    <td class="black11"><?php if($broker_data[0]['furnished']=='2') { ?>  Unfurnished <?php } ?> </td>
	    <td class="black11"> <?php if($broker_data[0]['furnished']=='3') { ?>  Any <?php } ?>  </td>
	   
  </tr>
     <tr id="cell" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?> <?php if($broker_data[0]['office']=='1') { ?> style="display:none;" <?php } ?> >
	
	    <td class="black11"> <?php if($broker_data[0]['warm_cell']=='1') { ?>  Warm Cell <?php } ?> </td>
	    	
	    
	    <td class="black11"> <?php if($broker_data[0]['warm_cell']=='2') { ?>  Cold Cell <?php } ?> </td>
	   
  </tr>
  
  
  <tr>
	    <td class="black11" >Transaction:</td>
	    
	     <td class="black11" >
	     <?php if($broker_data[0]['trans_type']=='sell') { ?>Sell<?php } ?>
	      <?php if($broker_data[0]['trans_type']=='rent_out') { ?>Rent Out<?php } ?>
	   
	     </td>
	    
  </tr>
 <?php   $price=$broker_data[0]['price'];
 	       
 	     
 	       
 	      /* if(strpos($price, '0000000'))
 	       {
 	       		$c1='0000000';
 	       }
 	       else if(strpos($price, '00000'))
 	       {
 	       		$c1='00000';
 	       }
 	       else if(strpos($price, '000'))
 	       {
 	       		$c1='000';
 	       }
 	       	//$c9='0000000';
 	     	//echo $c1;exit;
 	       $price1=str_replace($c1,'' ,$price);
 	      // echo $c1;exit;*/
 	      
 	       
 	 ?>
 	 
 	 
  <tr>	
  		<?php if($mode=='Add') { ?>
  		
		    <td class="black11" id="price_exp" >Expected Price:</td>
		    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    	 <?php } else if($mode=='Update') { ?>
	    	 
	    	 	<?php if($broker_data[0]['trans_type']=='sell') { ?>
	    	  		<td class="black11" id="price_exp" >Expected Price:</td>
	    	  		  <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    	  	<?php } else if($broker_data[0]['trans_type']=='rent_out') { ?>
	    	  		<td class="black11" id="price_exp" style="display:none;">Expected Price:</td>
	    	  		<td class="black11" id="price_rent" >Expected Rent Per Month:</td>
	    	 <?php } } ?>
	    
	    <td class="black11"><?php print $price; ?></td>
	    
	    
  </tr>
   
     
     
    <!-- <tr>
	    <td class="black11" >Type:</td>
	   	     <td class="black11" >
	     <select name="type_owner" id="type_owner" value="">
	     	<option value="">Select</option>
	     	<!--<option value="owner" <?php if($broker_data[0]['type']=='owner') { ?> selected <?php } ?>>Owner</option>
	     	<option value="brokerdirect" <?php if($broker_data[0]['type']=='brokerdirect') { ?> selected <?php } ?> >Broker-direct</option>
	     	<option value="indirect" <?php if($broker_data[0]['type']=='indirect') { ?> selected <?php } ?> >Broker-Indirect</option>
	    
	     </select>
	     </td>
	    
  </tr>-->
  
  
    <tr>
	    <th>Address</th>
  </tr>
  
  <tr>
    <td class="black11">Nearest Building:</td>
    <td class="black11"><?php print $broker_data[0]['b_name']?></td>
    
  </tr>
  
   <tr>
	    <td class="black11" >Building Name / Flat No/ Floor</td>
	    <td class="black11"><?php print $broker_data[0]['floor']?></td>
	     
  </tr>
  
   <tr>
	    <td class="black11" >Region / Area</td>
	    <td class="black11"><?php print $broker_data[0]['add_line3']?></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Nearest Road</td>
	    <td class="black11"><?php print $broker_data[0]['add_line2']?></td>
	     
  </tr>
  <tr>
	    <td class="black11" >Street Name</td>
	    <td class="black11"><?php print $broker_data[0]['add_line1']?></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Location Landmark</td>
	    <td class="black11"><?php print $broker_data[0]['landmark']?></td>
	     
  </tr>
   <tr>
	     <td class="black11" >City Name</td>
	    <td class="black11"><?php print $broker_data[0]['city']?></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><?php print $broker_data[0]['zip_code']?></td>
	    
  </tr>
   <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	
		    	
		    	<?php echo get_states_name($broker_data[0]['state_id']); ?>
		
	    </td>
	     
  </tr>
  
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11">India</td>
	     
  </tr>
 
 
  <tr>
	    <td class="black11" colspan="1">Note:</td>
	    <td class="black11" colspan="3">Persius officiis eloquentiam ut sed,ius nostrud sensibus ea. Eu ullum inani posidonium quo,zzril quaestio intellegat in quo.</td>
	    
  </tr>
  
     
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><a href="index.php?rel=edit_owner_property&id=<?php print $broker_data[0]['broker_property_id']?>&owner_id=<?php print $broker_data[0]['broker_owner_id'] ?>"><input type="button" name="submit" onclick="return validate();" value="Edit Property" /></a>&nbsp;&nbsp;<input value="Call Log" name="call_log" id="call_log" onclick="javascript:window.open('index.php?rel=common_listing&module=call_log&id_customer=<?php print $short_data[0]['customer_id'];?>&shortlist_id=<?php echo $short_data[0]['id_shortlist'];?>','_blank');" type="button"><!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
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


