<?php

/*
* admin page
*/

function terradotta_admin() {

  $date_format = TERRADOTTA_DATE_FORMAT;
  $prev        = get_option('vs_terradotta_sync');
  $next        = $prev + TERRADOTTA_SYNC_INTERVAL;

  echo '<h1>Terra Dotta API</h1>';

  echo '<div class="welcome-panel" style="padding: 15px; margin-top: 25px;">';
  echo '<h2 style="margin-bottom: 20px;">Terra Dotta Endpoint</h2>';
  echo '<div style="width: auto; display: inline-block; color: #666; font-size:1.3em; background-color: #fafafa; font-family: monospace; border: 1px solid #eee; padding: 10px 15px; border-radius: 1px;">';
  echo TERRADOTTA_URL;
  echo '</div>';
  echo '</div>';

  echo '<div class="welcome-panel" style="padding: 15px;"><div id="terrdotta_data">';
  echo '<h2>Sync Data</h2>';
  echo '<div style="float: left; margin-right: 40px"><h3>Most Recent Sync</h3>';
  print '<span id="prev_sync">' . date($date_format, $prev) . '<span>';
  echo '</div>';
  echo '<div style="float: left"><h3>Next Scheduled Sync</h3>';
  print '<span id="next_sync">' . date($date_format, $next) . '<span>';
  echo '</div>';
  echo '</div></div>';

  echo '<div id="running_sync" class="welcome-panel" style="padding: 15px; opacity: 0.5; display: none;">';
  echo '<span class="status_sync"><h2>Sync Errored...</h2></span>';
  echo '</div>';

  echo '<div>';
  echo '<input id="manual_sync" value="Run Manual Sync" class="button button-primary button-hero" style="margin-right: 1rem;" type="button"/>';
  echo '</div>';
}

add_action('admin_menu', 'vs_terradotta_connector_plugin_setup_menu');

function vs_terradotta_connector_plugin_setup_menu() {
  add_menu_page('Terra Dotta Connector', 'Terra Dotta API', 'manage_options', 'terradotta', 'terradotta_admin');
}

?>