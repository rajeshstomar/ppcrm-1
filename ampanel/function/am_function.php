<?php
/**
 * @Author Nimit Dudani
 * @copyright Copyright 2003-2007 Alakmalak Development Team
 * @copyright Portions Copyright 2008-2009 AM
 * @license for company use only
 */
function am_get_current_template()
{
	return 'templates/'.$_SESSION['template_name'].'/';
}
function am_get_current_language()
{
	return 'language/'.$_SESSION['language_name'].'/';
}
function am_randomLoginToken($length) 
{
    srand(date("s"));
    $possible_charactors = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";
    while(strlen($string)<$length) 
	{
        $string .= substr($possible_charactors, rand()%strlen($possible_charactors),1);
    }
    return($string);
}
function am_create_link($pageName,$extra='')
{
	return FILENAME_INDEX_HOME.'.php?rel='.$pageName.($extra=='' ? '' : '&'.$extra);
}
function am_create_popup_link($pageName,$extra='')
{
	return FILENAME_INDEX_POPUPHOME.'.php?rel='.$pageName.($extra=='' ? '' : '&'.$extra);
}
function am_goto_page($url)
{
	echo "<script language='javascript'>document.location='".$url."';</script>";
} 

function am_set_search_to_all_fields($tableName,$operator,$seachStr)
{
	$query = "SELECT * FROM ".$tableName." ";
	$result = mysql_query($query);
	$returnStr='';
	for ($i = 0; $i < mysql_num_fields($result); ++$i)
	{
    	$table = mysql_field_table($result, $i);
	    $field = mysql_field_name($result, $i);
		$returnStr .= $field . " like '%".$seachStr."%' ".$operator." ";
    	//echo  "$table: $field\n";
	}
	$returnStr .= $field . " like '%".$seachStr."%'  ";
	
	return $returnStr;
}

//             ******* Message Functions  Start *******
function add_to_message_stack($type,$number,$message)
{
	if(isset($_SESSION['am_message_stack']))
	{
		$message_pass=$_SESSION['am_message_stack'];
		$message_body=array($type,$number,$message);
		$message_pass[]=$message_body;
	}
	else
	{
		$message_body=array($type,$number,$message);
		$message_pass[]= $message_body ;
	}
	$_SESSION['am_message_stack']=$message_pass;
}
function show_message_stack()
{
	if(isset($_SESSION['am_message_stack']))
	{
		foreach($_SESSION['am_message_stack'] as $msgarray)
		{
			echo '<table width="50%" height="30"  cellspacing="0" cellpadding="0" style="border:solid;border-width:1px;border-color:#00CC33;background:#BFFFA8;margin-bottom:3px;"><tr><td width="50" align="center">'.$msgarray[0].'</td><td>'.$msgarray[2].'</td></tr></table>';
		}
	}
	else
	{
		echo '<table width="50%"  height="30" cellspacing="0" cellpadding="0" style="border:solid;border-width:1px;border-color:#FF0000;margin-bottom:3px;"><tr><td align="center">No Imformation/Error/Warning message seted at this moment!!</td></tr></table>';
	}
}
function is_message_in_stack()
{
	return isset($_SESSION['am_message_stack']);
}
function clear_message_stack()
{
	session_unregister('am_message_stack');
}
//             ******* Message Functions  End *******
function create_list_with_array($listArray,$selectValue)
{
	$returnValue='';
	foreach($listArray as  $value )
	{
	$returnValue.= '<option value="'.$value.'" '.($value == $selectValue ? ' selected ' : '' ).' >'.$value.'</option>';
	}
	return $returnValue;
}
function create_list_with_countries($selectValue)
{
	$query = "SELECT * FROM ".TABLE_COUNTRIES." order by countries_name";
	$result = mysql_query($query);
	$returnValue='<option value="0" '.( '0' == $selectValue ? ' selected ' : '' ).' >Please Select</option>';
	while($row=mysql_fetch_array($result))
	{
		$returnValue.= '<option value="'.$row['countries_id'].'" '.($row['countries_id'] == $selectValue ? ' selected ' : '' ).' >'.$row['countries_name'].'</option>';
	}
	return $returnValue;
}
function create_list_with_states($countriesId,$selectValue)
{
	$query = "SELECT * FROM ".TABLE_STATES." where state_country_id = '".$countriesId."' order by state_name";
	$result = mysql_query($query);
	$returnValue='<option value="0" '.( '0' == $selectValue ? ' selected ' : '' ).' >Please Select</option>';
	while($row=mysql_fetch_array($result))
	{
		$returnValue.= '<option value="'.$row['state_id'].'" '.($row['state_id'] == $selectValue ? ' selected ' : '' ).' >'.$row['state_name'].'</option>';
	}
	return $returnValue;
}

function am_fetch_category($cat_id,$par_id){

	$sql = "SELECT * FROM ".TABLE_CATEGORIES;
	$result = mysql_query($sql);
	$returnval = '<option value="0" '.( $par_id == '0' ? ' selected ' : '' ).' >Select Category</option>';
	while($row= mysql_fetch_array($result)){
	
$returnval .= '<option value="'.$row['categories_id'].'" '.($row['categories_id']== $par_id? 'selected': '').'>'.$row['name'].'</option>';
	}
	
	return $returnval;
}

function am_get_firm($company_id)
{
	
	//echo "SELECT * FROM broker_firm ";
	 $sql = "SELECT * FROM broker_firm ";
	$result = mysql_query($sql);
	
	while($row= mysql_fetch_array($result)){
	//print_R($row);exit;
$returnval .= '<option value="'.$row['company_id'].'" '.($row['company_id']== $company_id? 'selected': '').'>'.$row['company_name'].'</option>';
	}
	
	return $returnval;
}



function img_scale($source,$width,$height,$extra='border=0')
{

	$w=$width;
	$h=$height;
	if (!file_exists($source)) {
      $src = '';
    }
	$size = @getimagesize($source); 
	if($w > $size[0] && $h > $size[1] )
	{
		$neww = $size[0];//$w;
		$newh = $size[1];//$h;
	}
	else if( $w < $size[0] && $h > $size[0] )
	{
		$diff=$size[0]-$w;
		$dec_per=(100*$diff)/$size[0];
		$neww=$size[0]-(($size[0]*$dec_per)/100);
		$newh=$size[1]-(($size[1]*$dec_per)/100);
	}
	else if( $w > $size[0] && $h < $size[0] )
	{
		$diff=$size[1]-$h;
		$dec_per=(100*$diff)/$size[1];
		$newh=$size[1]-(($size[1]*$dec_per)/100);
		$neww=$size[0]-(($size[0]*$dec_per)/100);
	}
	else//( $w < $size[0] && $h < $size[0] )
	{
		if( ($size[0]-$w) >= ($size[1]-$h))
		{
			$diff=$size[0]-$w;
			$dec_per=(100*$diff)/$size[0];
			$neww=$size[0]-(($size[0]*$dec_per)/100);
			$newh=$size[1]-(($size[1]*$dec_per)/100);
			$cc='w';
		}
		else
		{
			$diff=$size[1]-$h;
			$dec_per=(100*$diff)/$size[1];
			$newh=$size[1]-(($size[1]*$dec_per)/100);
			$neww=$size[0]-(($size[0]*$dec_per)/100);
			$cc='h';					
		}
	}
	return "<img src='".$source."' width='".$neww."' height='".$newh."'  ".$extra." >";
}
function imageupload($photopath,$vphoto,$vphoto_name,$prefix)
{ 
	//echo $photopath."--".$vphoto."--".$vphoto_name."--".$prefix; exit;
	$msg='';	
	if(is_file($vphoto) and !empty($vphoto_name))
	{
		// Remove Dots from File name
		$tmp=explode(".",$vphoto_name);


		for($i=0;$i<count($tmp)-1;$i++)
		{
			$tmp1[]=$tmp[$i];
		}
		$file=implode("_",$tmp1);
		$ext=$tmp[count($tmp)-1];
				
		$vlfname = $file.".".$ext;
		//--------------------------
		
		if($ext =="pdf" || $ext =="PDF" || $ext =="docx" || $ext =="doc" || $ext =="DOC" || $ext =="DOCX"  )
		{
			$vphotofile=$prefix.$file."_".date("YmdHis").".".$ext;
			$ftppath1 = $photopath.$vphotofile;
				if(!copy($vphoto, $ftppath1))
				{
					$vphotofile = '';
					$msg=rawurlencode("Image Not Uploaded Successfully !!");
				}
				else
				{ 
					$msg=rawurlencode("Image Uploaded Successfully !!");
				} 
		}
		else
		{
			$vphotofile = '';
			$msg="Image Type Is Not Valid !!!";
		}
	}
	$ret[0] = $vphotofile;
	$ret[1] = $msg;
	
	return $ret; 
}

