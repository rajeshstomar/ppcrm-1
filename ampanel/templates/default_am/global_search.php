<?php

	if(isset($_REQUEST['submit1']) ||  isset($_REQUEST['submit2']))
	{
	 $c_id=$_POST['client_id'];
	 $c_name=$_POST['client_name'];

	 	$ssql = array();
	      	$c_name=trim($c_name," ");
			/* For Firm */
			$where = '';
			if($c_id !='')
				$ssql[] = " company_id = ".$c_id." ";
			if($c_name !='')
				$ssql[] = " company_name like '%".$c_name."%' ";
			
			if(count($ssql) > 0)
				$where = " WHERE ".implode(" OR", $ssql);
		
		
		$qry_firm ="select company_id,company_name from broker_firm ".$where; 
			$result_firm = am_select($qry_firm);
			$count_firm=count($result_firm);
		
			/* For Broker */
		$ssql = array();	
		$c_name=trim($c_name," ");
			$where = '';
			if($c_id !='')
				$ssql[] = " broker_id = ".$c_id." ";
			if($c_name !='')
				$ssql[] = " broker_name like '%".$c_name."%' ";
			
			if(count($ssql) > 0)
				$where = " WHERE ".implode(" OR", $ssql);
		
			$qry_broker ="select broker_id,broker_name from broker ".$where;
			$result_broker = am_select($qry_broker);
			$count_broker=count($result_broker);
		
		
			/* For Customer */
		$ssql = array();	
			$where = '';
		
			$c_name=trim($c_name," ");
			$c=explode(" ",$c_name);
			//print_R($c);exit;
			$count=count($c);
		
		
			if($c_id !='')
				$ssql[] = " client_id = ".$c_id." ";
			if($count == 1 && $c[0] != '')
				$ssql[] = " (f_name like '%".$c[0]."%' or l_name like '%".$c[0]."%' )";

			if($count == 2 && $c[0] != '' && $c[1] != '')
				$ssql[] = " (f_name like '%".$c[0]."%' or l_name like '%".$c[1]."%' or f_name like '%".$c[1]."%' or l_name like '%".$c[0]."%' )";	
			
			if(count($ssql) > 0)
				$where = "inner join client_property on  client_personal_details.client_id=client_property.client_property_id WHERE ".implode(" OR", $ssql);
		
		  $qry_customer ="select client_id,CONCAT(f_name,' ',l_name) as name from client_personal_details ".$where;
			$result_customer = am_select($qry_customer);
			$count_customer=count($result_customer);


			/* For Owner */
		$ssql = array();	
			$where = '';
		
			$c_name=trim($c_name," ");
			$c1=explode(" ",$c_name);
			//print_R($c);exit;
			$count1=count($c1);
		
		
			if($c_id !='')
				$ssql[] = " client_id = ".$c_id." ";
			if($count1 == 1 && $c1[0] != '')
				$ssql[] = " (f_name like '%".$c1[0]."%' or l_name like '%".$c1[0]."%' )";

			if($count == 2 && $c1[0] != '' && $c1[1] != '')
				$ssql[] = " (f_name like '%".$c1[0]."%' or l_name like '%".$c1[1]."%' or f_name like '%".$c1[1]."%' or l_name like '%".$c1[0]."%' )";	
			
			if(count($ssql) > 0)
				$where = "left join property_requirement on  client_personal_details.client_id=property_requirement.broker_owner_id  WHERE ".implode(" OR", $ssql);
		
		   $qry_owner ="select client_id,CONCAT(f_name,' ',l_name) as name from client_personal_details ".$where."and flag='owner'";
			$result_owner = am_select($qry_owner);
			$count_owner=count($result_owner);

		
	
			/* For Customer Property */
			$ssql = array();	
			$c_name=trim($c_name," ");
			$where = '';
			if($c_id !='')
				$ssql[] = " property_id = ".$c_id." ";
			//if($c_name !='')
				//$ssql[] = " property_name like '%".$c_name."%' ";
			
			if(count($ssql) > 0)
				$where .= " left join client_personal_details as cpd on  cp.client_property_id=cpd.client_id WHERE 1=1 AND ".implode(" OR", $ssql);
			if($where !='')
			{ 
			$qry_property ="select cp.property_id,cp.client_property_id as client_id,CONCAT(cpd.f_name,' ',cpd.l_name) as name from client_property as cp ".$where;
			//echo $qry_property; exit;
			$result_property = am_select($qry_property);
			$count_property=count($result_property);
			}


			
			/* For owner Property */
			$ssql = array();	
			$c_name=trim($c_name," ");
			$where = '';
			if($c_id !='')
				$ssql[] = " broker_property_id = ".$c_id." ";
			//if($c_name !='')
				//$ssql[] = " property_name like '%".$c_name."%' ";
			
			if(count($ssql) > 0)
				$where = " left join client_personal_details as cpd on  cp.broker_owner_id=cpd.client_id WHERE ".implode(" OR", $ssql);
			if($where != '')
			{
			$qry_owner_property ="select cp.broker_property_id,cp.broker_owner_id as client_id,CONCAT(cpd.f_name,' ',cpd.l_name) as name from property_requirement as cp ".$where." and flag='owner'";
			$result_owner_property = am_select($qry_owner_property);
			$count_owner_property=count($result_owner_property);		
			}

			
			/* For Broker Property */
			$ssql = array();	
			$c_name=trim($c_name," ");
			$where = '';
			if($c_id !='')
				$ssql[] = " broker_property_id = ".$c_id." ";
			//if($c_name !='')
				//$ssql[] = " property_name like '%".$c_name."%' ";
			
			if(count($ssql) > 0)
				$where = " left join broker as cpd on  cp.broker_owner_id=cpd.broker_id WHERE ".implode(" OR", $ssql);
			if($where != '')
			{
			 $qry_broker_property ="select cp.broker_property_id,cp.broker_owner_id as broker_id,cpd.broker_name as name from property_requirement as cp".$where." and (flag='brokerdirect' or flag='indirect' )";
			$result_broker_property = am_select($qry_broker_property);
			$count_broker_property=count($result_broker_property);	

			}
		
		
		if(($count_firm == 0) && ($count_broker == 0) && ($count_customer == 0) && ($count_owner == 0) && ($count_property == 0) && ($count_owner_property == 0 ) && ($count_broker_property == 0 ) )
		{
			$msg="<h4> No Record Found With Your Keyword</h4>";
		}		
	
		

	
		}
	?>


