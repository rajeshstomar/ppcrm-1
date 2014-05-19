	<?php
			require('includes/script_top.php');
				//print_R($_POST);exit;
				
				$b_id=$_POST['b_id'];
				$b_name=$_POST['b_id'];
				$email_id=$_POST['b_id'];
				$mob_no=$_POST['b_id'];
				$ssql = array();
				$where = '';
				if($b_id != '' )
					$ssql[] = " broker_id like '".$b_id."' ";
				
				if($b_name != '' )
					$ssql[] = " broker_name like '%".$b_name."%' ";
				if($pan_no != '' )
					$ssql[] = " email like '%".$email_id."%'";
				if($mob_no != '' )
					$ssql[] = " mobile1_no like '%".$mob_no."%' ";
					
				if(count($ssql) > 0)
					$where = " WHERE ".implode(" OR ", $ssql);
				//echo "select broker_property_id,broker_owner_id,near_building_id,floor,add_line2,add_line1,city from property_requirement left join broker on property_requirement.broker_owner_id=broker.broker_id ".$where;
					
					
				$qry ="select broker_property_id,broker_owner_id,broker_name,b_name,floor,add_line2,add_line1,city from property_requirement left join broker on property_requirement.broker_owner_id=broker.broker_id left join building_database on  property_requirement.near_building_id=building_database.id_building ".$where;
				//echo $qry; exit;
				$result = am_select($qry);
				//print_R($result);exit; 
				$dis_string = '';
				$dis_string.="<h3>Select Any One Property</h3>";
				$dis_string.="<table border='1'>";
				$dis_string.="<tr>";
				$dis_string.="<th></th>";
				$dis_string.="<th>Broker/Owner ID</th>";
				$dis_string.="<th>Listing ID</th>";
				$dis_string.="<th>Broker/Owner Name</th>";
				$dis_string.="<th>Nearest Building</th>";
				$dis_string.="<th>Floor</th>";
				$dis_string.="<th>Nearest Landmark</th>";
				$dis_string.="<th>Area</th>";
				$dis_string.="<th>City</th>";
				$dis_string.="</tr>";
				
				
				?>
				
				
			<?php	for($i=0;$i<count($result);$i++)
				{ 
					$dis_string.="<tr>";
					$dis_string.="<td><a href='javascript:' broker_owner_id='".$result[$i]['broker_owner_id']."' broker_property_id='".$result[$i]['broker_property_id']."'  broker_name='".$result[$i]['broker_name']."'  near_building_id='".$result[$i]['b_name']."'  floor='".$result[$i]['floor']."'  add_line2='".$result[$i]['add_line2']."'  add_line1='".$result[$i]['add_line1']."' city='".$result[$i]['city']."'  class='select_broker'>Select</a></td>";
					$dis_string.="<td>".$result[$i]['broker_owner_id']."</td>";
					$dis_string.="<td>".$result[$i]['broker_property_id']."</td>";
					$dis_string.="<td>".$result[$i]['broker_name']."</td>";
					$dis_string.="<td>".$result[$i]['b_name']."</td>";
					$dis_string.="<td>".$result[$i]['floor']."</td>";
					$dis_string.="<td>".$result[$i]['add_line2']."</td>";
					$dis_string.="<td>".$result[$i]['add_line1']."</td>";
					$dis_string.="<td>".$result[$i]['city']."</td>";
					$dis_string.="</tr>";
				
				}
			
			$dis_string.="</table>";
			//$dis_string.="<input type='button' name='broker_id' value='Go' id='click'>";
			echo $dis_string;
		?>
		
