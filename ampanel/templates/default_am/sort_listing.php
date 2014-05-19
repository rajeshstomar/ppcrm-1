<?php

	$ssql = "";
	$sort = $_GET['sort'];
	
	if($sort == "1")
	{
		$sortoption = " DESC ";
		$sort = 0;
		$sort_image = "&nbsp;<img src='images/arrowdown.gif' border='0'> ";
	}
	else
	{
		$sortoption = " ASC ";
		$sort = 1;
		$sort_image = "&nbsp;<img src='images/arrowup.gif' border='0'> ";
	}

	if($_GET['sort_option'] == "")
	{
		$orderby = $modulearray[$module]['orderby'];
		$sort_image = "";
		$sortoption = "";
	}
	else
	{
		$orderby = $_GET['sort_option'];
	}

	if($_GET['search_option'] != "" && $_GET['keyword'] != "")
	{
		$cols = explode(',',$columns);
		
		if($module == 'company')
		{
			$cols[] = "broker_name";
			$cols[] = "mobile1_no";
			$cols[] = "pan_card_num";
			$cols[] = "broker_id";
			$cols[] = "email";
		}
		if($module == 'interaction_report')
		{
			$cols[] = "broker_name";
			
		}	
	
	
		$sql_or = array(); 
		$sql_alpha = array(); /*sort alpha */
		for($k=0; $k<count($cols); $k++)
		{
			if($module == 'company' && ($cols[$k] == 'broker_name' || $cols[$k] == 'mobile1_no' || $cols[$k] == 'pan_card_num' || $cols[$k] == 'broker_id' || $cols[$k] == 'email'))
			{
					$col = "broker.".$cols[$k];
			}
			else if( ($module == "customer"|| $module == "owner" ) && ( $cols[$k]=="f_name" || $cols[$k]=="l_name"))
			{
				$col = ' CONCAT(f_name," ",l_name) ';
			}
			else
			{
				$col = $cols[$k];
			}
			$sql_or[] = " ".$col." LIKE '%".addslashes(addslashes($_GET['keyword']))."%' ";
			//print_R($sql_or); 
			//$sql_or[] = " ".$col." LIKE '%".addslashes(addslashes($_GET['keyword']))."%' ";
		}
		$newsql = "( ".implode(" OR", $sql_or)." ) ";
		$ssql .= "and ". $newsql ;
		//$ssql .= " and ".$_GET['search_option']." like '%".addslashes(addslashes($_GET['keyword']))."%' ";	

	}
  if($module == 'broker' && isset($_REQUEST['firm_id']))
  {
   $ssql .= " AND firm_id = '".$_REQUEST['firm_id']."' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&firm_id=".$_REQUEST['firm_id'];
  }
  if($module == 'property' && isset($_REQUEST['customer_id']))
  {
   $ssql .= " AND client_property_id = '".$_REQUEST['customer_id']."' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&customer_id=".$_REQUEST['customer_id'];
  }
   if($module == 'owner_property' && isset($_REQUEST['customer_id']))
  {
   $ssql .= " AND broker_owner_id = '".$_REQUEST['customer_id']."' AND flag='owner' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&owner_id=".$_REQUEST['customer_id'];
  }
   if($module == 'broker_property' && isset($_REQUEST['broker_id']))
  {
   $ssql .= " AND broker_owner_id = '".$_REQUEST['broker_id']."' AND flag!='owner' ";
   $modulearray[$module]['addlink'] = $modulearray[$module]['addlink']."&owner_id=".$_REQUEST['customer_id'];
  }
  
  if($module == 'short_list')
  {
	   if($_SESSION['admin_level'] == 1)
	   	$ssql .= " AND active = 1";
	   else
	   	$ssql .= " AND active = 1 AND pp_executive_id=".$_SESSION['user_id'];
   
  }
?>