<?php
/**
 * @Author Nimit Dudani
 * @copyright Copyright 2003-2007 Alakmalak Development Team
 * @copyright Portions Copyright 2008-2009 AM
 * @license for company use only
 */


function set_order(&$temp)
{

	$ar = array();
	$ar2 = array();
	foreach($temp as $t)
	{
		$cat_id = $t["category_id"];
		
		$num = get_num_child($cat_id);
		
	//	echo $t["category_id"]."  ".$num;
		if($num == 0)
		{
			array_push($ar , $t);
			
			
		}
		else
		{
			array_push($ar2 , $t);	 
			
			
		}
	}

$temp = array_merge($ar2 ,$ar);


}

function get_num_child($cat_id)
{
	$que = "select count(*) as num from category where parent_id = $cat_id";
	$ar = am_select($que);

	return $ar[0]["num"];

}
 
function get_category_checkboxes($id="0",$content='',$selectValues=array())
{

	global $content;

	

/*	print "<pre>";

	print_r($selectValues);

*/	


  
	if(!is_array($selectValues))

		$selectValues=array();

		

	$sql = "SELECT category_id, parent_id, category_name FROM category where parent_id = '".$id."' and status='Active' ";

	$cat_data = am_select($sql);

	
	 set_order($cat_data);

	for($i=0,$ni=count($cat_data);$i<$ni;$i++)

	{

	   $x = 1;

		if((($i%$x)==0 && $i != 0) || ($i == ($ni)))

			$content .= "</div>";

		

			

		if($cat_data[$i]['parent_id'] == "0"){

			$content .= "<div class='cat_parent' style='float:left;clear:both1;' >";
			$b = 1;
			$onclick = " onclick='showchild(this.checked, ".$cat_data[$i]['category_id'].");' ";
		}

		else if(($i%$x)==0){

			$content .= "<div style='float:left; width:150px' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";		
			$b = 0;
			}

		else
		{		
			$b = 0;
			$content .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

		}	

			if(in_array($cat_data[$i]['category_id'],$selectValues))

				$checked = 'checked';

			else

				$checked = '';

				

		$content .= "<input type='checkbox' ".$onclick." class='child_".$cat_data[$i]['parent_id']."' title='".$cat_data[$i]['category_name']."' ".$checked." name='catid[]' value='".$cat_data[$i]['category_id']."' id='catid_".$cat_data[$i]['category_id']."' >&nbsp;";
		
		if($b == 1){
		$content .="<label for='catid_".$cat_data[$i]['category_id']."' ><strong>".$cat_data[$i]['category_name']."</strong></label>";
		}
		else {
		$content .="<label for='catid_".$cat_data[$i]['category_id']."' >".$cat_data[$i]['category_name']."</label>";
		}
		

    if($cat_data[$i]['parent_id'] == "0")

			$content .= "<br>";  

		

    	if(($i == ($ni-1)))

			$content .= "</div>";	

			

		get_category_checkboxes($cat_data[$i]['category_id'],$content,$selectValues);

		

   	if($cat_data[$i]['parent_id'] == "0")

			$content .= "</div>";

		

	}

	return $content;

}

function am_get_business_logo($photo, $height="60", $width="180", $extra="")
{	
	
	if(is_file(DIR_BUSINESS_LOGO.$photo) && $photo != "")
	{
		$ret_img = "<img src='".BUSINESS_LOGO_URL.$photo."'  name='myphoto' height='".$height."' width='".$width."' ".$extra." />";
	}	
	else
	{
		$ret_img = "<img src='".BUSINESS_LOGO_URL."nophoto.jpg' name='myphoto' height='".$height."' width='".$width."' ".$extra." />";
	}
//		$ret_img = "<img src='../user_photoes/nophoto.jpg' height='".$height."' width='".$width."' ".$extra." />";
	return $ret_img;
}


function am_get_user_photo($photo, $hieght="100", $width="103", $extra="")
{
	if(is_file(DIR_USER_PHOTOS.$photo) && $photo != "")
	{
		$ret_img = "<img src='".USER_PHOTOS_URL.$photo."' height='".$hieght."' width='".$width."' ".$extra." />";
	}	
	else
	{
		$ret_img = "<img src='".USER_PHOTOS_URL."nophoto.jpg' height='".$height."' width='".$width."' ".$extra." />";
	}
//		$ret_img = "<img src='../user_photoes/nophoto.jpg' height='".$height."' width='".$width."' ".$extra." />";
	return $ret_img;
}

function am_get_business_payable_value($price, $disc)
{
	$price = ($price * $disc)/100;
	//$price = am_make_price($price);
	return $price;                        
}

function am_get_unpaid_amount($id)
{
  $sql = "select sum(td.deal_price) as tot, b.buisness_percentage from deal_transaction as td left join deals as d on td.deal_id=d.deal_id left join business as b on d.business_id=b.business_id where td.status != 'Failure' and td.business_paid = 'No' and b.business_id='".$id."'  group by b.business_id ";
  
  $transaction_data = am_select($sql);
  //echo $transaction_data[0]['tot']; 
  $ret_val =  am_get_business_payable_value($transaction_data[0]['tot'],$transaction_data[0]['buisness_percentage']);
  return am_make_price($ret_val);
}

?>
