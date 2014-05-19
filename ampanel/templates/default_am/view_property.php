
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
	//my_print_R($client_data);exit;
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

?>


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

	
	
	if (document.getElementById('transaction_type').value=='buy')
	{
		document.getElementById('price_exp').style.display = 'block';
		document.getElementById('price_rent').style.display = 'none';
	
	}
	else if(document.getElementById('transaction_type').value=='rent')
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
});
});
</script>
<div align="center" style="width:80%; margin-bottom:5px;"><font color="#FF0000"><?php print $msg; ?></font></div>
<h2> View Property For this Customer: <?php echo $client_name[0]['f_name']." ".$client_name[0]['l_name']; ?> </h2>
<form name="frm" method="post" action="index.php?rel=property_action" >
<input type="hidden" name="mode" id="mode" value="<?=$mode;?>">
<input type="hidden" name="customer_id" value="<?php print $_GET['customer_id']; ?>" />
<input type="hidden" name="property_id" value="<?php print $client_data[0]['property_id']; ?>" />
<input type="hidden" name="area_id" value="<?php print $client_data[0]['area_id']; ?>" />

	
<table width="80%" border="0" cellspacing="2" cellpadding="2"> 
  
  
  <tr>
	    <th colspan="2">Property Looking For</th>
  </tr>
  
  <tr>
	    <td class="black11" style="width: 18%;">Transaction Type</td>
	    <td class="black11">
	    
	    <?php echo $client_data[0]['main_property_type']; ?>
	    	
	    </td>
	   
  </tr>
  
   <tr>

	    <td class="black11"> Property Type </td>
	    <td class="black11">
	  
	    <?php if($client_data[0]['property_type']=="residential") { ?>
	    	  <label onclick="showhidediv();">Residential  </label>
	    <?php } else if($client_data[0]['property_type']=="commercial") { ?>
	    	 <label onclick="showhidediv(this);">Commercial </label>
	    <?php }  ?>
	    </td>
	   
  </tr>
  
  </table>
  
  <table width="80%"  border="0" cellspacing="2" cellpadding="2" id="apartment1" <?php if($client_data[0]['property_type']=="commercial") { ?>  style="display:none;" <?php } ?>>
   <tr>
	    <th class="black11" colspan="2">Type of Apartment:</th>
	    

	 <tr>
	 <td class="black11" style="width: 1%;"> <?php if($client_data[0]['onerk']=='1') { ?>  1RK <?php } ?>  </td>
	    	
<td class="black11" style="width: 1%;"> <?php if($client_data[0]['onebhk']=='1') { ?>  1BHK <?php } ?>  </td>
         </tr>  
	  <tr>
<td class="black11" > <?php if($client_data[0]['twobhk']=='1') { ?>  2BHK <?php } ?>  </td>
	   	
<td class="black11"> <?php if($client_data[0]['threebhk']=='1') { ?>  3BHK <?php } ?> </td>
	
	  </tr>  
	  <tr>
<td class="black11"><?php if($client_data[0]['fourbhk']=='1') { ?>  4BHK+ <?php } ?>  </td>
	    <td class="black11"></td>		

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
  
   <tr id="off_ret" <?php if($client_data[0]['property_type']=="residential") { ?>  style="display:none;" <?php } ?>>
	    <td class="black11">Office/Retail:</td>
	    <td class="black11">
	    	
	    	 <?php if($client_data[0]['office']== '1') { ?> Office <?php } ?> 
	         <?php if($client_data[0]['office']== '2') { ?> Retail <?php } ?>
	    </td>
	    	
	   
	   
  </tr>
  
   <tr>
	    <td class="black11">Approximate Area (SQFT):</td>
	    <td class="black11">
	    <?php print $client_data[0]['scaleble']?>
	    	
	    </td>
    </tr>
  
     <tr id="furn"  <?php if($client_data[0]['office']== '2') { ?> style="display:none;" <?php } ?> >
	 
	    <td class="black11"><?php if($client_data[0]['furnished']=='1') { ?>  Furnished <?php } ?> </td>
	    <td class="black11"><?php if($client_data[0]['furnished']=='2') { ?>  Unfurnished <?php } ?></td>
	 	    <td class="black11"><?php if($client_data[0]['furnished']=='3') { ?>  Any <?php } ?>  </td>	
	   
	   
  </tr>
     <tr id="cell" <?php if($client_data[0]['property_type']=="residential") { ?>  style="display:none;" <?php } ?> <?php if($client_data[0]['office']== '1') { ?> style="display:none;" <?php } ?>>
	   
	    <td class="black11"> <?php if($client_data[0]['warm_cell']=='1') { ?>  Warm Cell <?php } ?> </td>
	    	
	  
	    <td class="black11"><?php if($client_data[0]['warm_cell']=='2') { ?>  Cold Cell <?php } ?> </td>
	   
  </tr>
  <tr>
	    <th>Area Looking For</th>
  </tr>
  <tr>
	    <td class="black11" >Area 1</td>