<?php

	if(isset($_REQUEST['keyword']) &&  isset($_REQUEST['property_type']))
	{
		  $key=$_POST['keyword'];
		  $c_name=$_POST['property_type'];
		
		 if($c_name=='ow_br_prop')
		 {

			$ssql = array();
	      		$key=trim($key," ");
			/* For broker/owner Property */
			$where = '';
			if($key !='')
				$ssql[] = "bd.b_name like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line3 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line2 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line1 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.city like '%".$key."%' ";
			
			if(count($ssql) > 0)
				$where = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR ", $ssql).")";
			 $qry_br_prop ="select * from property_requirement as pr  ".$where; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);



		 }
		 else if($c_name=='br_prop')
		 {

		
			$ssql = array();
	      		$key=trim($key," ");
			/* For broker/owner Property */
			$where = '';
			if($key !='')
				$ssql[] = "bd.b_name like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line3 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line2 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line1 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.city like '%".$key."%' ";
			
			if(count($ssql) > 0)
				$where = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR ", $ssql).")";
			 $qry_br_prop ="select * from property_requirement as pr  ".$where." and flag!='owner'"; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);

		 }
		 else if($c_name=='ow_prop')
		 {
			
			$ssql = array();
	      		$key=trim($key," ");
			/* For broker/owner Property */
			$where = '';
			if($key !='')
				$ssql[] = "bd.b_name like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line3 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line2 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.add_line1 like '%".$key."%' ";
			if($key !='')
				$ssql[] = "pr.city like '%".$key."%' ";
			
			if(count($ssql) > 0)
				$where = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR ", $ssql).")";			

			$qry_br_prop ="select * from property_requirement as pr  ".$where." and flag='owner'"; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_cus_prop);exit;
			$count_br_prop=count($result_br_prop);
		 }
		
		if($count_br_prop == 0)
		{
			$msg="<h4> No Record Found With Your Keyword</h4>";
		}


	}
	
	if(isset($_REQUEST['keyword1']) &&  isset($_REQUEST['property_field']))
	{
		  $key1=$_POST['keyword1'];
		  $c_name1=$_POST['property_field'];
	 	
		 // echo $key1." ".$c_name1;exit;		 		
		
		 if($c_name1=='nr_buld')
		 {

			$ssql1 = array();
	      		$key1=trim($key1," ");
			/* For broker/owner Property */
			$where1 = '';
			if($key1 !='')
				$ssql1[] = "bd.b_name like '%".$key1."%' ";
			
			
			if(count($ssql1) > 0)
				$where1 = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR", $ssql1).")";
			 $qry_br_prop ="select * from property_requirement as pr  ".$where1; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);
		
		 }
		 else if($c_name1=='nr_area')
		  {

			$ssql1 = array();
	      		$key1=trim($key1," ");
			/* For broker/owner Property */
			$where1 = '';
			if($key1 !='')
				$ssql1[] = "pr.add_line3 like '%".$key1."%' ";
			
			
			if(count($ssql1) > 0)
				$where1 = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR", $ssql1).")";
			 $qry_br_prop ="select * from property_requirement as pr  ".$where1; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);
		
		 }
		  else if($c_name1=='nr_road')
		  {

			$ssql1 = array();
	      		$key1=trim($key1," ");
			/* For broker/owner Property */
			$where1 = '';
			if($key1 !='')
				$ssql1[] = "pr.add_line2 like '%".$key1."%' ";
			
			
			if(count($ssql1) > 0)
				$where1 = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR", $ssql1).")";
			$qry_br_prop ="select * from property_requirement as pr  ".$where1; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);
		
		 }
		 else if($c_name1=='street_name')
		  {

			$ssql1 = array();
	      		$key1=trim($key1," ");
			/* For broker/owner Property */
			$where1 = '';
			if($key1 !='')
				$ssql1[] = "pr.add_line1 like '%".$key1."%' ";
			
			
			if(count($ssql1) > 0)
				$where1 = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR", $ssql1).")";
			$qry_br_prop ="select * from property_requirement as pr  ".$where1; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);
		
		 }		
		  else if($c_name1=='city')
		  {

			$ssql1 = array();
	      		$key1=trim($key1," ");
			/* For broker/owner Property */
			$where1 = '';
			if($key1 !='')
				$ssql1[] = "pr.city like '%".$key1."%' ";
			
			
			if(count($ssql1) > 0)
				$where1 = "left join building_database as bd on pr.near_building_id=bd.id_building  WHERE (".implode(" OR", $ssql1).")";
			$qry_br_prop ="select * from property_requirement as pr  ".$where1; 
			$result_br_prop = am_select($qry_br_prop);
			//print_R($result_br_prop);exit;
			$count_br_prop=count($result_br_prop);
		
		 }
		if($count_br_prop == 0)
		{
			$msg="<h4> No Record Found With Your Keyword</h4>";
		}

	}
	

