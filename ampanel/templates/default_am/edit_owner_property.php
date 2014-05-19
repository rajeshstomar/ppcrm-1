<?php
//include("../dbconfig.php");
$msg = $_GET['msg'];

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

$build="select id_building,b_name,b_near_road,b_street_name,b_location_landmark,b_city,b_region_area from building_database";
$build_data = am_select($build);

//print_R($build_data);exit;
$build_array = array();

for($i=0;$i<count($build_data);$i++)
{
	
	$build_array[]='{'.'"label":"'.$build_data[$i]['b_name'].'","val":"'.$build_data[$i]['b_city'].'|'.$build_data[$i]['id_building'].'|'.$build_data[$i]['b_near_road'].'|'.$build_data[$i]['b_street_name'].'|'.$build_data[$i]['b_region_area'].'|'.$build_data[$i]['b_location_landmark'].'"'.'}';
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
		$("#add_line2").val(tmp1[2]); 
		$("#add_line1").val(tmp1[3]); 
		$("#add_line3").val(tmp1[4]);
    $("#landmark").val(tmp1[5]); 
		//$("#add_line2").val(tmp1[3]+','+tmp1[4]); 

		
	}
      
    });
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

<script type="text/javascript" src="<?php echo HTTP_ROOT_HOME; ?>js/jquery.validate.min.js"></script>	
<style>
.error
{
	border: 1px solid red !important;	
}
label.error
{
    border: medium none !important;
    color: red;
    position: relative;
    top: 3px;
}
</style>


<?php

$customer="select date,place,f_name,l_name,mobile_no,email1 from client_personal_details where client_id='".$_GET['owner_id']."'";
$customer_data = am_select($customer);

?>


<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2> <?php echo $mode; ?> Owner Property For: <?php print $customer_data[0]['f_name']." ".$customer_data[0]['l_name']; ?> </h2>
<form name="frm" method="post" id="register-form" action="index.php?rel=owner_property_action">
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
 
 <?php

	$lastid="SELECT MAX( broker_property_id) FROM property_requirement";
	$get_lastid=am_select($lastid);
	//print_R($get_lastid);exit;
	//echo $get_lastid[0]['MAX( broker_property_id)'];
	$id_last=$get_lastid[0]['MAX( broker_property_id)']+1;
	

?>
 
 
  <tr>
  <?php  $date=date('d/m/Y'); ?>
	    <td class="black11" style="width: 20%;">Date:</td>
	    <td class="black11" style="width: 15%;"><input type="text" name="date" id="date" value="<?php if($broker_data[0]['date'] !='' ) { print $broker_data[0]['date']; } else {  echo $date;  } ?>" />(DD/MM/YYYY)</td>
	
	    <td class="black11" style="width: 20%;">Form No:</td>
	    <td class="black11" style="width: 15%;"><input readonly type="text" name="form_no" id="form_no" value="<?php if($mode=='Add') { print 'OP'.$id_last; } else if($mode=='Update') { print 'OP'.$broker_data[0]['form_no']; } ?>" /></td>
  </tr>
   <tr>
	    <td class="black11" style="width: 20%;">Owner ID:</td>
	    <td class="black11" style="width: 15%;"><input type="text" name="bro_own_id" id="bro_own_id" value="<?php if($_GET['owner_id']!='') { echo $_GET['owner_id']; } else { print $broker_data[0]['broker_owner_id']; } ?>" /></td>

</tr>
<tr>	
	    <td class="black11" style="width: 20%;">Owner Mobile no:</td>
	    <td class="black11" style="width: 15%;"><input type="text" name="pan_mob_no" id="pan_mob_no" value="<?php if($customer_data[0]['mobile_no']!='') { echo $customer_data[0]['mobile_no']; } else { print $broker_data[0]['pan_or_mobile']; } ?>" /></td>
  </tr>
   
   
 
  
  <tr>
	    <th>Properties</th>
  </tr>
  
   <tr>
	    
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="residential") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="residential" value="residential" onclick="showhidediv();"></td>
	    <td class="black11">Residential</td>
	    	
	    
	    <td class="black11"><input <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  checked="checked" <?php } ?> type="radio" name="residential" id="commercial" value="commercial" onclick="showhidediv(this);"></td>
	     <td class="black11">Commercial</td>
	   
  </tr>
  
  </table>
  
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1" <?php if($client_data[0]['property_type']=="commercial") { ?>  style="display:none;" <?php } ?> >
   <tr>
	    <th class="black11">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='1') { ?>  checked <?php } ?>  type="radio" name="1rk" id="1rk" value="1">&nbsp;&nbsp;&nbsp;1RK </td>
	   		