/******************functin am_fetch_customer **************************

************************************************************************/
/*
function am_fetch_customer($product_id){

	$sql = "SELECT customer_id FROM ".TABLE_PRODUCTS_TO_CUSTOMER." WHERE product_id= '".$product_id."'";
	$data = mysql_query($sql);
	$strCustomer = Array();	
	while($result = mysql_fetch_array($data,MYSQL_ASSOC))
	{
	  $strCustomer[] = $result['customer_id'];
	}
	
	$sql = "SELECT * FROM ".TABLE_TRAINERS;
	$result = mysql_query($sql);

	if(!(isset($_REQUEST['RefrenceID'])) && !empty($_REQUEST['RefrenceID']))
	{
	   $select_text = 'selected';
	}

	$returnval = '<option value="0" '.$select_text.' >Select Customer</option>';

	while($row= mysql_fetch_array($result))
	{
		$returnval.= '<option value="'.$row['trainerId'].'" '.(in_array($row['trainerId'],$strCustomer) ? ' selected ' : '' ).' >'.$row['trainerFirstName'].'</option>';

	}
	
	return $returnval;
}*/

function am_fetch_customer($product_id,$link_id = ''){

		if(isset($link_id) && !empty($link_id))
		{
			$cust_sql = "SELECT customer_id FROM ".TABLE_ZOHO_LINKS_TO_CUSTOMER." WHERE link_id= '".$link_id."'";
			$data 	     = mysql_query($cust_sql);
			$strCustomer = Array();	
			while($result = mysql_fetch_array($data,MYSQL_ASSOC))
			{
			  $strCustomer[] = $result['customer_id'];
			}
		
		}
		elseif(isset($product_id))
		{

			$sql = "SELECT customer_id FROM ".TABLE_PRODUCTS_TO_CUSTOMER." WHERE product_id= '".$product_id."'";
			$data = mysql_query($sql);
			$strCustomer = Array();	
			while($result = mysql_fetch_array($data,MYSQL_ASSOC))
			{
			  $strCustomer[] = $result['customer_id'];
			}
		}

		$sql 	= "SELECT * FROM ".TABLE_TRAINERS;
		$result = mysql_query($sql);

		if(!(isset($_REQUEST['RefrenceID'])) && !empty($_REQUEST['RefrenceID']))
		{
		   $select_text = 'selected';
		}

		$returnval = '<option value="0" '.$select_text.' >Select Customer</option>';

		while($row= mysql_fetch_array($result))
		{
			$returnval.= '<option value="'.$row['trainerId'].'" '.(in_array($row['trainerId'],$strCustomer) ? ' selected ' : '' ).' >'.$row['trainerFirstName'].'</option>';

		}

		return $returnval;


}





/***********************************************************************/
function am_fetch_category_for_products($prod_id,$cat_id){

	$sql = "SELECT * FROM ".TABLE_CATEGORIES;
	$result = mysql_query($sql);
	$returnval = '<option value="0" selected >Select Category</option>';
	
	while($row = mysql_fetch_array($result))
	{
	
		$returnval .= '<option value="'.$row['categories_id'].'"'.($row['categories_id']== $cat_id? 'selected': '').'>'.$row['name'].'</option>';
	}
	
	return $returnval;
}
function get_cat_name($cat_id){

	$sql = "SELECT * FROM ".TABLE_CATEGORIES. " WHERE categories_id= '".$cat_id."'";
	$result = mysql_query($sql);
	
	$data = mysql_fetch_array($result);

	return $data['name'];
	
}

function get_apartment_type($prop_id){

	$sql = "SELECT onerk FROM property_requirement WHERE broker_property_id= '".$prop_id."'";
	$result = mysql_query($sql);
	$data = mysql_fetch_array($result);
	
	if($data['onerk']==1)
	{
		$apartment='1RK';
        }	
        else if($data['onerk']==2)
	{
		$apartment='1BHK';
	}
	else if($data['onerk']==3)
	{
		$apartment='2BHK';
	}
	else if($data['onerk']==4)
	{
		$apartment='3BHK';
	}
	else if($data['onerk']==5)
	{
		$apartment='4BHK+';
	}	
		
	//print_R($data);
	return $apartment;
	
}


/*Function to select multiple customer */
function am_fetch_multiple_customer($portfolio_id){

		
		if(isset($portfolio_id))
		{

			$sql = "SELECT customer_id FROM ".TABLE_CUSTOMER_TO_PORTFOLIO." WHERE portfolio_id= '".$portfolio_id."'";
			$data = mysql_query($sql);
			$strCustomer = Array();	
			while($result = mysql_fetch_array($data,MYSQL_ASSOC))
			{
			  $strCustomer[] = $result['customer_id'];
			}
		}

		$sql 	= "SELECT * FROM ".TABLE_REGISTRATION;
		$result = mysql_query($sql);

		if(!(isset($_REQUEST['RefrenceID'])) && !empty($_REQUEST['RefrenceID']))
		{
		   $select_text = 'selected';
		}

		$returnval = '<option value="0" '.$select_text.' >Select Customer</option>';

		while($row= mysql_fetch_array($result))
		{
			$returnval.= '<option value="'.$row['registration_id'].'" '.(in_array($row['registration_id'],$strCustomer) ? ' selected ' : '' ).' >'.$row['name'].'</option>';

		}

		return $returnval;

}

/* added by mitesh */

function encrypt($sData, $sKey='mysecretkey'){ 
    $sResult = ''; 
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) + ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return base64_encode($sResult); 
} 

function decrypt($sData, $sKey='jamesBOND'){ 
    $sResult = ''; 
    $sData   = base64_decode(base64_decode($sData)); 
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) - ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return $sResult; 
}