?>





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
<h2>Global Search</h2>
<form name="frm" method="post" id="register-form" action="">
<table width="60%" cellspacing="0" cellpadding="0">

   <tr>
	    <td class="black11">ID:</td>
	    <td class="black11"><input type="text"  name="client_id" id="client_id" value="<?php echo $_POST['client_id']; ?>" /></td>
	    <td class="black11"><input type="submit" name="submit1" onclick="" value="Search" /></td>

  </tr>	
</table>
</form>
   
<form name="frm1" method="post" id="register-form1" action="">
<table width="60%" cellspacing="0" cellpadding="0">	
  <tr>
	    <td class="black11">Name:</td>
	    <td class="black11"><input type="text"  name="client_name" id="client_name" value="<?php echo $_POST['client_name']; ?>" /></td>
	    <td class="black11"><input type="submit" name="submit2" onclick="" value="Search" /></td>
	
  </tr>
   

</table>
</form>
   

<?php if(($count_firm > 0) || ($count_broker > 0) || ($count_customer > 0) || ($count_owner > 0) || ($count_property > 0) || ($count_owner_property > 0 ) || ($count_broker_property > 0 ) ) { ?>
<table width="60%" cellspacing="0" cellpadding="0" border='1' style="text-align: center;">
<h3>Your Search Result</h3> 
<?php  if($count_firm > 0) { ?>

   <tr>
	  <th>Company ID</th>
	  <th>Company Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_firm['0']['company_id']; ?></td>
	  <td><?php echo $result_firm['0']['company_name']; ?></td>
	  <td><a href="index.php?&rel=edit_company&mode=view&id=<?php echo $result_firm['0']['company_id'];?>">View Firm</a></td>  
  </tr>
 		
<?php	} ?>

<?php if($count_broker > 0) { ?>

   <tr>
	  <th>Broker ID</th>
	  <th>Broker Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_broker['0']['broker_id']; ?></td>
	  <td><?php echo $result_broker['0']['broker_name']; ?></td>
	  <td><a href="index.php?&rel=edit_broker&id=<?php echo $result_broker['0']['broker_id'];?>">View Broker</a></td>  
  </tr>
 		
<?php	} ?>

<?php if($count_customer > 0) { ?>

   <tr>
	  <th>Customer ID</th>
	  <th>Customer Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_customer['0']['client_id']; ?></td>
	  <td><?php echo $result_customer['0']['name']; ?></td>
	  <td><a href="index.php?&rel=view_customer&id=<?php echo $result_customer['0']['client_id'];?>">View Customer</a></td>  
  </tr>
 		
    <?php }?>


<?php if($count_owner > 0) { ?>

   <tr>
	  <th>Owner ID</th>
	  <th>Owner Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_owner['0']['client_id']; ?></td>
	  <td><?php echo $result_owner['0']['name']; ?></td>
	  <td><a href="index.php?&rel=view_owner&id=<?php echo $result_owner['0']['client_id'];?>">View Owner</a></td>  
  </tr>
 		
    <?php }?>

<?php if($count_property > 0) { ?>

   <tr>
	  <th>Customer Property ID</th>
	  <th>Customer Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_property['0']['property_id']; ?></td>
	  <td><?php echo $result_property['0']['name']; ?></td>
	  <td><a href="index.php?&rel=view_property&id=<?php echo $result_property['0']['property_id'];?>&customer_id=<?php echo $result_property['0']['client_id'];?>">View Cutomer Property</a></td>  
  </tr>
 		
    <?php }?>


<?php if($count_owner_property > 0) { ?>

   <tr>
	  <th>Owner Property ID</th>
	  <th>Owner Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_owner_property['0']['broker_property_id']; ?></td>
	  <td><?php echo $result_owner_property['0']['name']; ?></td>
	  <td><a href="index.php?&rel=view_owner_property&id=<?php echo $result_owner_property['0']['broker_property_id'];?>&owner_id=<?php echo $result_owner_property['0']['client_id'];?>">View Owner Property</a></td>  
  </tr>
 		
    <?php }?>



<?php if($count_broker_property > 0) { ?>

   <tr>
	  <th>Broker Property ID</th>
	  <th>Broker Name</th>
	  <th></th>
  </tr>	
	
  <tr>
	  <td><?php echo $result_broker_property['0']['broker_property_id']; ?></td>
	  <td><?php echo $result_broker_property['0']['name']; ?></td>
	  <td><a href="index.php?&rel=view_owner_property&id=<?php echo $result_broker_property['0']['broker_property_id'];?>&owner_id=<?php echo $result_broker_property['0']['broker_id'];?>">View Broker Property</a></td>  
  </tr>
 		
    <?php }?>


      </table>
<?php	}  ?>
	
		
	



