<?php
if($module == 'call_log' || $module == 'other_call_log')
  {
  	if($_SESSION['admin_level'] != 1)
	   	$ssql .= " AND pp_executive_id=".$_SESSION['user_id'];
	   	
  	if($_REQUEST['user_is'] != '' && $_REQUEST['id'] != '')
    	{
    		$ssql .= " AND id_broker_customer=".$_REQUEST['id']." AND user_is='".$_REQUEST['user_is']."' ";
    	}
    	else if($_REQUEST['id_customer'] !='' && $_REQUEST['shortlist_id'] !='')
    	{
    		$ssql .= " AND id_broker_customer=".$_REQUEST['id_customer']." AND user_is='customer' AND shortlist_id=".$_REQUEST['shortlist_id']." AND is_shortlisted='yes'";
    	}
    	
    	if($module == 'call_log')
    	{
    		if(isset($_REQUEST['id_bc']) && isset($_REQUEST['user']) && isset($_REQUEST['date']) )
    		{
    			$ssql .= " AND next_call_date ='".$_REQUEST['date']."' AND id_broker_customer ='".$_REQUEST['id_bc']."' AND user_is ='".$_REQUEST['user']."'";
    		}
    		else
    		{
    			$groupby .= " GROUP BY id_broker_customer,next_call_date,user_is";
    		}
    		$ssql .= " AND is_shortlisted = 'yes'" ;
    	}
  }  
?>