<td class="black11"><?php print $client_area[0]['area_name']?></td>
	     <td class="black11" >Area 2</td>
	    <td class="black11"><?php print $client_area[1]['area_name']?></td>
  </tr>
  <tr>
	    <td class="black11" >Area 3</td>
	    <td class="black11"><?php print $client_area[2]['area_name']?></td>
	     <td class="black11" >Area 4</td>
	    <td class="black11"><?php print $client_area[3]['area_name']?></td>
  </tr>
 
  <tr>
	    <td class="black11" >Approx Budget:</td>
 </tr>
 
 <?php if($mode=='Add') { ?>
 
  <tr id="price_exp">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

	    <td class="black11" colspan="2" >Max Budget Price:</td>
 </tr>
 
 
 
 <tr id="price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>
 </tr>
 
 <?php } else if($mode=='Update') { ?>
 
 <?php if($client_data[0]['main_property_type']=='buy') { ?>
 <tr id="price_exp">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

	    <td class="black11" colspan="2" >Max Budget Price:</td>
 </tr>
  <tr id="price_rent" style="display:none;">
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>
 </tr>
 
 <?php } else if($client_data[0]['main_property_type']=='rent') { ?>
 
 <tr id="price_exp" style="display:none;">
	    <td class="black11" colspan="2" >Min Budget Price:</td>

	    <td class="black11" colspan="2" >Max Budget Price:</td>
 </tr>
 
 <tr id="price_rent" >
	    <td class="black11" colspan="2" >Min Expected Rent Per Month:</td>

	    <td class="black11" colspan="2" >Max Expected Rent Per Month:</td>
 </tr>
 
 <?php }
 	
  } ?>
 
 <tr>	    
 	<?php   $min_price=$client_data[0]['min_price'];
 	       
 	     
 	       
 	     /*  if(strpos($min_price, '0000000'))
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
 	       	//$c9='0000000';
 	     	//echo $c1;exit;
 	       $price1=str_replace($c1,'' ,$min_price);
 	      // echo $c1;exit;
 	      */
 	       
 	 ?>
	    
	    <td class="black11" colspan="2"><?php print $min_price; ?></td> 
	     <!--<td class="black11" >
	      <?php if($c1 === "000") { ?> Thousand <?php } ?>
	      <?php if( $c1 === "00000" ) { ?> Lac <?php } ?> 
	      <?php if($c1 === "0000000" ) { ?> Crore <?php } ?> 
	     	     </td>-->
	    <?php   $max_price=$client_data[0]['max_price'];
 	       
 	      /* if(strpos($max_price, '0000000'))
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
 	     //  echo $c2;exit;
 	      
 	       $price2=str_replace($c2,'' ,$max_price);
 	       
 	     //  echo $c2;exit; */
 	       
 	 ?>
	    <td class="black11" colspan="2"><?php print $max_price; ?></td>
	    <!-- <td class="black11" >
	     <?php if($c2 === '000') { ?> Thousand <?php } ?>
	     <?php if($c2 === '00000') { ?> Lac <?php } ?> 
	      <?php if($c2 === '0000000')  { ?> Crore <?php } ?></option>
	     	  
	     </td>-->
  </tr>
  

<tr>
	<td class="black11">Status</td>
	<td class="black11">
			
		<?php echo get_customer_lead_status($client_data[0]['property_id']); ?>	
	
	</td>	
    </tr>	

  
  <tr>
    <td>&nbsp;</td>
    <td class="black11"><a href="index.php?rel=edit_property&id=<?php print $client_data[0]['property_id']; ?>&customer_id=<?php print $_GET['customer_id']; ?>"><input type="button" name="submit" onclick="return validate();" value="Edit Property" /></a>&nbsp;<!--<input type="reset" name="reset"  value="Reset" />&nbsp;<input type="button" name="cancel" onclick="javascript:window.location='index.php?rel=common_listing&module=static_pages';" value="Cancel" />--></td>
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