<form name="frm2" method="post" id="register-form3" action="">
<table width="90%" cellspacing="0" cellpadding="0">	

	<tr>
		<td><h2>OR</h2></td>	
	</tr>
	<tr>
		<td><h4>Search Property</h4></td>	
	</tr>
  <tr>
	    <td class="black11">Search Your Keyword:</td>
	    <td class="black11"><input type="text"  name="keyword" id="keyword" value="<?php echo $_POST['keyword']; ?>" /></td>
	    <td>
		<select name="property_type" id="property_type" value="">
			<option value="">Select Property Type</option>
			<option value="br_prop" <?php if($_POST['property_type']=='br_prop') { ?> selected <?php } ?> >Broker Property </option>
			<option value="ow_prop" <?php if($_POST['property_type']=='ow_prop') { ?> selected <?php } ?>>Owner Property </option>
			<option value="ow_br_prop" <?php if($_POST['property_type']=='ow_br_prop') { ?> selected <?php } ?>>Broker/Owner Property </option>
		</select>		
	    </td>
	    <td class="black11"><input type="submit" name="submit3" onclick="" value="Search" />
		<span title="Search By Nearest Building,Area,Nearest Road,Street Name,City" alt="Search By Nearest Building,Area,Nearest Road,Street Name,City"><b>?</b></span>
	    </td>
	    
  </tr>
   