function get_fieldarray()
{

	$fieldarr = array();
	
	
				
	/*$fieldarr['customer'] = array (	"primaryid"=>"client_id",
					"editlink" => "index.php?&rel=edit_customer&id=",
					"addlink" => "index.php?&rel=edit_customer",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("client_id","ID","left","25","Y",""),array("date","Date","left","22","Y",""),array("place","Place","left","22","Y",""),array("f_name","First Name","left","22","Y",""),array("l_name","Last Name","left","22","Y",""),array("country","Country","left","22","Y",""),array("state","State","left","22","Y",""),array("add_line1","Address  line 1","left","22","Y",""),array("add_line2","Address  line 2","left","22","Y",""),array("add_line3","Address  line 3","left","22","Y",""),array("zip_code","Zip Code","left","22","Y",""),array("city","City","left","22","Y",""),array("mobile","Mobile","left","22","Y",""),array("office","Office","left","22","Y",""),array("email1","E-mail1","left","22","Y",""),array("email2","E-mail2","left","22","Y",""),array("calls_noti","calls_noti","left","22","Y",""),array("sms_noti","sms_noti","left","22","Y",""),array("email_noti","email_noti","left","22","Y",""),array("remark","Remark","left","22","Y","")),
				                        "tablename" => "client_personal_details",
				                        "orderby" => "client_id"
				                        
				
				); */
	## commented by Rajesh old array			
	/*$fieldarr['company'] = array("primaryid"=>"company_id",
					"editlink" => "index.php?&rel=edit_company&mode=view&id=",
					"addlink" => "index.php?&rel=edit_company",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
					"fieldarr" => array(array("company_name","Company/Firm Name","left","20","Y",""),
										array("nature_company","Nature Of Company","left","19","Y",""),
										array("place","Outlet Location","left","16","Y",""),
										array("company_id","No Of Memebr Broker","left","23","Y","broker_count"),
										array("company_id","Listing Done","left","23","Y","listing_count"),
										array("company_id","Broker Details","left","20","N","broker_action")),
											  "leftjoin" => " left join broker as b on broker_firm.company_id=b.firm_id ",
				                              "lastfield" => "Firm Details",
				                              "tablename" => "broker_firm",
				                              "orderby" => "company_id"
				  	            ); */
	## new Array defined as per requirment for listing of broker.  //Rajesh
	$fieldarr['company'] = array(
					"primaryid"=>"broker_id",
					"editlink" => "index.php?&rel=edit_company&mode=view&id=",
					"addlink" => "index.php?&rel=edit_company",
					"fieldarr" => array(array("broker_name","Broker Name","left","10","Y",""),
										array("company_name","Firm Name","left","10","Y",""),
										array("mobile1_no","Mobile No","left","15","Y",""),
										array("email","Email ID","left","15","Y",""),
										array("pan_card_num","Pan Card No","left","15","Y","",'','N'),
										array("broker_id","Listings","left","6","Y","broker_property",'listing_count'),
										array("CONCAT(pr.add_line1,' ',pr.add_line2,' ',pr.add_line3)","Address","left","17","N",""),
										array("broker_id","Broker Details","left","20","N","broker_action_for_company_module",'no_sorting','N'),
										array("company_id","","","","N","")
										),

				/* "leftjoin" => " left join broker_firm as broker_firm on broker_firm.company_id=broker.firm_id ",*/
				  "leftjoin" => " LEFT JOIN broker AS broker ON broker.firm_id = broker_firm.company_id  AND broker.is_active =1 LEFT JOIN property_requirement AS pr ON pr.broker_owner_id = broker.broker_id and pr.is_active = 1 ",
				  "lastfield" => "Firm Details",
				  "tablename" => "broker_firm",
				  "orderby" => "company_id",
				  "rowsCountBy"=>"company_name",
				  "foRrunTimeTableName"=>"broker",
				  "groupByFieldName"=>"GROUP BY broker_firm.company_id"
				  	            );			  	
	$fieldarr['broker'] = array ("primaryid"=>"broker_id",
					"editlink" => "index.php?&rel=edit_broker&id=",
					"addlink" => "index.php?&rel=edit_broker",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
					"fieldarr" => array(array("broker_id","Broker ID","left","17","Y",""),
										array("broker_name","Broker Name","left","22","Y",""),
										array("mobile1_no","Mobile No","left","22","Y",""),
										array("email","Email ID","left","22","Y",""),
										array("pan_card_num","Pan Card No","left","22","Y",""),
										array("broker_id","Property Action","left","39","N","broker_property")),
										"tablename" => "broker",
										"orderby" => "broker_id"
								); 
				
	$fieldarr['customer'] = array (	"primaryid"=>"client_id",
					"editlink" => "index.php?&rel=view_customer&id=",
					"addlink" => "index.php?&rel=edit_customer",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("client_id","Customer ID","left","16","Y",""),
								                        	array("CONCAT(f_name,' ',l_name)","Customer Name","left","30","Y",""),
								                        	array("mobile_no","Mobile No","left","10","Y",""),
								                        	array("email1","Email ID","left","16","Y",""),
								                        	array("client_id","Property Action","left","39","N","customer_property"),
								                        	array("client_id","Days Old in System","left","30","N","days_old")),
				                       "leftjoin" => "inner join client_property on client_personal_details.client_id=client_property.client_property_id", 
				                        "tablename" => "client_personal_details",
				                        "orderby" => "client_id"
				  	);
				  	
	$fieldarr['owner'] = array (	"primaryid"=>"client_id",
					"editlink" => "index.php?&rel=view_owner&id=",
					"addlink" => "index.php?&rel=edit_owner",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("client_id","Owner ID","left","6","Y",""),
								                        	array("CONCAT(f_name,' ',l_name)","Owner Name","left","9","Y",""),
								                        	array("mobile_no","Mobile No","left","10","Y",""),
								                        	array("email1","Email ID","left","16","Y",""),
								                        	array("client_id","Listings","left","9","N","owner_property"),
								                        	array("CONCAT(pr.add_line1,' ',pr.add_line2,' ',pr.add_line3)","Address","left","17","N",""),
								                        	array("client_id","Days Old in System","left","10","N","days_old")),
				                       "leftjoin" => "left join property_requirement as pr on client_personal_details.client_id=pr.broker_owner_id", 
				                        "tablename" => "client_personal_details",
				                        "orderby" => "client_id"
				  	);				  	
				  	
	$fieldarr['property'] = array (	"primaryid"=>"property_id",
					"editlink" => "index.php?&rel=view_property&id=",
					"addlink" => "index.php?&rel=edit_property",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("property_id","ID","left","8","Y",""),array("main_property_type","Type","left","10","Y",""),array("property_type","Property Type","left","20","Y",""),array("scaleble","Area (SQFT)","left","15","Y",""),array("min_price","Min Price/Rent","left","18","Y",""),array("max_price","Max Price/Rent","left","18","Y",""),array("property_id","Property Match","left","22","Y","property_match"),array("CONCAT(client_property_id,',',property_id)","Short Listed","left","22","N","short_list_match"),array("property_id","Status","left","22","Y","get_customer_lead_status")),
				                        
				                        "tablename" => "client_property",
				                        "orderby" => "property_id"
				  	);
				  	
	$fieldarr['owner_property'] = array (	"primaryid"=>"broker_property_id",
					"editlink" => "index.php?&rel=view_owner_property&id=",
					"addlink" => "index.php?&rel=edit_owner_property",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("broker_property_id","ID","left","25","Y",""),array("trans_type","Type","left","22","Y",""),array("property_main_type","Property Type","left","22","Y",""),array("broker_property_id","Apartment Type","left","22","Y","get_apartment_type"),array("scaleble","Area(SQFT)","left","22","Y",""),array("add_line3","Area","left","22","Y",""),array("price","Price / Rent","left","22","Y",""),array("broker_property_id","Interested Customer","left","22","Y","am_get_interested_cust")),
				                        
				                        "tablename" => "property_requirement",
				                        "orderby" => "broker_property_id"
				  	);
				  	
	
