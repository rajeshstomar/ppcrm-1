<link href="<?php DIR_AM_LEFT_MENU_SOURCE;?>menu_source/leftmenu.css" rel="stylesheet" type="text/css">
<td width="135" valign="top" align="left">
 <div class="menu_simple" style="width:132px;" id="leftMenuBar">
    <ul>
        <li id="lm_company"><a href="index.php?rel=common_listing&module=company" class="greenlink_bold" target="_self">Firm</a></li>
        <li id="lm_customer"><a href="index.php?&rel=common_listing&module=customer" class="greenlink_bold" target="_self">Customer</a></li>
        <li id="lm_owner"> <a href="index.php?&rel=common_listing&module=owner" class="greenlink_bold" target="_self">Owner</a></li>
        <li id="lm_site_visit_report"> <a href="index.php?rel=common_listing&module=site_visit_report" class="greenlink_bold" target="_self">Site Visit Report</a></li>
        <li id="lm_interaction_report"> <a href="index.php?rel=common_listing&module=interaction_report" class="greenlink_bold" target="_self">Listing Report</a></li>
        <li id="lm_outlet_location"> <a href="index.php?rel=common_listing&module=outlet_location" class="greenlink_bold" target="_self">Outlet Location</a></li>
        <li id="lm_user_management"> <a href="index.php?rel=common_listing&module=user_management" class="greenlink_bold" target="_self">User Management</a></li>
        <li id="lm_short_list"><a href="index.php?rel=common_listing&module=short_list" class="greenlink_bold" target="_self">Shortisted Property</a></li>
        <li id="lm_global_search"><a href="index.php?&rel=global_search" class="greenlink_bold" target="_self">Global Search</a></li>
        <li id="lm_advanced_search"><a href="index.php?&rel=advanced_search" class="greenlink_bold" target="_blank">Advanced Search</a></li>
        <li id="lm_call_log"> <a href="index.php?rel=common_listing&module=call_log" class="greenlink_bold" target="_self">ShortList Call Log</a></li>
        <li id="lm_customer_import"><a href="index.php?&rel=customer_import" class="greenlink_bold" target="_self">Customer / Requirement</a></li>
        <li id="lm_owner_import">  <a href="index.php?&rel=owner_import" class="greenlink_bold" target="_self">Owner / Property</a></li>
        <li id="lm_log"><a href="index.php?rel=common_listing&module=log" class="greenlink_bold" target="_self">Upload Logs</a></li>
        <li id="lm_rating"><a href="index.php?rel=common_rating&module=rating" class="greenlink_bold" target="_self">Rating</a></li>
    </ul>
</div>
</td> 
<?php $selectedLmModule = (isset($_GET['module']) && !empty($_GET['module'])) ? $_GET['module']:$_GET['rel']?>
<script>
$("#lm_<?php echo $selectedLmModule?>").css("background-color","#282828");
</script>