</table>
</form>

<form name="frm3" method="post" id="register-form4" action="">
<table width="90%" cellspacing="0" cellpadding="0">	

	<tr>
		<td><h2>OR</h2></td>	
	</tr>
	<tr>
		<td><h4>Search Property</h4></td>	
	</tr>
  <tr>
	    <td class="black11">Search Your Keyword:</td>
	    <td class="black11"><input type="text"  name="keyword1" id="keyword1" value="<?php echo $_POST['keyword1']; ?>" /></td>
	    <td>
		<select name="property_field" id="property_field" value="">
			<option value="">Select Your Field</option>
			<option value="nr_buld" <?php if($_POST['property_field']=='nr_buld') { ?> selected <?php } ?> >Nearest Building</option>
			<option value="nr_area" <?php if($_POST['property_field']=='nr_area') { ?> selected <?php } ?>>Area </option>
			<option value="nr_road" <?php if($_POST['property_field']=='nr_road') { ?> selected <?php } ?>>Nearest Road </option>
			<option value="street_name" <?php if($_POST['property_field']=='street_name') { ?> selected <?php } ?>>Street Name </option>
			<option value="city" <?php if($_POST['property_field']=='city') { ?> selected <?php } ?>>City </option>
			
		</select>		
	    </td>
	    <td class="black11"><input type="submit" name="submit3" onclick="" value="Search" />
		<span title="Search By Nearest Building,Area,Nearest Road,Street Name,City" alt="Search By Nearest Building,Area,Nearest Road,Street Name,City"><b>?</b></span>
	    </td>
	    
  </tr>
   

</table>
</form>






