<?php
/**
 * @Author Mitesh Chauhan
 * @copyright Copyright 2003-2007 Alakmalak Development Team
 * @copyright Portions Copyright 2008-2009 AM
 * @license for company use only
 */
function am_query($sql)
{
	$result = mysql_query($sql);
	if (mysql_errno()) { 
		echo $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br><font color='red'>\n$sql\n</font><br>"; 
		exit;
	} 
	return $result;
}
function am_select($sql)
{
	$result = mysql_query($sql);
	if (mysql_errno()) { 
		echo $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br><font color='red'>\n$sql\n</font><br>"; 
		exit;
	}
	$data = array();
	$cnt=0;
	while($row=mysql_fetch_assoc($result))
	{
		foreach ($row as $key => $value)
		{		
			$row[$key] = am_display($value);
	
		}
//		my_print_r($row);
		$data[$cnt] = $row;
		$cnt++;
	}
	return $data;
}
function am_select_assoc($sql,$assockey)
{
	$result = mysql_query($sql);
	if (mysql_errno()) { 
		echo $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br><font color='red'>\n$sql\n</font><br>"; 
		exit;
	} 
	$data = array();
	while($row=mysql_fetch_assoc($result))
	{
		foreach ($row as $key => $value)
		{		
			$row[$key] = stripslashes($value);
	
		}
//		my_print_r($row);
		$data[$row[$assockey]][] = $row;
	}
	return $data;
}
function am_insertupdate($data,$table,$pid='',$id='',$latlong='')
{

	$sql = '';
	if($id == '')
	{	
		$key_arr = @implode(",",array_keys($data));
		$val_arr = @implode("','",array_values($data));
		if($latlong){
			$sql = "insert  into ".$table." ( ".$key_arr.",latlong ) values ('".$val_arr."', GeomFromText('".$latlong."') )";
		}else{
	 	 	$sql = "insert  into ".$table." ( ".$key_arr." ) values ('".$val_arr."' )";
	 	}
		$result = mysql_query($sql);
		if (mysql_errno()) { 
			echo $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br><font color='red'>\n$sql\n</font><br>"; 
			exit;
		} 	
		else
		{
			return mysql_insert_id();
		}		
	}
	else
	{
		$sql = "update ".$table." set ";
		//echo $sql; exit;
		foreach ($data as $key => $value)
		{		
			$sql .= $key."='".$value."',";
	
		}
		$sql = substr($sql,0,-1);
		$sql .= " where ".$pid." = '".$id."' ";
		$result = mysql_query($sql);
		if (mysql_errno()) { 
			echo $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br><font color='red'>\n$sql\n</font><br>"; 
			exit;
		}
	}

}
function am_insertupdate_client_requirement($data, $table,$pid='',$id=''){
	$main_property_type = $data['main_property_type'];
	$property_type = $data['property_type'];
	$onerk = $data['onerk'];
	$onebhk = $data['onebhk'];
	$twobhk = $data['twobhk'];
	$threebhk = $data['threebhk'];
	$fourbhk = $data['fourbhk+'];
			
	$specify_area = $data['specify_area'];
	$scaleble = $data['scaleble'];
	$carpet = $data['carpet'];
	$office = $data['office'];
			//'retail' = $data['retail'];
	$furnished = $data['furnished'];
			//'unfurnished' = $data['unfurnished'];
	$warm_cell = $data['warm_cell'];
	$state 	= $data['state'];
	$city 	= $data['city'];
	$locality 	= $data['locality'];
	$sector 	= $data['sector'];
	$near_building 	= $data['near_building'];
	$is_choice_flex 	= $data['is_choice_flex'];
	$flex_pref 	= $data['flex_pref'];
	$flex_distance 	= $data['flex_distance'];
	$latlong		= $data['latlong'];
			//'cold_cell' = $data['cold_cell'];
	$min_price = $data['min_price'];
	$max_price = $data['max_price'];
	$status = $data['status'];
	$client_pro_created_date = $data['client_pro_created_date'];
	if($id == ''){
		$client_property_id = $data['client_property_id'];

		$key_arr = @implode(",",array_keys($data));

		$sql = "INSERT INTO ".$table." ( ".$key_arr." ) values ('". $main_property_type ."', '".$property_type."', '".$onerk."', '".$onebhk."', '".$twobhk."', '".$threebhk."', '".$fourbhk."', '".$specify_area."', '".$scaleble."', '".$carpet."', '".$office."', '".$furnished."', '".$warm_cell."', '".$state."', '".$city."', '".$locality."', '".$sector."', '".$near_building."', '".$is_choice_flex."', '".$flex_pref."', '".$flex_distance."', GeomFromText('".$latlong."'), '".$min_price."', '".$max_price."', '".$status."', '".$client_pro_created_date."', '".$client_property_id."' )";
		$query = mysql_query($sql) or die($sql.'<br/>'.mysql_error());
	}else{

	}
}
function am_enum_select( $table , $field ){ 
        $query = " SHOW COLUMNS FROM ".$table." LIKE '".$field."' "; 
        $result = mysql_query( $query ) or die( 'error getting enum field ' . mysql_error() ); 
        $row = mysql_fetch_array( $result , mysql_NUM ); 
        $regex = "/'(.*?)'/"; 
        //$regex = "/'[^"\\\r\n]*(\\.[^"\\\r\n]*)*'/"; 
        preg_match_all( $regex , $row[1], $enum_array ); 
        $enum_fields = $enum_array[1]; 
        return( $enum_fields ); 
}
function my_print_r($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
?>