<td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='2') { ?>  checked <?php } ?>  type="radio" name="1rk" id="1bhk" value="2">&nbsp;&nbsp;&nbsp;1BHK</td>
		

	  </tr>  
	  <tr>
	 <td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='3') { ?>  checked <?php } ?>  type="radio" name="1rk" id="2bhk" value="3">&nbsp;&nbsp;&nbsp;2BHK </td>
	    	
<td class="black11" style="width: 15%;"><input <?php if($broker_data[0]['onerk']=='4') { ?>  checked <?php } ?>  type="radio" name="1rk" id="3bhk" value="4">&nbsp;&nbsp;&nbsp;3BHK</td>
			

	  </tr>  
	  <tr>
	  
	 <td class="black11"><input <?php if($broker_data[0]['onerk']=='5') { ?>  checked <?php } ?>  type="radio" name="1rk" id="4bhk+" value="5">&nbsp;&nbsp;&nbsp;4BHK+</td>
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
	    	
	    	<select name="office_check" id="office_check" onchange="off_retfun(this);">
	    		<option value="">Select Type</option>
	    		<option value="1" <?php if($broker_data[0]['office']=='1') { ?> selected <?php } ?> >Office</option>
	    		<option value="2" <?php if($broker_data[0]['office']=='2') { ?> selected <?php } ?> >Retail</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
   <tr>
	    <td class="black11">Approximate Area (SQFT):</td>
	    <td class="black11">
	    	<input type="text" name="scaleble" id="scaleble" value="<?php print $broker_data[0]['scaleble']?>" />
	    </td>
    </tr>
     <tr id="furn">
	   
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='1') { ?>  checked <?php } ?>  type="radio" name="furnished" id="furnished" value="1"></td>
	      <td class="black11">Furnished</td>	
	    
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='2') { ?>  checked <?php } ?>  type="radio" name="furnished" id="unfurnished" value="2"></td>
	     <td class="black11">Unfurnished</td>
	
	    <td class="black11"><input <?php if($broker_data[0]['furnished']=='3') { ?>  checked <?php } ?>  type="radio" name="furnished" id="any" value="3"></td>
	     <td class="black11">Any</td>
	   
  </tr>
     <tr id="cell" style="width:110%;" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	   
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='1') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="warm_cell" value="1"></td>
	     <td class="black11" title="Flooring & Wall finish available, Toilets are available">Warm Cell ?</td>
	    	
	    
	    <td class="black11"><input <?php if($broker_data[0]['warm_cell']=='2') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="cold_cell" value="2"></td>
	     <td class="black11" title="flooring, wall finish etc not yet finished">Cold Cell ?</td>
	    
	   
  </tr>
  
  
  <tr>
	    <td class="black11" >Transaction:</td>
	    
	     <td class="black11" >
	     <select name="transaction" id="transaction" value=""  onchange="transaction1(this);">
	        <option value="">Select</option>
	     	<!--<option value="sale" <?php if($broker_data[0]['trans_type']=='sale') { ?> selected <?php } ?> >Sale</option>-->
	     	<option value="sell" <?php if($broker_data[0]['trans_type']=='sell') { ?> selected <?php } ?> >Sell</option>
	     	<option value="rent_out" <?php if($broker_data[0]['trans_type']=='rent_out') { ?> selected <?php } ?> >Rent Out</option>
	     <!--	<option value="rent_out" <?php if($broker_data[0]['trans_type']=='rent_out') { ?> selected <?php } ?> >Rent Out</option>  -->
	     </select>
	     </td>
	    
  </tr>
 <?php   $price=$broker_data[0]['price'];
 	       
 	     
 	     if(strpos($price, '0000000'))
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
 	      
 	       // echo $c1;
 	        $price1=str_replace($c1,'' ,$price);
 	        if($price1>100)
		{
	 	      	$value1=($price1/100);
			$value1=explode(".",$value1);
		
			//print_R($value1);exit;
		
			$value2=($price1%100);
		}	      
 	        else 
 	        {
 	          if($c1==='0000000' && $broker_data[0]['trans_type']=='sell' )
 	          { 	
 	        	if($c1==='0000000')
 	        	{
 	        		$value1[0]=$price1;
 	        	}
 	        	else if($c1==='00000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	          else if($c1==='00000' && $broker_data[0]['trans_type']=='sell' )
 	          {
 	          	if($c1==='00000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	           
 	          else if($c1==='00000' && $broker_data[0]['trans_type']=='rent_out')
 	          { 	
 	        	if($c1==='00000')
 	        	{
 	        		$value1[0]=$price1;
 	        	}
 	        	else if($c1==='000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	          else if($c1==='000' && $broker_data[0]['trans_type']=='rent_out')
 	          { 	
 	        	if($c1==='000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	        	
 	        	
 	        	
 	        }
 	      
 	       
 	 ?>
 	 
 	 
  <tr>	
  		<?php if($mode=='Add') { ?>
  		
		    <td class="black11" id="price_exp" >Expected Price (All Inclusive):</td>
		    <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    	 <?php } else if($mode=='Update') { ?>
	    	 
	    	 	<?php if($broker_data[0]['trans_type']=='sell') { ?>
	    	  		<td class="black11" id="price_exp" >Expected Price (All Inclusive):</td>
	    	  		  <td class="black11" id="price_rent" style="display:none;">Expected Rent Per Month:</td>
	    	  	<?php } else if($broker_data[0]['trans_type']=='rent_out') { ?>
	    	  		<td class="black11" id="price_exp" style="display:none;">Expected Price:</td>
	    	  		<td class="black11" id="price_rent" >Expected Rent Per Month:</td>
	    	 <?php } } ?>
</tr>
<tr>	
	    
	    <td class="black11"><input type="text" name="price1" id="price1" value="<?php print $value1[0]; ?>" /></td>
	     <td class="black11" >
	     <select name="price_type1" id="price_type1" value="">
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($c1 === "0000000") { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     </td>
	</tr>
	<tr>     
	     <td class="black11"><input type="text" name="price2" id="price2" value="<?php print $value2; ?>" /></td>
	     <td class="black11" >
	     <select name="price_type2" id="price_type2" value="">
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($c1 === "0000000") { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     </td>
	    
  </tr>
   
     
     <input type="hidden" name="user_type" id="user_type" value="owner" />
     <input type="hidden" name="type_owner" id="type_owner" value="owner" />
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
    <td class="black11"><input type="text" name="nearest_building" id="nearest_building" value="<?php print $broker_data[0]['b_name']?>" /><input type="hidden" name="near_buil_id" id="near_buil_id" value="<?php print $broker_data[0]['near_building_id']?>" /></td>
    
  </tr>
  
   <tr>
	    <td class="black11" >Building Name / Flat No/ Floor</td>
	    <td class="black11"><input type="text" name="floor1" id="floor" value="<?php print $broker_data[0]['floor']?>" /></td>
	     
  </tr>
    <tr>
	    <td class="black11" >Region / Area</td>
	    <td class="black11"><input type="text" name="add_line3" id="add_line3" value="<?php print $broker_data[0]['add_line3']?>" /></td>
	     
  </tr>
    <tr>
	    <td class="black11" >Nearest Road</td>
	    <td class="black11"><input type="text" name="add_line2" id="add_line2" value="<?php print $broker_data[0]['add_line2']?>" /></td>
	     
  </tr>
  
   <tr>
	    <td class="black11" >Street Name</td>
	    <td class="black11"><input type="text" name="add_line1" id="add_line1" value="<?php print $broker_data[0]['add_line1']?>" /></td>
	     
  </tr>
     <tr>
	    <td class="black11" >Location Landmark</td>
	    <td class="black11"><input type="text" name="landmark" id="landmark" value="<?php print $broker_data[0]['landmark']?>" /></td>
	     
  </tr>
   <tr>
	     <td class="black11" >City Name</td>
	    <td class="black11"><input type="text" name="city" id="city" value="<?php print $broker_data[0]['city']?>" /></td>
	     
  </tr>
   <tr>
	    <td class="black11" >Pin Code</td>
	    <td class="black11"><input type="text" name="zip_code" id="zip_code" value="<?php print $broker_data[0]['zip_code']?>" /></td>
	    
  </tr>
   <tr>
	    <td class="black11" >State</td>
	    <td class="black11">
	    	 <select name="state"  id="state"  value="">
		    	<option value="">Select State</option>
		    	<?php echo get_states_options($broker_data[0]['state_id']); ?>
		 </select>
	    </td>
	     
  </tr>
  
  <tr>
	    <td class="black11" >Country</td>
	    <td class="black11"><input type="text" name="country" id="country" value="India" /></td>
	     
  </tr>
 
 
  <tr>
	    <td class="black11" colspan="1">Note:</td>
	    <td class="black11" colspan="3">Persius officiis eloquentiam ut sed,ius nostrud sensibus ea. Eu ullum inani posidonium quo,zzril quaestio intellegat in quo.</td>
	    
  </tr>
  
     
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit1" value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />-->
    <div class="loading" id="loading"></div>
    </td>
  </tr>
</table>
</form>

<script type="text/javascript">
/*function validate()
{
	if(document.getElementById('page_title').value == "")
	{
		alert("Please enter page title");
		document.getElementById('page_title').focus();
		return false;
	}
	return true;
}*/
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
		
		
		document.getElementById('price_type1').innerHTML = '<option value="">Select</option><option value="crores" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Crore</option>';
		document.getElementById('price_type2').innerHTML = '<option value="">Select</option><option value="laks" <?php if($c1 === '00000') { ?> selected <?php } ?> >Lac</option>';
		
	
	}
	else if(document.getElementById('transaction').value=='rent_out')
	{
		
		document.getElementById('price_exp').style.display = 'none';
		document.getElementById('price_rent').style.display = 'block';
		
		
		document.getElementById('price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c1 === '000') { ?> selected <?php } ?> >Thousand</option>';
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


<script type="text/javascript">
/**
  * Basic jQuery Validation Form Demo Code
  * Copyright Sam Deering 2012
  * Licence: http://www.jquery4u.com/license/
  */
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    transaction_type: "required",
                    residential: "required",
                   
                    scaleble: {
                        required: true,
                        number: true
                        
                    },
                     furnished: "required",
                     transaction: "required",
                     warm_cell: "required",
                     
                     
                    price1: {
                        required: true,
                        number: true
                        
                    },
                   price_type1: "required",
                    
                     price2: {
                        required: true,
                        number: true
                        
                    },
                    price_type2: "required",
                    nearest_building: "required",
                    floor1:"required",
                   /* add_line1:"required",
                    add_line2:"required",
                    add_line3:"required", */
                    city:"required",
                   
                   zip_code: {
                        required: true,
                        number: true
                        
                    },
                    state: "required",
                    
                    
                    
                    
                },
                messages: {
                    transaction_type: "Please Select  Transaction Type",
                    residential: "Please Select Property Type",
                  
                    scaleble: {
                        required: "Please enter Approximate Area",
                        number: "Please enter Approximate Area Numeric",
                       
                    },
                    furnished:"Please Select Furniture Type",
                    transaction:"Please Select Office/Retail",
                     warm_cell:"Please Select Cell",
                   
                   min_price1: {
                        required: "Please enter  Price ",
                        number: "Please enter  Price Numeric",
                       
                    }, 	
                    
                   price_type1: "Please Select  Price Type",
                    
                    price2: {
                        required: "Please enter  Price ",
                        number: "Please enter  Price Numeric",
                       
                    }, 	
                    
                     price_type2: "Please Select  Price Type",
                     
                     nearest_building: "Please enter  Nearest Building", 
                     floor1: "Please enter  Building Name / Flat No/ Floor",
                    /* add_line1:"Please enter  Address 1",
                     add_line2:"Please enter  Address 2",
                     add_line3:"Please enter  Address 3", */
                     city:"Please enter  City",
                     zip_code: {
                        required: "Please enter Pin Code ",
                        number: "Please enter Pin Code Numeric",
                      }, 
                      state:"Please Select  State",	
                      
                     
                    
                },
                submitHandler: function(form) {
                	$("#loading").html('<img src="images/loader.gif">');
			var str = $("#register-form").serialize();  
			$.ajax({
		
				type: "POST",
				url: "check_property.php?"+str,
				success: function(html){
					if(html.trim() == '1')
					{
						$("#loading").html('<fornt style="color:red">Property already exist..</font>'); return false;
					}
					else if(html.trim() == '0')
					{
						form.submit();
					}
				}
		    	});
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
