<?php if($_GET['module'] == 'company') { ?>
   
  <td colspan="8"><h2>Firm's Broker Details</h2></td>
  
  
   <?php } else if($_GET['module'] == 'broker')  { ?>
    <td colspan="8"><h2>Details Of Member Broker For <?php echo get_firm_name($_GET['firm_id']); ?> </h2></td>
    <?php } else if($_GET['module'] == 'customer')  { 
    
    ?>
     <td colspan="8"><h2 style="margin:5px 0;">Customer Details</h2></td>
       <?php } else if($_GET['module'] == 'owner_property')  { ?>
     <td colspan="8"><h2>Owner Property Listing</h2>
     <?php include("customer_detail.php");?>
     </td>
     
      <?php } else if($_GET['module'] == 'broker_property')  { ?>
     <td colspan="8"><h2>Broker Property Listing</h2>
     <?php include("broker_detail.php");?>
     </td>
     
     
       <?php } else if($_GET['module'] == 'property')  { 
   ?>
	
     <td colspan="8"><h2 style="margin:5px 0;">Customer Requirement List</h2>
	<?php include("customer_detail.php");?>
     </td>
       <?php } else if($_GET['module'] == 'outlet_location')  { ?>
     <td colspan="8"><h2>Outlet Location</h2></td>
     
     
    <?php } else if($_GET['module'] == 'owner')  { ?>
     <td colspan="8"><h2>Owner Listing</h2></td>
    <?php } else if($_GET['module'] == 'site_visit_report')  { ?>
    <td colspan="8"><h2>Site Visit Report Listing</h2></td>
    <?php } else if($_GET['module'] == 'interaction_report')  { ?>
    <td colspan="8"><h2>Report Listing</h2></td>
    <?php } else if($_GET['module'] == 'call_log' && $_REQUEST['shortlist_id'] != '')  { ?>
     <td colspan="8">
     <?php include("property_detail.php");?>
     </td>
    <?php } ?>