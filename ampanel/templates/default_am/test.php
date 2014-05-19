<?php
$url = "http://www.pmilimited.com/xml/pmiNew.xml";
$xml = simplexml_load_file($url);
$item = $xml->Wholesale->Items->Item;

//$final = $item->Item;
//print_R($final); exit;
foreach($item as $v)
{
	echo $v->Metal."<br>";
}
exit;
?>