/*$fieldarr['broker_property'] = array (	"primaryid"=>"broker_property_id",
					"editlink" => "index.php?&rel=view_owner_property&id=",
					"addlink" => "index.php?&rel=edit_owner_property",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
					"fieldarr" => array(array("broker_property_id","ID","left","25","Y",""),
										array("trans_type","Type","left","22","Y",""),
										array("property_main_type","Property Type","left","22","Y",""),
										array("broker_property_id","Apartment Type","left","22","Y","get_apartment_type"),
										array("scaleble","Area(SQFT)","left","22","Y",""),
										array("add_line3","Area","left","22","Y",""),
										array("price","Price / Rent","left","22","Y",""),
										array("broker_property_id","Interested Customer","left","22","Y","am_get_interested_cust")),
										
					"tablename" => "property_requirement",
					"orderby" => "broker_property_id"

);	*/ 

$fieldarr['broker_property'] = array (	"primaryid"=>"broker_property_id",
					"editlink" => "index.php?&rel=view_owner_property&id=",
					"addlink" => "index.php?&rel=edit_owner_property",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
					"fieldarr" => array(
array("broker_property_id","ID","left","25","Y",""),
						array("trans_type","Type","left","22","Y",""),
										array("property_main_type","Property Type","left","22","Y",""),
										array("broker_property_id","Apartment Type","left","22","Y","get_apartment_type"),
										array("scaleble","Area(sq ft)","left","22","Y",""),
										array("add_line3","Area","left","22","Y",""),
										array("price","Price / Rent","left","22","Y",""),
										array("broker_property_id","Interested Customer","left","22","Y","am_get_interested_cust")),
										
					"tablename" => "property_requirement",
					"orderby" => "broker_property_id"

); 	
			
				  	
	$fieldarr['site_visit_report'] = array (	"primaryid"=>"visit_id",
					"editlink" => "index.php?&rel=view_site_visit_report&id=",
					"addlink" => "index.php?&rel=edit_site_visit_report",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("visit_id","ID","left","25","Y",""),array("report_date","Site Visit Date","left","22","Y",""),array("property_id","Listing Id","left","22","Y",""),array("client_name","Client Name","left","22","Y",""),array("client_comment","Feedback","left","22","Y","")),
				                        "tablename" => "site_visit_report",
				                        "orderby" => "visit_id"
				  	); 
	$fieldarr['interaction_report'] = array (	"primaryid"=>"broker_property_id",
					"editlink" => "index.php?&rel=view_interaction_report&id=",
					"addlink" => "index.php?&rel=edit_interaction_report",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("broker_property_id","Listing ID","left","8","Y",""),array("type","Type (direct/in-direct)","left","22","Y",""),array("broker_name","Owner/Broker Name","left","22","N",""),array("pan_or_mobile","Mobile No","left","22","Y",""),array("trans_type","Transaction(Sell/Rent)","left","22","Y",""),array("price","expected Price/Rent Per month ","left","22","Y",""),array("broker_property_id","Interested Customer","left","22","Y","am_get_interested_cust")),
				                        "leftjoin" => "left join broker on broker.broker_id=property_requirement.broker_owner_id", 
				                        "tablename" => "property_requirement",
				                        "orderby" => "broker_property_id"
				  	); 	
	$fieldarr['sales_team_rating'] = array (	"primaryid"=>"rating_id",
					"editlink" => "index.php?&rel=edit_sales_team_rating&id=",
					"addlink" => "index.php?&rel=edit_sales_team_rating",
				// array("field name","Heading", alignment","width","display in  serach","function name" )
				                        "fieldarr" => array(array("rating_id","ID","left","25","Y",""),array("rating_date","Date","left","22","Y","")),
				                        "tablename" => "sales_team_rating",
				                        "orderby" => "rating_id"
				  	); 
				
				
	$fieldarr['outlet_location'] = array (	"primaryid"=>"out_loc_id",
					"editlink" => "index.php?&rel=edit_outlet_location&id=",
					"addlink" => "index.php?&rel=edit_outlet_location",
				                        "fieldarr" => array(array("out_loc_id","ID","left","50","Y",""),array("location_name","Location Name","left","50","Y","")),
				                        "tablename" => "outlat_loacation",
				                        "orderby" => "out_loc_id"
				                        
				
				);
				
	$fieldarr['user_management'] = array (	"primaryid"=>"admin_id",
					"editlink" => "index.php?&rel=edit_user_management&id=",
					"addlink" => "index.php?&rel=edit_user_management",
				                        "fieldarr" => array(array("admin_id","ID","left","25","Y",""),array("admin_f_name","FirstName","left","25","Y",""),array("admin_l_name","Last Name","left","25","Y",""),array("admin_name","Usre Name","left","25","Y",""),array("admin_email","Usre Email","left","25","Y",""),array("admin_id","Role","left","25","Y","admin_type")),
				                        "tablename" => "admin",
				                        "orderby" => "admin_id"
				                        
				
				);
	$fieldarr['short_list'] = array (	"primaryid"=>"id_shortlist",
					"editlink" => "index.php?&rel=edit_short_list&id_shortlist=",
					//"addlink" => "index.php?&rel=edit_user_management",
		                        "fieldarr" => array(
		                        
		                        //array("id_shortlist","ID","left","25","Y",""),
		                        array("CONCAT(f_name,' ',l_name,',',customer_id)","Customer Name","left","12","Y","am_get_cust_link"),
		                        array("mobile_no","Mobile","left","10","Y",""),
		                        //array("email1","Email","left","12","Y",""),
		                        array("admin_name","Assigned To","left","8","Y",""),
		                        array("status_name","Lead Status","left","20","Y",""),
		                        array("description","Description","left","25","Y","am_short_desc"),
		                        array("next_call_date","Call Date","left","15","Y","am_date_format"),
		                        array("CONCAT(client_req_prop_id,',',customer_id)","link","left","10","Y","am_get_prop_link")
		                        
		                        ),
		                        
		                        "leftjoin" => " LEFT JOIN client_personal_details as cp ON cp.client_id = short_listed_prop.customer_id LEFT JOIN admin as a ON short_listed_prop.pp_executive_id = a.admin_id LEFT JOIN shortlist_status as ss ON ss.status_id = short_listed_prop.status_id",
		                        "tablename" => "short_listed_prop",
		                        "orderby" => "id_shortlist DESC"
				                        
				
				);
	$fieldarr['call_log'] = array (	"primaryid"=>"id_call_log",
					"editlink" => "index.php?&rel=edit_call_log&id_call_log=",
					"addlink" => "index.php?&rel=edit_call_log_search",
		                        "fieldarr" => array(
		                        
		                        //array("id_shortlist","ID","left","25","Y",""),
		                        array("caller_name","Caller Name","left","12","Y",""),
		                        array("caller_phone","Phone","left","10","Y",""),
		                        array("caller_type_name","Caller Type","left","25","Y",""),
		                        array("call_category","Category","left","8","Y",""),
		                        array("priority","Priority","left","8","Y",""),
		                        array("next_call_date","Date","left","15","Y","am_date_format"),
		                        array("CONCAT(id_broker_customer,',',next_call_date,',',user_is,',',shortlist_id)","Log","left","10","N","users_log"),
					),
		                        
		                        "leftjoin" => " LEFT JOIN caller_type as ct ON ct.id_caller_type=call_log.caller_type",
		                        "tablename" => "call_log",
		                        "orderby" => "next_call_date ASC"
				                        
				
				);
	$fieldarr['other_call_log'] = array ("primaryid"=>"id_call_log",
					"editlink" => "index.php?&rel=edit_call_log&id_call_log=",
					"addlink" => "index.php?&rel=edit_call_log_search",
		                        "fieldarr" => array(
		                        
		                        //array("id_shortlist","ID","left","25","Y",""),
		                        array("caller_name","Caller Name","left","12","Y",""),
		                        array("caller_phone","Phone","left","10","Y",""),
		                        array("caller_type_name","Caller Type","left","25","Y",""),
		                        array("call_category","Category","left","8","Y",""),
		                        array("priority","Priority","left","8","Y",""),
		                        array("next_call_date","Date","left","15","Y","am_date_format"),
					),
		                        
		                        "leftjoin" => " LEFT JOIN caller_type as ct ON ct.id_caller_type=call_log.caller_type",
		                        "tablename" => "call_log",
		                        "orderby" => "id_call_log DESC"
				                        
				
				);
	$fieldarr['log'] = array ("primaryid"=>"log_id",
					"editlink" => "index.php?&rel=view_log_detail&log_id=",
					//"addlink" => "index.php?&rel=edit_prop_list",
				                        "fieldarr" => array(
				                        //array("prop_photo","Photo","left","10","Y","get_image"),
				                        array("date","Date","left","15","Y","date_convert"),
				                        array("table_name","Table Name","left","15","Y",""),
				                        array("ip","IP Add","left","15","Y",""),
				                        array("csv_path","File","left","25","Y","download_csv"),
				                        
				                        ),
				                        "tablename" => "log",
				                        "orderby" => "log_id DESC",
				                                              
				                        				
				);
	
  return $fieldarr;
}
function am_display($str)
{
	return htmlentities(stripslashes($str));
}
/* end code by mitesh */

