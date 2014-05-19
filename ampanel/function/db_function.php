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
function am_insertupdate($data,$table,$pid='',$id='')
{

	$sql = '';
	if($id == '')
	{
		$key_arr = @implode(",",array_keys($data));
		$val_arr = @implode("','",array_values($data));
	 	 $sql = "insert  into ".$table." ( ".$key_arr." ) values ('".$val_arr."' )";
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
function am_enum_select( $table , $field ){ 
        $query = " SHOW COLUMNS FROM ".$table." LIKE '".$field."' "; 
        $result = mysql_query( $query ) or die( 'error getting enum field ' . mysql_error() ); 
        $row = mysql_fetch_array( $result , MYSQL_NUM ); 
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
