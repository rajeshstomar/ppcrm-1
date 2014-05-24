<?php
/**
 * @Author Nimit Dudani
 * @copyright Copyright 2003-2007 Alakmalak Development Team
 * @copyright Portions Copyright 2008-2009 AM
 * @license for company use only
 */

//echo "<pre>";print_r($_POST);
//echo get_magic_quotes_gpc();
if (!get_magic_quotes_gpc()) {
    function addslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('addslashes_deep', $value) :
                    addslashes($value);

        return $value;
    }

    $_POST = array_map('addslashes_deep', $_POST);
    $_GET = array_map('addslashes_deep', $_GET);
    $_COOKIE = array_map('addslashes_deep', $_COOKIE);
    $_REQUEST = array_map('addslashes_deep', $_REQUEST);
}


if (file_exists('includes/configure.php'))
{
  require('includes/configure.php');
}
else
{
 	echo "Configuration file not found";
	exit;
}
$_SESSION['template_name']='default_am';
$_SESSION['language_name']='english';

require('includes/function.php');
require('includes/database_tables.php');
require('includes/filenames.php');
require_once("csspagination/CSSPagination.class.php");
//include_once("../fckeditor/fckeditor.php") ;

$cn = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
if (!$cn) {    die('Not connected : ' . mysql_error()); }

// make connection to the current db
$db_selected = mysql_select_db(DB_DATABASE, $cn);
if (!$db_selected) { die ('Can\'t use '.DB_DATABASE.' : ' . mysql_error()); }

// get customers unique IP that paypal does not touch
$customers_ip_address = $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION['user_ip_address'])) 
{
  $_SESSION['user_ip_address'] = "127.0.0.1";
}

// all array

$statusArray=array( 'ACTIVE' , 'DEACTIVE');
$sectionArray=array( 'No Section' , 'Key Engineering Staff');

$projectArray=array( 'Development Projects' , 'Residential Projects' , 'Commercial Projects' , 'Hotel and Resort Projects' , 'Industrial Projects', 'Marine Projects' , 'Subdivision Projects' );

/* advanced search for company/firm's broker array fields  */

$refineSearch_company =array( "broker_name" => "Name" , "company_name" => "Firm Name" , "mobile" => "Mobile", "area"=>"Area", "sector"=>"Sector", "category"=>"Category" , "email"=> "Email" , "pan_card_num"=> "Pan Card No", "pin_code"=> "Pin Code", "address"=> "Address");

/* advanced search for company/firm's broker array fields  */
$refineSearch_customer =array( "client_id" => "ID","customer_name" => "Name" , "mobile_no" => "Mobile","email"=> "Email");

?>