function get_country_options($selected_id)
{
	$country_html = "";
	$sql = "select countries_id, countries_name from countries ";
	$country_data = am_select($sql);
	for($i=0,$ni=count($country_data);$i<$ni;$i++)
	{
		if($country_data[$i]['countries_id'] == $selected_id)
			$selected = "selected";
		else
			$selected = "";
		$country_html .= "<option ".$selected." value='".$country_data[$i]['countries_id']."'>".$country_data[$i]['countries_name']."</option>";
	}
	return $country_html;
}

function get_country_name($country_id='')
{
	$sql = "select countries_name from countries where countries_id = '".$country_id."' ";
	$country_data = am_select($sql);
	return $country_data[0]['countries_name'];
}

function get_states_options($selected_id)
{
	$country_html = "";
	$sql = "select StateID, StateName from states";
	$country_data = am_select($sql);
	for($i=0,$ni=count($country_data);$i<$ni;$i++)
	{
		if($country_data[$i]['StateID'] == $selected_id)
			$selected = "selected";
		else
			$selected = "";
		$country_html .= "<option ".$selected." value=".$country_data[$i]['StateID'].">".$country_data[$i]['StateName']."</option>";
	}
	return $country_html;
}

function get_outlet_location_options($selected_id)
{
	
	$location_html = "";
	$sql = "select out_loc_id, location_name from outlat_loacation";
	$location_data = am_select($sql);
	for($i=0,$ni=count($location_data);$i<$ni;$i++)
	{
		if($location_data[$i]['location_name'] == $selected_id)
			$selected = "selected";
		else
			$selected = "";
		$location_html .= "<option ".$selected." value=".$location_data[$i]['location_name'].">".$location_data[$i]['location_name']."</option>";
	}
	return $location_html;
}


function get_states_name($selected_id)
{
	$country_html = "";
	$sql = "select StateID, StateName from states WHERE StateID = '".$selected_id."'";
	$country_data = am_select($sql);
	for($i=0,$ni=count($country_data);$i<$ni;$i++)
	{
		$country_html .= $country_data[$i]['StateName'];
	}
	return $country_html;
}




function am_get_day_options($selval='')
{
	$content = "";
	for($i=0;$i<32;$i++)
	{
		if($selval == number_pad($i,2))
			$selected= "selected";
		else
			$selected= "";
		$content .= "<option ".$selected." value='".number_pad($i,2)."'>".number_pad($i,2)."</option>";
	}
	return $content;
}

function am_get_month_options($selval='')
{
	$content = "";
	for($i=1;$i<13;$i++)
	{
		if($selval == number_pad($i,2))
			$selected= "selected";
		else
			$selected= "";
		$content .= "<option ".$selected." value='".number_pad($i,2)."'>".number_pad($i,2)."</option>";
	}
	return $content;
}


function am_get_year_options($range,$start="",$selval='')
{
	if($start == "")
		$start=date('Y');
	$range = $range+$start; 
	$content = "";
	for($i=$start;$i<=$range;$i++)
	{
		if($selval == $i)
			$selected= "selected";
		else
			$selected= "";
		$content .= "<option ".$selected." value='".$i."'>".$i."</option>";
	}
	return $content;
}

function am_get_minute_options($selval='')
{
	$content = "";
	for($i=0;$i<60;$i++)
	{
		if($selval == number_pad($i,2))
			$selected= "selected";
		else
			$selected= "";
		$content .= "<option  ".$selected." value='".number_pad($i,2)."'>".number_pad($i,2)."</option>";
	}
	return $content;
}

function am_get_hour_options($selval='')
{
	
	
	for($i=0;$i<24;$i++)
	{
		if($selval == number_pad($i,2))
			
			$selected= "selected";
			
		else
			$selected= "";
		$content .= "<option ".$selected." value='".number_pad($i,2)."'>".number_pad($i,2)."</option>";
	}
	return $content;
}
function am_get_years($selval='')
{
	
	
	for($i=1;$i<=100;$i++)
	{
		if($selval == $i)
			
			$selected= "selected";
			
		else
			$selected= "";
		$content .= "<option ".$selected." value='".$i."'>".$i."</option>";
	}
	return $content;
}

function number_pad($number,$n)
{
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}

function am_make_price($price)
{
	$price = str_replace(".00","",$price);
	if($price == "")
		$price = "0";
	return "$".$price;
}

function am_float_to_int($price)
{
	$price = str_replace(".00","",$price);
	if($price == "")
		$price = "0";
	return $price;
}

function am_get_date_display($text)
{
	$timestamp = strtotime($text);
	$f_date = date('m/d/Y h:i a',$timestamp);
	return $f_date;
}
function am_get_business_name($id)
{
	$que = "select business_name from business where business_id = $id";
	$res = am_select($que);
	
	return $res[0]["business_name"];
}

function am_get_system_datetime()
{  
	return date('Y-m-d H:i:s');
}

function am_get_admin_date_display($text)
{
	$timestamp = strtotime($text);
	$f_date = date('m/d/Y',$timestamp);
	return $f_date;
}

