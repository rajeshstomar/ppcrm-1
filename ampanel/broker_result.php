	<?php
			require('includes/script_top.php');
				//print_R($_POST);exit;
				
				$b_id=$_POST['b_id'];
				//$b_name=$_POST['b_name'];
				//$pan_no=$_POST['pan_no'];
				//$mob_no=$_POST['mob_no'];
				$ssql = array();
				$where = '';
				if($b_id != '' )
					$ssql[] = " broker_id like '".$b_id."' ";
				
				if($b_id != '' )
					$ssql[] = " broker_name like '%".$b_id."%' ";
				if($b_id != '' )
					$ssql[] = " pan_card_num like '$b_id'";
				if($b_id != '' )
					$ssql[] = " mobile1_no like '%".$b_id."%' ";
					
				if(count($ssql) > 0)
					$where = " WHERE ".implode(" OR", $ssql);
				$qry ="select broker_id,broker_name,pan_card_num,mobile1_no from broker ".$where;
				//echo $qry; exit;
				$result = am_select($qry);
				//print_R($result);exit; 
				$dis_string = '';
				$dis_string.="<h3>Select Any One Broker</h3>";
				$dis_string.="<table border='1'>";
				$dis_string.="<tr>";
				$dis_string.="<th></th>";
				$dis_string.="<th>Broker ID</th>";
				$dis_string.="<th>Name</th>";
				$dis_string.="<th>Pan No</th>";
				$dis_string.="<th>Mobile No</th>";
				$dis_string.="</tr>";
				
				
				?>
				
				
			<?php	for($i=0;$i<count($result);$i++)
				{ 
					$dis_string.="<tr>";
					$dis_string.="<td><a href='javascript:' ref='".$result[$i]['broker_id']."' refno='".$result[$i]['mobile1_no']."' class='select_broker'>Select</a></td>";
					$dis_string.="<td>".$result[$i]['broker_id']."</td>";
					$dis_string.="<td>".$result[$i]['broker_name']."</td>";
					$dis_string.="<td>".$result[$i]['pan_card_num']."</td>";
					$dis_string.="<td>".$result[$i]['mobile1_no']."</td>";
					$dis_string.="</tr>";
				
				}
			
			$dis_string.="</table>";
			//$dis_string.="<input type='button' name='broker_id' value='Go' id='click'>";
			echo $dis_string;
		?>
		
