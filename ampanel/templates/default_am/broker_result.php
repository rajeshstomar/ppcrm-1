	<?php
			
				//print_R($_POST);exit;
				
				$b_name=$_POST['b_name'];
				$pan_mob=$_POST['pan_mob'];
				
				$qry ="select broker_id,pan_card_num,mobile1_no from broker WHERE broker_name like '%$b_name' or  mobile1_no like '$pan_mob' or  pan_card_num like '$pan_mob' ";
				$result = am_select($qry);
				print_R($result);exit;
				
				
			
			
		
		?>
		