function broker_action($firm_id)
{
	$html = '';
	// Count Brokers for each firm
	$broker = "SELECT broker_id, broker_name FROM broker WHERE firm_id = '".$firm_id."' ";
	$broker_res = am_select($broker);
	$broker_count = count($broker_res);
	if($broker_count > 0)
		$link_text = "Edit";		
	else
		$link_text = "Add";
	if($broker_count > 0) 
	{	
	$html .= "<span><a href='index.php?rel=common_listing&module=broker&firm_id=".$firm_id."' >View</a></span>&nbsp;&nbsp;&nbsp;";
	}
	$html .= "<span><a href='index.php?rel=edit_broker&firm_id=".$firm_id."' >".$link_text."</a></span>";
	return $html;
}

function broker_count($firm_id)
{
	$html = '';
	// Count Brokers for each firm
	$broker = "SELECT broker_id, broker_name FROM broker WHERE firm_id = '".$firm_id."' ";
	$broker_res = am_select($broker);
	$broker_count = count($broker_res);
	
	
	$html .= $broker_count;
	return $html;
}


function listing_count($firm_id)
{
	$html = '';
	// Count Brokers for each firm
	$broker = "SELECT broker_id, broker_name FROM broker WHERE firm_id = '".$firm_id."' ";

	$broker = "select broker_property_id from property_requirement as pr left join broker as br on pr.broker_owner_id=br.broker_id  left join broker_firm as bf on bf.company_id=br.firm_id where bf.company_id='".$firm_id."' and pr.flag!='owner'   ";

	$broker_res = am_select($broker);
	$broker_count = count($broker_res);
	
	
	$html .= $broker_count;
	return $html;
}



function admin_type($admin_id)
{
	$html = '';
	// Count Brokers for each firm
	$admin = "SELECT role FROM admin WHERE admin_id = '".$admin_id."' ";
	$admin_res = am_select($admin);
	
	if($admin_res[0]['role']=='admin')
	{
		$html="Admin";
	}
	else if($admin_res[0]['role']=='manager')
	{
		$html="Manager";
	}
	else if($admin_res[0]['role']=='executive')
	{
		$html="Executive";
	}
	return $html;
}


function customer_property($customer_id)
{
	$html = '';
	// Count Brokers for each firm
	$prop = "SELECT property_id FROM client_property WHERE client_property_id = '".$customer_id."' ";
	$prop_res = am_select($prop);
	$prop_count = count($prop_res);
	
	
	
	
	
	$html .= "<span><a href='index.php?rel=common_listing&module=property&customer_id=".$customer_id."' >Require (".$prop_count.")</span>";
	
	
	return $html;
}

function owner_property($customer_id)
{
	$html = '';
	// Count Brokers for each firm
	
	
	
	$req = "SELECT broker_owner_id FROM property_requirement WHERE broker_owner_id = '".$customer_id."' and flag='owner' ";
	$prop_req = am_select($req);
	$prop_req_count = count($prop_req);
	
	
	
	$html .= "<span><a href='index.php?rel=common_listing&module=owner_property&customer_id=".$customer_id."' >".$prop_req_count."</a></span>&nbsp;&nbsp;&nbsp;";
	
	return $html;
}


function broker_property($customer_id)
{
	$html = '';
	if($customer_id > 0)
	{
	// Count Brokers for each firm
		$req = "SELECT COUNT(broker_owner_id) AS totalListing FROM property_requirement WHERE is_active=1 AND broker_owner_id = '".$customer_id."' and ( flag='brokerdirect' || flag='indirect' ) ";
		$prop_req = am_select($req);
		$prop_req_count = $prop_req[0]['totalListing'];

		$query_update = mysql_query("UPDATE broker SET listing_count =".$prop_req_count." where is_active=1 AND broker_id = ".$customer_id);
		//$prop_req = am_select($query_update);
		
		$req_listing_Id = "SELECT listing_count FROM broker WHERE is_active=1 AND broker_id = ".$customer_id;
		$res_listing_Id = am_select($req_listing_Id);
		$html .= "<span><a href='index.php?rel=common_listing&module=broker_property&broker_id=".$customer_id."' target='_blank' >".$res_listing_Id[0]['listing_count']."</a></span>&nbsp;&nbsp;&nbsp;";
    }
    else
    {
    	$html .= "<span>-</span>&nbsp;&nbsp;&nbsp;";
    }

	
	
	return $html;
}



