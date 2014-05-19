<?php
//include("../dbconfig.php");


$msg = $_GET['msg'];

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
	$id = $_REQUEST['id'];
	
	$sel_que ="select * from client_property  where property_id= '".$id."' ";
	$sel_que1 ="select area_name from client_area  left join client_property  on client_area.property_area_id=client_property.property_id where property_id= '".$id."' ";
	$client_data = am_select($sel_que);
	$client_area = am_select($sel_que1);
	
	
	
	
	
	//print_R($client_data);exit;
	//my_print_R($client_area);exit;
	$mode = "Update";
}
else
{
	$mode = "Add";
}
//include(DIR_SCRIPT_ROOT."/fckeditor/fckeditor.php") ;

if(isset($_GET['customer_id']) && is_numeric($_GET['customer_id'])) 
{
   $name_que ="select f_name,l_name from client_personal_details  where client_id= '".$_GET['customer_id']."' ";
	$client_name = am_select($name_que);
	
	//print_R($client_name);exit;
}





$build1="select b_region_area  from building_database";
$build_data1 = am_select($build1);

$build_array1 = array();

for($i=0;$i<count($build_data1);$i++)
{
	
	
	$build_array1[]=$build_data1[$i]['b_region_area'];
}

$cnt1 = '["'.implode('","',$build_array1).'"]';

?>





<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="<?php echo HTTP_ROOT_HOME; ?>js/jquery-ui.js"></script>

<script>
  $(function() {
    var availableTags = <?php echo $cnt1 ?>; 
    $( "#area1" ).autocomplete({
      source: availableTags,
      
      
    });
     $( "#area2" ).autocomplete({
      source: availableTags,
      
      
    });
     $( "#area3" ).autocomplete({
      source: availableTags,
      
      
    });
    $( "#area4" ).autocomplete({
      source: availableTags,
      
      
    });
  });
  </script>


