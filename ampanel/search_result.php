<?php
require('includes/script_top.php');
$where = $_REQUEST['where'];
$table_name = $_REQUEST['table_name'];
//echo $table_name;
$leftjoin = '';
$ssql = '';
if($where != '')
	$ssql .= " AND flag='".$where."'";
$key = $_REQUEST['col_name']; 
$cols = explode(',',$key);
if($table_name == 'broker_firm')     // Table and query name changed broker_firm to broker.:- Rajesh
{
	$cols[] = "broker_name";
	$cols[] = "mobile1_no";
	$cols[] = "pan_card_num";
	$cols[] = "broker_id";
	$cols[] = "email";	
	$leftjoin .= "LEFT JOIN broker AS broker ON broker.firm_id = broker_firm.company_id  AND broker.is_active =1";
}

if($table_name == 'property_requirement')
{
	$cols[] = "broker_name";
	$leftjoin .= " LEFT JOIN broker as b ON b.broker_id = property_requirement.broker_owner_id";
}


//print_R($cols); exit;
$datas = array();
for($k=0; $k<count($cols); $k++)
{
	$col = $cols[$k];
	
	if($cols[$k] == 'broker_name' || $cols[$k] == 'mobile1_no' || $cols[$k] == 'pan_card_num' || $cols[$k] == 'broker_id' || $cols[$k] == 'email' )
	{
		$sel = $col;
	}
	else if($table_name == "client_personal_details" && ($cols[$k]=="f_name" || $cols[$k]=="l_name") )
	{
		$sel = ' CONCAT(f_name," ",l_name) ';
		$col = $sel;
	}
	else
	{
		$sel = $col;
	}
	$data = "SELECT ".$sel." as col_name FROM ".$table_name." ".$leftjoin." WHERE ".$col." LIKE '%".$_REQUEST['term']."%' ".$ssql;
	//echo "<br>".$data;exit;
	$data_res = am_select($data);
	if(!empty($data_res))
		$datas[] = $data_res;
}
//print_R($datas); 
//$data_res = am_select($data);
$search_array = array();

for($i=0;$i<count($datas);$i++)
{
	for($l=0;$l<count($datas[$i]);$l++)
	{
		$search_array[] = $datas[$i][$l]['col_name'];
	}
}
//print_R($search_array); exit;
/*for($i=0;$i<count($data_res);$i++)
{
	$search_array[] = $data_res[$i][$_REQUEST['col_name']];
}*/
echo json_encode(array_unique($search_array));
//$res = '['.implode(',',array_unique($search_array)).']';
//echo $res;
?>