<?php if(($count_cus_prop > 0) ) { ?>
<table width="60%" cellspacing="0" cellpadding="0" border='1' style="text-align: center;">
<h3>Your Search Property Result</h3> 
<?php  if($count_cus_prop > 0) { 

	//print_R($result_cus_prop);exit;
	
?>

   <tr>
	  <th>Property Id</th>
	  <th>Property For</th>
	  <th>Property Type</th>
	  <th>Specify Area(Sqft)</th>
          <th>Min Price</th>
	  <th>Max Price</th>
		
	  <th></th>
  </tr>	
<?php for($i=0;$i<count($result_cus_prop);$i++) { ?>
	
  <tr>
	  <td><?php echo $result_cus_prop[$i]['property_id']; ?></td>
	  <td><?php echo $result_cus_prop[$i]['main_property_type']; ?></td>
	  <td><?php echo $result_cus_prop[$i]['property_type']; ?></td>
          <td><?php echo $result_cus_prop[$i]['scaleble']; ?></td>
          <td><?php echo $result_cus_prop[$i]['min_price']; ?></td>
          <td><?php echo $result_cus_prop[$i]['max_price']; ?></td>  

	  <td><a href="index.php?&rel=view_property&id=<?php echo $result_cus_prop[$i]['property_id'];?>&customer_id=<?php echo $result_cus_prop[$i]['client_property_id'];?>">View Property</a></td>  
  </tr>
 		
<?php }	} ?>
    </table>
<?php	}  ?>



<?php echo $price=singledigit("15200"); ?>

<?php if(($count_br_prop > 0) ) { ?>
<table width="60%" cellspacing="0" cellpadding="0" border='1' style="text-align: center;">
<h3>Your Search Property Result</h3> 
<?php  if($count_br_prop > 0) { 

	//print_R($result_cus_prop);exit;
	
?>

   <tr>
	  <th>Property Id</th>
	  <th>Property For</th>
	  <th>Property Type</th>
	  <th>Specify Area(Sqft)</th>
          <th>Price</th>
	  <th></th>
  </tr>	


<?php for($i=0;$i<count($result_br_prop);$i++) { ?>
	
  <tr>
	  <td><?php echo $result_br_prop[$i]['broker_property_id']; ?></td>
	  <td><?php echo $result_br_prop[$i]['property_main_type']; ?></td>
	  <td><?php echo $result_br_prop[$i]['trans_type']; ?></td>
          <td><?php echo $result_br_prop[$i]['scaleble']; ?></td>
	 	
          <td><?php echo numberToWord($result_br_prop[$i]['price']); ?></td>
		
	 

	


	 <?php  if($result_br_prop[$i]['flag'] == 'owner')  { ?>
	  <td><a href="index.php?&rel=view_owner_property&id=<?php echo $result_br_prop[$i]['broker_property_id'];?>&owner_id=<?php echo $result_br_prop[$i]['broker_owner_id'];?>">View Property</a></td>  
	
	<?php } if( ($result_br_prop[$i]['flag'] == 'brokerdirect') || ($result_br_prop[$i]['flag'] == 'indirect') ) { ?>	        
	

	  <td><a href="index.php?&rel=view_interaction_report&id=<?php echo $result_br_prop[$i]['broker_property_id'];?>">View Property</a></td>  	
        <?php } ?>	
  </tr>
 		
<?php }	} ?>
    </table>
<?php	}  ?>







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
                    client_id: {
				required: true,
                        	number: true

				},
                    
                   
                },
                messages: {
                    client_id: {
                        required: "Please enter client id",
                        number: "Please enter client id Numeric"
                      
                    },
                    
                },
  submitHandler: function(form) {
               	form.submit();	
                	
}
            });

		//form validation rules
            $("#register-form1").validate({
                rules: {
                  
                    client_name: "required",
		    
                   
                },
                messages: {
                   
                    client_name: "Please enter Last Name",
                   
                    
                },
  submitHandler: function(form) {
               	form.submit();	
                	
}
            });		


		//form validation rules
            $("#register-form3").validate({
                rules: {
                  
                    keyword: "required",
		   property_type: "required"	
                   
                },
                messages: {
                   
                    keyword: "Please enter Keyword",
		    property_type: "Please Select Property Type" 
                    
                },
  submitHandler: function(form) {
               	form.submit();	
                	
}
            });		

	    //form validation rules
            $("#register-form4").validate({
                rules: {
                  
                    keyword1: "required",
		   property_field: "required"	
                   
                },
                messages: {
                   
                    keyword1: "Please enter Keyword",
		    property_field: "Please Select Property Field" 
                    
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
<?php

?>