function days_old($customer_id)
{
	$html = '';
	// Count Brokers for each firm
	$prop = "SELECT client_created_date FROM client_personal_details WHERE client_id = '".$customer_id."' ";
	$prop_res = am_select($prop);
	
	//print_R($prop_res);exit;
	 $prop_res[0]['client_created_date']."<br/>";
	 $date=strtotime($prop_res[0]['client_created_date']);
 	
	
	$dStart = strtotime($prop_res[0]['client_created_date']);
	 $dEnd = strtotime(date('Y-m-d'));
	$dDiff = abs($dEnd - $dStart);
	
	
	$years = floor($dDiff / (365*60*60*24));
	$months = floor(($dDiff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($dDiff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	
	$html .= "<span>".$days."Days</span>&nbsp;&nbsp;&nbsp;";
	
	return $html;
}



function property_match($property_id)
{
	$sql = "SELECT cp.* FROM client_property as cp WHERE property_id = '".$property_id."' ";
	$prop_res = am_select($sql);
	//print_R($prop_res); exit;


	$where = array();

	$where[] = " property_main_type = '".$prop_res[0]['property_type']."' ";

	$areas = "SELECT area_name,area_id FROM client_area WHERE property_area_id = '".$property_id."' ";
	$area = am_select($areas);
	$area_q = array();
	for($k=0;$k<count($area);$k++)
	{
		if($area[$k]['area_name'] !='')
			$area_q[] = " add_line3 LIKE '%".$area[$k]['area_name']."%' ";
	}
	if(!empty($area_q))
	{
		$where[] = " ( ".implode(" OR",$area_q)." ) ";
	}

	if($prop_res[0]['property_type'] == 'residential')
	{
		$bhk = array();
		if($prop_res[0]['onerk'] == 1)
			$bhk[] = " onerk = 1 ";
		if($prop_res[0]['onebhk'] == 1)
			$bhk[] = " onerk = 2 ";
		if($prop_res[0]['twobhk'] == 1)
			$bhk[] = " onerk = 3 ";
		if($prop_res[0]['threebhk'] == 1)
			$bhk[] = " onerk = 4 ";
		if($prop_res[0]['fourbhk'] == 1)
			$bhk[] = " onerk = 5 ";
	}
	if(!empty($bhk))
	{
		$where[] = " ( ".implode(' OR',$bhk)." ) ";
	}

	if($prop_res[0]['main_property_type'] == 'rent')
	{
		$where[] = " ( trans_type = '".$prop_res[0]['main_property_type']."' OR trans_type = '".$prop_res[0]['main_property_type']."_out' ) ";
	}
	if($prop_res[0]['main_property_type'] == 'buy')
	{
		$where[] = " trans_type = 'sell' ";
	}
	if($prop_res[0]['scaleble'] != '')
	{	
		$area = $prop_res[0]['scaleble'];
		$min = $area - ( $area*0.3 );
		$max = $area + ( $area*0.3 );
		$where[] = " ( scaleble >= $min AND scaleble <= $max ) ";
	}
	if($prop_res[0]['min_price'] != '' && $prop_res[0]['max_price'] != '')
	{	
		$min_price = $prop_res[0]['min_price'];
		$max_price = $prop_res[0]['max_price'];
		$where[] = " ( price >= $min_price AND price <= $max_price) ";
	}
	if($prop_res[0]['furnished'] != '0')
	{	
		$where[] = " furnished = '".$prop_res[0]['furnished']."' ";
	}
	if($prop_res[0]['warm_cell'] != '0')
	{	
		$where[] = " warm_cell = '".$prop_res[0]['warm_cell']."' ";
	}
	//print_r($where); exit;
	$match_query = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id left join broker as bk on pr.broker_owner_id=bk.broker_id  WHERE ".implode('AND',$where)." order by pr.price ASC,bk.broker_category DESC ";

	$match_query_new = "SELECT bd.id_building,bd.b_name, pr.* FROM property_requirement as pr LEFT JOIN building_database as bd ON bd.id_building = pr.near_building_id WHERE ".implode('AND',$where)." order by pr.price ";

	//echo "<br>".$match_query;

	$match_res = am_select($match_query);
	$count = '';
	if(count($match_res) > 0)
	{
		$count = '('.count($match_res).')';
		$link = "<a href='index.php?rel=matching_property&customer_id=".$prop_res[0]['client_property_id']."&propery_id=".$property_id."' >View ".$count."</a>";
	}
	else
	{
		$link = "No Match";
	}
	
	$html = '';
	$html .= "<span>".$link."</span>";
	return $html; 
}

function short_list_match($field)
{
	$params = @explode(',',$field);
	$cust_id = $params[0];
	$prop_id = $params[1];
	$ssql = '';
	if($_SESSION['admin_level'] != 1)
	   	$ssql .= " AND pp_executive_id=".$_SESSION['user_id'];
	
	$sql = "SELECT `id_shortlist`,`customer_id`, `property_listing_id`, `client_req_prop_id` FROM short_listed_prop WHERE active=1 AND customer_id=".$cust_id." AND client_req_prop_id =".$prop_id." ".$ssql." GROUP BY property_listing_id" ;
	$short_res = am_select($sql);
	//print_R($short_res); exit;
	
	if(count($short_res) > 0)
	{
		$count = '('.count($short_res).')';
		$link = "<a href='index.php?rel=short_list_property&customer_id=".$short_res[0]['customer_id']."&client_req_prop_id=".$short_res[0]['client_req_prop_id']."' >View ".$count."</a>";
	}
	else
	{
		$link = "No Match";
	}
	$html = '';
	$html .= "<span>".$link."</span>";
	return $html;
	
}

function getStrBet($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}


function get_firm_name($id)
{
	//echo "SELECT company_name FROM broker_firm  WHERE company_id=".$id;exit;
	 $firm_query = "SELECT company_name FROM broker_firm  WHERE company_id=".$id;
	$firm_name = am_select($firm_query);	
	//print_R($firm_name);exit;	
	$name=$firm_name[0]['company_name'];
	
	return $name;
}
function get_lead_status($id)
{
	//echo "SELECT company_name FROM broker_firm  WHERE company_id=".$id;exit;
	$status_query = "SELECT * FROM shortlist_status WHERE status_id=".$id;
	$status_name = am_select($status_query);	
	//print_R($firm_name);exit;	
	$name=$status_name[0]['status_name'];
	
	return $name;
}
function get_customer_lead_status($id)
{
	//echo "SELECT company_name FROM broker_firm  WHERE company_id=".$id;exit;
	$status_query = "SELECT status FROM client_property WHERE property_id=".$id;
	$status_name = am_select($status_query);	
	//print_R($status_name);exit;	
	$name=$status_name[0]['status'];
	if($name==1)
	{
		$name1='New';
	}
	else if($name==2)
	{
		$name1='Information awaited from broker/owner';
	}
	else if($name==3)
	{
		$name1='Contacted – Answered';
	}
	else if($name==4)
	{
		$name1='Contacted – Un-Answered';
	}
	else if($name==5)
	{
		$name1='Follow-up';
	}
	else if($name==6)
	{
		$name1='Property Details Shared';
	}
	else if($name==7)
	{
		$name1='Property Shortlisted';
	}
	else if($name==8)
	{
		$name1='Property disqualified';
	}
	else if($name==9)
	{
		$name1='Request for more options';
	}
	else if($name==10)
	{
		$name1='Site Visit Planned';
	}
	else if($name==11)
	{
		$name1='Site Visit Rescheduled';
	}
	else if($name==12)
	{
		$name1='Site Visit Done';
	}
	else if($name==13)
	{
		$name1='Site Re-Visit';
	}
	else if($name==14)
	{
		$name1='Owner/Broker Meeting Scheduled';
	}
	else if($name==15)
	{
		$name1='Negotiation';
	}
	else if($name==16)
	{
		$name1='Token Given';
	}
	else if($name==17)
	{
		$name1='Registration/Agreement Status';
	}
	else if($name==18)
	{
		$name1='Transaction Successful';
	}
	else if($name==19)
	{
		$name1='Lead Dead';
	}

	return $name1;
}


function get_price_encrypt($value1,$value2)
{
	$value2=(int)$value2;
	if($value1=='thousand')
	{
		 $min_price1=$value2.'000';
	}
	else if($value1=='laks')
	{
		$min_price1=$value2.'00000';	
	}
	else if($value1=='crores')
	{
		$min_price1=$value2.'0000000';	
	}

	return $min_price1;

}
function am_date_format($date)
{
	return date("d-m-Y", strtotime($date));
}
function am_get_select($table , $primary_id, $select_name= '', $selected_id= '', $column_value='', $sort_by='' , $where )
{
	// Table Name, Primary Key, DropDown Name, Selected Option, Values Of select, Sort by
	$sql = "SELECT ".$primary_id.",".$column_value." FROM ".$table." ";
	if($where )
		$ssql = " WHERE ".implode(" AND ", $where);
	if($sort_by != '')
		$ssql .= " ORDER BY ".$sort_by;
	$sql .= $ssql;
	//echo $sql;
	$result = am_select($sql);
	$select = '<select name="'.$select_name.'" id="'.$select_name.'" >';
	$column_name = explode('_' , $column_value );
	//print_R($column_name); exit;
	$c_name = implode (' ', $column_name);
	if($table=='admin')
		$c_name = "Executive";
	$select .= '<option value="" > Select '.ucfirst($c_name) . '</option>';
	for($i=0, $j=count($result);$i<$j;$i++)
	{
		$selected = '';
		if($result[$i][$primary_id] == $selected_id )
			$selected = 'selected = "selected"';
		$select .= '<option value="'.$result[$i][$primary_id].'" '.$selected.' >'. $result[$i][$column_value] . '</option>';
		
	}
	$select .= "</select>";
	
	return $select;
}
function am_short_desc($desc)
{
	return substr($desc, 0,20)."...";
}
function am_get_prop_link($field)
{
	$fields = @explode(',',$field);

	$link = "<a href='index.php?&rel=view_property&id=".$fields[0]."&customer_id=".$fields[1]."' target='_blank'>R</a>";
	
	$html = '';
	$html .= "<span>".$link."</span>";
	
	return $html;
}
function am_get_cust_link($field)
{
	$fields = @explode(',',$field);
	//print_R($fields); exit;
	
	$link = "<a href='index.php?rel=common_listing&module=property&customer_id=".$fields[1]."' target='_blank'>".$fields[0]."</a>";
	
	$html = '';
	$html .= "<span>".$link."</span>";
	
	return $html;
	
}

function am_get_executive_name($id)
{
	$status_query = "SELECT admin_f_name,admin_l_name FROM admin WHERE admin_id=".$id;
	$status_name = am_select($status_query);
	
	
	$html='';
	$html .=$status_name[0]['admin_f_name']." ".$status_name[0]['admin_l_name'];	
	
	return $html;
	
}
function am_get_interested_cust($prop_id)
{
	$link = "<a href='index.php?rel=interested_customer&prop_id=".$prop_id."' >View</a>";
	
	$html = '';
	$html .= "<span>".$link."</span>";
	
	return $html;
}

function singledigit($number){
    
 switch($number){
            case 0:$word = "zero";break;
            case 1:$word = "One";break;
            case 2:$word = "two";break;
            case 3:$word = "three";break;
            case 4:$word = "Four";break;
            case 5:$word = "Five";break;
            case 6:$word = "Six";break;
            case 7:$word = "Seven";break;
            case 8:$word = "Eight";break;
            case 9:$word = "Nine";break;
        }
        return $word;
    }
 
    function doubledigitnumber($number){
        if($number == 0){
            $word = "";
        }
        else{
            $word = singledigit($number);
        }       
        return $word;
	
    }
	
    function doubledigit($number){
        switch($number[0]){
            case 0:$word = doubledigitnumber($number[1]);break;
            case 1:
                switch($number[1]){
                    case 0:$word = "Ten";break;
                    case 1:$word = "Eleven";break;
                    case 2:$word = "Twelve";break;
                    case 3:$word = "Thirteen";break;
                    case 4:$word = "Fourteen";break;
                    case 5:$word = "Fifteen";break;
                    case 6:$word = "Sixteen";break;
                    case 7:$word = "Seventeen";break;
                    case 8:$word = "Eighteen";break;
                    case 9:$word = "Ninteen";break;
                }break;
            case 2:$word = "Twenty".doubledigitnumber($number[1]);break;                
            case 3:$word = "Thirty".doubledigitnumber($number[1]);break;
            case 4:$word = "Forty".doubledigitnumber($number[1]);break;
            case 5:$word = "Fifty".doubledigitnumber($number[1]);break;
            case 6:$word = "Sixty".doubledigitnumber($number[1]);break;
            case 7:$word = "Seventy".doubledigitnumber($number[1]);break;
            case 8:$word = "Eighty".doubledigitnumber($number[1]);break;
            case 9:$word = "Ninety".doubledigitnumber($number[1]);break;

        }
	
        return $word;
    }

    function unitdigit($numberlen,$number){
        switch($numberlen){         
            case 3:$word = "Hundred";break;
            case 4:$word = "Thousand";break;
            case 5:$word = "Thousand";break;
            case 6:$word = "Lakh";break;
            case 7:$word = "Lakh";break;
            case 8:$word = "Crore";break;
            case 9:$word = "Crore";break;

        }
        return $word;
    }

    function numberToWord($number){
        $numberlength = strlen($number);
        if ($numberlength == 1) { 
            return singledigit($number);
        }elseif ($numberlength == 2) {
            return doubledigit($number);
        }
        else {

            $word = "";
            $wordin = "";

            if($numberlength == 9){
                if($number[0] >0){
                    $unitdigit = unitdigit($numberlength,$number[0]);
                    $word = doubledigit($number[0].$number[1]) ." ".$unitdigit." ";
                    return $word." ".numberToWord(substr($number,2));
                }
                else{
                    return $word." ".numberToWord(substr($number,1));
                }
            }

            if($numberlength == 7){
                if($number[0] >0){
                    $unitdigit = unitdigit($numberlength,$number[0]);
                    $word = doubledigit($number[0].$number[1]) ." ".$unitdigit." ";
                    return $word." ".numberToWord(substr($number,2));
                }
                else{
                    return $word." ".numberToWord(substr($number,1));
                }

            }

            if($numberlength == 5){
                if($number[0] >0){
                    $unitdigit = unitdigit($numberlength,$number[0]);
                    $word = doubledigit($number[0].$number[1]) ." ".$unitdigit." ";
                    return $word." ".numberToWord(substr($number,2));
                }
                else{
                    return $word." ".numberToWord(substr($number,1));
                }


            }
            else{
                if($number[0] >0){
                    $unitdigit = unitdigit($numberlength,$number[0]);
                    $word = singledigit($number[0]) ." ".$unitdigit." ";
                }               
                return $word." ".numberToWord(substr($number,1));
            }
        }
    }


function users_log($fields)
{
	$field = @explode(",",$fields);
	$id_broker_customer = $field[0];
	$next_call_date = $field[1];
	$user_is = $field[2];
	$shortlist_id = $field[3];
	$ssql = '';
	if($_SESSION['admin_level'] != 1)
	   	$ssql .= " AND pp_executive_id=".$_SESSION['user_id'];
	
	$sql = "SELECT *,COUNT(*) as tot FROM call_log WHERE next_call_date ='".$next_call_date."' AND id_broker_customer ='".$id_broker_customer."' AND user_is ='".$user_is."' ".$ssql;
	
	$res = am_select($sql);
	
	$link = "index.php?rel=common_listing&module=call_log&id_bc=".$id_broker_customer."&user=".$user_is."&date=".$next_call_date."&shortlist_id=".$shortlist_id;
	
	$text = "View (".$res[0]['tot'].")";
	
	$html = '';
	$html .= '<span><a href="'.$link.'">'.$text.'</a></span>';
	
	return $html;
}

function create_log($table_name, $csv_path, $message){
	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set('Asia/Calcutta');
 	$date = date("Y-m-d H:i:s");
 	
 	$insert_log = "INSERT INTO `log`(`table_name`, `date`, `msg`, `ip`, `csv_path`) VALUES ('".$table_name."','".$date."','".addslashes($message)."','".$ip."','".$csv_path."')";
 	$res = mysql_query($insert_log);
	
}
function cut_string_using_last($character, $string, $side, $keep_character=true) { 
    $offset = ($keep_character ? 1 : 0); 
    $whole_length = strlen($string); 
    $right_length = (strlen(strrchr($string, $character)) - 1); 
    $left_length = ($whole_length - $right_length - 1); 
    switch($side) { 
        case 'left': 
            $piece = substr($string, 0, ($left_length + $offset)); 
            break; 
        case 'right': 
            $start = (0 - ($right_length + $offset)); 
            $piece = substr($string, $start); 
            break; 
        default: 
            $piece = false; 
            break; 
    } 
    return($piece); 
}
function date_convert($date){
	return date("d-m-Y H:i:s", strtotime($date) );
}
function download_csv($csv){
	$name = str_replace("/", "", cut_string_using_last('/', $csv, 'right', true));
	//echo $name; exit;
	return '<a href="'.HTTP_ROOT_HOME."uploads/".$name.'">'.$name.'</a>';
}
function broker_action_for_company_module($broker_id)
{
	$html = '';
	// Count Brokers for each firm
	/*$broker = "SELECT broker_id, broker_name FROM broker WHERE firm_id = '".$firm_id."' ";
	$broker_res = am_select($broker);
	$broker_count = count($broker_res);*/
	$link_text = "Edit";
	/*if($broker_count > 0)
		$link_text = "Edit";		
	else
		$link_text = "Add";*/
	/*if($broker_count > 0) 
	{	
	$html .= "<span><a href='index.php?rel=common_listing&module=broker&firm_id=".$firm_id."' >View</a></span>&nbsp;&nbsp;&nbsp;";
	}*/
	$html .= "<span><a href='index.php?rel=edit_broker&id=".$broker_id."' target='_blank'>".$link_text."</a></span>";
	return $html;
}
?>