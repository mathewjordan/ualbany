<?php

/*
 * actions
 */

function terradotta_footer() {

  if (isset($_GET['manual'])) {
    terradotta_check('manual');
  } else {
    terradotta_check();
  }

  ?>
  <script>
    jQuery(document).ready(function ($) {
      $('#manual_sync').click(function () {
        var url = window.location.href;
        if (url.indexOf('?') > -1){
          url += '&manual=1'
        }else{
          url += '?manual=1'
        }
        window.location.href = url;
      });
    });
  </script>
  <?php

}
add_action('admin_footer', 'terradotta_footer');


// watches on front end
function terradotta_watch () {
  terradotta_check();
}
add_action('wp_footer', 'terradotta_watch');

// runs check
function terradotta_check ($method = 'auto') {

  $update_interval = TERRADOTTA_SYNC_INTERVAL; // seconds
  $prev            = get_option('vs_terradotta_sync');

  $diff = time() - $prev;

  if ($update_interval < $diff || $method == 'manual') {
    // do update
    terradotta_sync();
  }
  else {
    // not time yet
  }
}

// makes ajaxurl available on front end watch
function terradotta_ajaxurl() {
  echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}
add_action('wp_head', 'terradotta_ajaxurl');


// update sync time
function terradotta_log_sync() {

  global $wpdb;

  $stamp = time();
  $wpdb->update(
    'wp_options',
    [
      'option_value' => $stamp
    ],
    [
      'option_name' => 'vs_terradotta_sync'
    ]
  );

  ?>
  <script>
    logTime = jQuery.noConflict();
    logTime(function ($) {
      $('#prev_sync').html('<?php print date(TERRADOTTA_DATE_FORMAT, $stamp); ?>');
      $('#next_sync').html('<?php print date(TERRADOTTA_DATE_FORMAT, $stamp + TERRADOTTA_SYNC_INTERVAL); ?>');
    });
  </script>
  <?php

}

?>