<script>
$(function() {
$( "#date" ).datepicker({
dateFormat: 'dd/mm/yy',
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

<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>

<h2> <?php echo $mode; ?> Property For this Customer : <?php echo $client_name[0]['f_name']." ".$client_name[0]['l_name']; ?> </h2>
<form name="frm" method="post" id="register-form" action="index.php?rel=property_action" onsubmit="return validate()">
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">

<?php if($mode=='Add') { ?>
<input type="hidden" name="customer_id" value="<?php print $_GET['customer_id']; ?>" />
<?php } else if($mode=='Update') { ?>
<input type="hidden" name="customer_id" value="<?php print $client_data[0]['client_property_id']; ?>" />
<?php } else { ?>
<input type="hidden" name="customer_id" value="<?php print $client_data[0]['client_property_id']; ?>" />
<?php } ?>
<input type="hidden" name="property_id" value="<?php print $client_data[0]['property_id']; ?>" />
<input type="hidden" name="area_id" value="<?php print $client_data[0]['area_id']; ?>" />

	
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  
  
  <tr>
	    <th colspan="2">Property Looking For</th>
  </tr>
  
  <tr>
	    <td class="black11" style="width: 18%;">Transaction Type</td>
	    <td class="black11">
	    	<select name="transaction_type" id="transaction_type" value="" onchange="transaction1(this);">
	    		<option value="">Select Transaction</option>
	    		<option value="buy" <?php if($client_data[0]['main_property_type']=='buy') { ?> selected <?php } ?> >Buy</option>
	    		<!--<option value="sale" <?php if($client_data[0]['main_property_type']=='sale') { ?> selected <?php } ?>>Sale</option>-->
	    		<option value="rent" <?php if($client_data[0]['main_property_type']=='rent') { ?> selected <?php } ?>>Rent In </option>
	    		<!--<option value="rent_out" <?php if($client_data[0]['main_property_type']=='rent_out') { ?> selected <?php } ?>>Rent Out</option>-->
	    		
	    		
	    	</select>
	    </td>
	   
  </tr>
  
   <tr>
	   
	    <td class="black11" style="width: 18%;"><input <?php if($client_data[0]['property_type']=="residential") { ?>  checked="checked" <?php } ?>  type="radio" name="residential" id="residential" value="residential" onclick="showhidediv(this);"></td>
	     <td class="black11" style="width: 18%;">Residential</td>
	    	
	   
	    <td class="black11" style="width: 18%;"><input <?php if($client_data[0]['property_type']=="commercial") { ?>  checked="checked" <?php } ?>  type="radio" name="residential" id="commercial" value="commercial" onclick="showhidediv(this);"></td>
	      <td class="black11" style="width: 18%;">Commercial</td>
	   
  </tr>
  
  </table>
  
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1" <?php if($broker_data[0]['property_main_type']=="commercial") { ?>  style="display:none;" <?php } ?>>
   <tr>
	    <th class="black11" colspan="2">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 1%;"><input <?php if($client_data[0]['onerk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="1rk" id="1rk" value="1"></td>
	    <td class="black11" style="width: 4%;">1RK</td>		
<td class="black11" style="width: 1%;"><input  <?php if($client_data[0]['onebhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="1bhk" id="1bhk" value="1"></td>
	<td class="black11" style="width: 18%;">1BHK</td>		

	  </tr>  
	  <tr>
<td class="black11" ><input <?php if($client_data[0]['twobhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="2bhk" id="2bhk" value="1"></td>
	    <td class="black11">2BHK</td>		
<td class="black11"><input <?php if($client_data[0]['threebhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="3bhk" id="3bhk" value="1"></td>
	<td class="black11">3BHK</td>		

	  </tr>  
	  <tr>
<td class="black11"><input <?php if($client_data[0]['fourbhk']=='1') { ?>  checked <?php } ?>  type="checkbox" name="4bhk+" id="4bhk+" value="1"></td>
	    <td class="black11">4BHK+</td>		

	<td class="black11"></td>		
<td class="black11"></td>
	  </tr>  
	   
   </table>
  
  <table  width="80%" border="0" cellspacing="2" cellpadding="2" >
  

  
     
    
    <!-- <tr>
	    <td class="black11">Specify Area:</td>
	    <td class="black11">
	    	<input type="text" name="specify_area" id="specify_area" value="<?php print $client_data[0]['specify_area']?>" />
	    </td>
    </tr>-->
    
   <!--<tr>
	    <td class="black11">Carpet:</td>
	    <td class="black11">
	    	<input type="text" name="carpet" id="carpet" value="<?php print $client_data[0]['carpet']?>" />
	    </td>
    </tr>-->
  
   <tr id="off_ret" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    <td class="black11">Office/Retail</td>
	    <td class="black11">
	    	
	    	<select name="office_check" id="office_check" onchange="off_retfun(this);">
	    		<option value="">Select Type</option>
	    		<option value="1" <?php if($client_data[0]['office']== '1') { ?> selected <?php } ?> >Office</option>
	    		<option value="2" <?php if($client_data[0]['office']== '2') { ?> selected <?php } ?> >Retail</option>
	    	</select>
	    
	    </td>
	    	
	   
	   
  </tr>
  
   <tr>
	    <td class="black11">Approximate Area (SQFT):</td>
	    <td class="black11">
	    	<input type="text" name="scaleble" id="scaleble" value="<?php print $client_data[0]['scaleble']?>" />
	    </td>
    </tr>
  
     <tr id="furn">
       <td class="black11"><input <?php if($client_data[0]['furnished']=='1') { ?>  checked <?php } ?>  type="radio" name="furnished" id="furnished" value="1"></td>
	    <td class="black11">Furnished</td>
	    
	    <td class="black11"><input <?php if($client_data[0]['furnished']=='2') { ?>  checked <?php } ?>  type="radio" name="furnished" id="unfurnished" value="2"></td>
	    	     <td class="black11">Unfurnished</td>
	  
	   <td class="black11"><input <?php if($client_data[0]['furnished']=='3') { ?>  checked <?php } ?>  type="radio" name="furnished" id="any" value="3"></td>	
	    <td class="black11">Any</td>
	   
	   
	   
  </tr>
     <tr id="cell" style="width:110%;" <?php if($broker_data[0]['property_main_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    
	    <td class="black11"><input <?php if($client_data[0]['warm_cell']=='1') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="warm_cell" value="1"></td>
	    <td class="black11" id="warm" title="Flooring & Wall finish available, Toilets are available">Warm Cell ?</td>
	    	
	    
	    <td class="black11"><input <?php if($client_data[0]['warm_cell']=='2') { ?>  checked <?php } ?>  type="radio" name="warm_cell" id="cold_cell" value="2"></td>
	     <td class="black11" title="flooring, wall finish etc not yet finished">Cold Cell ?</td>
	   
  </tr>
  <tr>
	    <th>Area Looking For</th>
  </tr>

  
  <tr>
	    <td class="black11" >Area 1</td>
<td class="black11"><input type="text" name="area[]" id="area1" value="<?php print $client_area[0]['area_name']?>" /></td>
  </tr>
    <tr>
	     <td class="black11" >Area 2</td>
	    <td class="black11"><input type="text" name="area[]" id="area2" value="<?php print $client_area[1]['area_name']?>" /></td>
  </tr>
  <tr>
	    <td class="black11" >Area 3</td>
	    <td class="black11"><input type="text" name="area[]" id="area3" value="<?php print $client_area[2]['area_name']?>" /></td>
	     </tr> 
	  <tr>    
	     <td class="black11" >Area 4</td>
	    <td class="black11"><input type="text" name="area[]" id="area4" value="<?php print $client_area[3]['area_name']?>" /></td>
  </tr>
 
  <tr>
	    <td class="black11" >Approx Budget:</td>
 </tr>
 
 <?php if($mode=='Add') { ?>
 
  <tr id="min_price_exp">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

 </tr>
 
 
 
 <tr id="min_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($mode=='Update') { ?>
 
 <?php if($client_data[0]['main_property_type']=='buy') { ?>
 <tr id="min_price_exp">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

 </tr>
  <tr id="min_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($client_data[0]['main_property_type']=='rent') { ?>
 
 <tr id="min_price_exp" style="display:none;">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

	   
 </tr>
 
 <tr id="min_price_rent" >
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	    
 </tr>
 
 <?php }
 	
  } ?>
 
 <tr>	    
 	<?php    $min_price=$client_data[0]['min_price'];
 	       
 	      	if(strpos($min_price, '0000000'))
 	      	{
 	      		$c1='0000000';
 	      	}	
 	     	else if(strpos($min_price, '00000'))
 	        {
 	       		$c1='00000';
 	        }
 	        else if(strpos($min_price, '000'))
 	        {
 	       		$c1='000';
 	        }
 	      
 	       // echo $c1;
 	        $price1=str_replace($c1,'' ,$min_price);
 	        if($price1>100)
		{
	 	      	$value1=($price1/100);
			$value1=explode(".",$value1);
		
			//print_R($value1);exit;
		
			$value2=($price1%100);
		}	      
 	        else 
 	        {
 	          if($c1==='0000000' && $client_data[0]['main_property_type']=='buy' )
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
 	          else if($c1==='00000' && $client_data[0]['main_property_type']=='buy' )
 	          {
 	          	if($c1==='00000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	           
 	          else if($c1==='00000' && $client_data[0]['main_property_type']=='rent')
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
 	          else if($c1==='000' && $client_data[0]['main_property_type']=='rent')
 	          { 	
 	        	if($c1==='000')
 	        	{
 	        		$value2=$price1;
 	        	}
 	          }
 	        	
 	        	
 	        	
 	        }
 	       
 	 ?>
	    
	    <td class="black11"><input type="text" name="min_price1" id="min_price1" value="<?php print $value1[0]; ?>" /></td> 
	     <td class="black11" >
	     <select name="min_price_type1" id="min_price_type1" value="">
	   
	     	<option value="">Select</option>
	     	<option value="crores" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	    
	     </td>
</tr>
<tr>	    
	    <td class="black11"><input type="text" name="min_price2" id="min_price2" value="<?php print $value2; ?>" /></td>
	     <td class="black11" >
	     <select name="min_price_type2" id="min_price_type2" value="">
	        <option value="">Select</option>
	     	<option value="crores" <?php if($c1 === '0000000')  { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     
	     </td>
  </tr>
  
  
  <?php if($mode=='Add') { ?>
 
  <tr id="max_price_exp">
	    <td class="black11" colspan="2" >Max Budget Price:</td>

 </tr>
 
 
 
 <tr id="max_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($mode=='Update') { ?>
 
 <?php if($client_data[0]['main_property_type']=='buy') { ?>
 <tr id="max_price_exp">
	    <td class="black11" colspan="2" >Max Budget Price:</td>

 </tr>
  <tr id="max_price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>

	   
 </tr>
 
 <?php } else if($client_data[0]['main_property_type']=='rent') { ?>
 
 <tr id="max_price_exp" style="display:none;">
	    <td class="black11" colspan="2" >Max Budget Price:</td>

	   
 </tr>
 
 <tr id="max_price_rent" >
	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>

	    
 </tr>
 
 <?php }
 	
  } ?>
  
  <tr>	    
 	<?php   $max_price=$client_data[0]['max_price'];
 	       
 	       if(strpos($max_price, '0000000'))
 	       {
 	       		$c2='0000000';
 	       }
 	       else if(strpos($max_price, '00000'))
 	       {
 	       		$c2='00000';
 	       }
 	       else if(strpos($max_price, '000'))
 	       {
 	       		$c2='000';
 	       }
 		
 	    		    
  	       $price2=str_replace($c2,'' ,$max_price);
 	       if($price2>100)
		{
 	       $value3=($price2/100);
		$value3=explode(".",$value3);
		//print_R($value3);
		$value4=($price2%100);
 	       }
 	       else
 	       {
 	       
	 	       	 if($c2==='0000000' && $client_data[0]['main_property_type']=='buy' )
	 	          { 	
	 	        	if($c2==='0000000')
	 	        	{
	 	        		$value3[0]=$price2;
	 	        	}
	 	        	else if($c2==='00000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
	 	          else if($c2==='00000' && $client_data[0]['main_property_type']=='buy' )
	 	          {
	 	          	if($c2==='00000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
	 	           
	 	          else if($c2==='00000' && $client_data[0]['main_property_type']=='rent')
	 	          { 	
	 	        	if($c2==='00000')
	 	        	{
	 	        		$value3[0]=$price2;
	 	        	}
	 	        	else if($c2==='000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
	 	          else if($c2==='000' && $client_data[0]['main_property_type']=='rent')
	 	          { 	
	 	        	if($c2==='000')
	 	        	{
	 	        		$value4=$price2;
	 	        	}
	 	          }
 	        
 	       }
 	    
 	 ?>
	    
	    <td class="black11"><input type="text" name="max_price1" id="max_price1" value="<?php print $value3[0]; ?>" /></td> 
	     <td class="black11" >
	     <select name="max_price_type1" id="max_price_type1" value="">
		<option value="">Select</option>	   
	     	<option value="crores" <?php if($c2 === "0000000" ) { ?> selected <?php } ?> >Crore</option>
	     	
	     </select>
	     
	      
	     </td>
	</tr>
	<tr>    
	    <td class="black11"><input type="text" name="max_price2" id="max_price2" value="<?php print $value4; ?>" /></td>
	     <td class="black11" >
	     <select name="max_price_type2" id="max_price_type2" value="">
		<option value="">Select</option>	  
	     	<option value="crores" <?php if($value3[0] > 0)  { ?> selected <?php } ?>  >Crore</option>
	     	
	     </select>
	  
	     </td>
  </tr>

<tr>
	<td class="black11">Status</td>
	<td class="black11">
		 <select name="status" id="status" value="">
			<option value="">Select Status</option>	  
	     		<option <?php if($client_data[0]['status']=='1') { ?> selected  <?php } ?> value="1">New</option>
			<option <?php if($client_data[0]['status']=='2') { ?> selected  <?php } ?> value="2">Information awaited from broker/owner</option>
			<option <?php if($client_data[0]['status']=='3') { ?> selected  <?php } ?> value="3">Contacted – Answered</option>
			<option <?php if($client_data[0]['status']=='4') { ?> selected  <?php } ?> value="4">Contacted – Un-Answered</option>
			<option <?php if($client_data[0]['status']=='5') { ?> selected  <?php } ?> value="5">Follow-up</option>
			<option <?php if($client_data[0]['status']=='6') { ?> selected  <?php } ?> value="6">Property Details Shared</option>
			<option <?php if($client_data[0]['status']=='7') { ?> selected  <?php } ?> value="7">Property Shortlisted</option>
			<option <?php if($client_data[0]['status']=='8') { ?> selected  <?php } ?> value="8">Property disqualified</option>
			<option <?php if($client_data[0]['status']=='9') { ?> selected  <?php } ?> value="9">Request for more options</option>
			<option <?php if($client_data[0]['status']=='10') { ?> selected  <?php } ?> value="10">Site Visit Planned</option>
			<option <?php if($client_data[0]['status']=='11') { ?> selected  <?php } ?> value="11">Site Visit Rescheduled</option>
			<option <?php if($client_data[0]['status']=='12') { ?> selected  <?php } ?> value="12">Site Visit Done</option>
			<option <?php if($client_data[0]['status']=='13') { ?> selected  <?php } ?> value="13">Site Re-Visit</option>
			<option <?php if($client_data[0]['status']=='14') { ?> selected  <?php } ?> value="14">Owner/Broker Meeting Scheduled</option>
			<option <?php if($client_data[0]['status']=='15') { ?> selected  <?php } ?> value="15">Negotiation</option>
			<option <?php if($client_data[0]['status']=='16') { ?> selected  <?php } ?> value="16">Token Given</option>
			<option <?php if($client_data[0]['status']=='17') { ?> selected  <?php } ?> value="17">Registration/Agreement Status</option>
			<option <?php if($client_data[0]['status']=='18') { ?> selected  <?php } ?> value="18">Transaction Successful</option>
			<option <?php if($client_data[0]['status']=='19') { ?> selected  <?php } ?> value="19">Lead Dead</option>	
	     	
	     	</select>	
	</td>	
    </tr>	

  <tr>
    <td>&nbsp;</td>
    <td class="black11"><input type="submit" name="submit" onclick="return validate();" value="<?=$mode;?>" />&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
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

function transaction1(val){
	
	//alert(document.getElementById('transaction_type').value);
	
	
	if (document.getElementById('transaction_type').value=='buy')
	{
		//alert('<?php echo $c1; ?>');
		document.getElementById('min_price_exp').style.display = 'block';
		document.getElementById('min_price_rent').style.display = 'none';
		
		document.getElementById('max_price_exp').style.display = 'block';
		document.getElementById('max_price_rent').style.display = 'none';
		
		document.getElementById('min_price_type1').innerHTML = '<option value="">Select</option><option value="crores" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Crore</option>';
		document.getElementById('min_price_type2').innerHTML = '<option value="">Select</option><option value="laks" <?php if($c2 === '00000') { ?> selected <?php } ?> >Lac</option>';
		
		document.getElementById('max_price_type1').innerHTML = '<option value="">Select</option><option value="crores" <?php if($value3[0]>0 ) { ?> selected <?php } ?> >Crore</option>';
		document.getElementById('max_price_type2').innerHTML = '<option value="">Select</option><option value="laks" <?php if($c2 === '00000') { ?> selected <?php } ?> >Lac</option>';
		
		
		
	
	}
	else if(document.getElementById('transaction_type').value=='rent')
	{
		document.getElementById('min_price_exp').style.display = 'none';
		document.getElementById('min_price_rent').style.display = 'block';
		
		document.getElementById('max_price_exp').style.display = 'none';
		document.getElementById('max_price_rent').style.display = 'block';

		document.getElementById('min_price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value1[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('min_price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c2 === '000') { ?> selected <?php } ?> >Thousand</option>';
		
		document.getElementById('max_price_type1').innerHTML = '<option value="">Select</option><option value="laks" <?php if($value3[0]> 0 ) { ?> selected <?php } ?> >Lac</option>';
		document.getElementById('max_price_type2').innerHTML = '<option value="">Select</option><option value="thousand" <?php if($c2 === '000') { ?> selected <?php } ?> >Thousand</option>';		
		

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
                     office_check: "required",
                     warm_cell: "required",
                     
                    'area[]': { required: true },
                     
                    min_price1: {
                        required: true,
                        number: true
                        
                    },
                    min_price_type1: "required",
                    
                     min_price2: {
                        required: true,
                        number: true
                        
                    },
                    min_price_type2: "required",
                    
                    
                    max_price1: {
                        required: true,
                        number: true
                        
                    },
                    max_price_type1: "required",
                    
                     max_price2: {
                        required: true,
                        number: true
                        
                    },
                    max_price_type2: "required",
                    
                },
                messages: {
                    transaction_type: "Please Select  Transaction Type",
                    residential: "Please Select Property Type",
                  
                    scaleble: {
                        required: "Please enter Approximate Area",
                        number: "Please enter Approximate Area Numeric",
                       
                    },
                    furnished:"Please Select Furniture Type",
                    office_check:"Please Select Office/Retail",
                     warm_cell:"Please Select Cell",
                   area:"Please Enter Area",
                    min_price1: {
                        required: "Please enter Min Price ",
                        number: "Please enter Min Price Numeric",
                       
                    }, 	
                    
                     min_price_type1: "Please Select Min Price Type",
                    
                    min_price2: {
                        required: "Please enter Min Price ",
                        number: "Please enter Min Price Numeric",
                       
                    }, 	
                    
                     min_price_type2: "Please Select Min Price Type",
                     
                     
                      max_price1: {
                        required: "Please enter Max Price ",
                        number: "Please enter Max Price Numeric",
                       
                    }, 	
                    
                     max_price_type1: "Please Select Max Price Type",
                    
                    max_price2: {
                        required: "Please enter Max Price ",
                        number: "Please enter Max Price Numeric",
                       
                    }, 	
                    
                     max_price_type2: "Please Select Max Price Type",
                     
                    
                },
                submitHandler: function(form) {
                    form.submit();
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
