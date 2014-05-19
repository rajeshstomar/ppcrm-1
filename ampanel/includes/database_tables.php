<?php
/**
 * @Author Nimit Dudani
 * @copyright Copyright 2003-2007 Alakmalak Development Team
 * @copyright Portions Copyright 2008-2009 AM
 * @license for company use only
 * @Date Add : 
 */

if (!defined('DB_PREFIX')) define('DB_PREFIX', '');

define('TABLE_ADMIN', DB_PREFIX . 'admin');
define('TABLE_COUNTRIES', DB_PREFIX . 'countries');
define('TABLE_REGIONS', DB_PREFIX . 'regions');
define('TABLE_STATES', DB_PREFIX . 'states');
define('TABLE_SETTING', DB_PREFIX . 'setting');
define('TABLE_PAGE', DB_PREFIX . 'page');

/*************** bullion defined ***********/
define('TABLE_ADMIN_USER', DB_PREFIX . 'admin_user');
define('TABLE_PROJECT', DB_PREFIX . 'project');
define('TABLE_FEEDBACK', DB_PREFIX . 'feedback');
?>
