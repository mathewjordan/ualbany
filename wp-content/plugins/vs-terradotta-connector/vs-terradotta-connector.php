<?php
/*
Plugin Name: Terra Dotta Connector by Verified Studios
Plugin URI: http://verifiedstudios.com
Description: Connects to a Terra Dotta instance and syncs content hourly.
Version: 0.3.0
Author: Verified Studios
Author URI: http://verifiedstudios.com
*/

define("TERRADOTTA_URL", "http://ualbany.studioabroad.com/piapi/index.cfm", TRUE);
define("TERRADOTTA_SYNC_INTERVAL", 600, TRUE);
define("TERRADOTTA_DATE_FORMAT", 'm/d/Y g:i:s A', TRUE);

date_default_timezone_set('America/New_York');

// app
require ('app/watch.php');
require ('app/activation.php');
require ('app/curl.php');
require ('app/admin.php');

// sync
require ('sync/process.php');

// sync actions
require ('sync/actions/_post.php');
require ('sync/actions/_program_brochure.php');

?>