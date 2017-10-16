<?php

// sync data
function terradotta_sync() {

  $get_programs = TERRADOTTA_URL . '?callName=getPrograms&ResponseEncoding=JSON';

  /*
   * programs
   */
  ?>
  <script type="text/javascript">

    function getUniqueVals(data, uniqueKey) {

      var lookup = {};
      var items = data;
      var result = [];

      for (var item, i = 0; item = items[i++];) {

        var name = item[uniqueKey];

        if (!(name in lookup)) {
          lookup[name] = 1;
          result.push(name);
        }
      }
      return result;
    }

    function _cb_getPrograms(td) {



      var regions = getUniqueVals(td.PROGRAM, 'PROGRAM_REGION');
      // console.log(regions);

      var countries = getUniqueVals(td.PROGRAM, 'PROGRAM_COUNTRY');
      // console.log(countries);

//        var cities = getUniqueVals(td.PROGRAM,'PROGRAM_CITY');
//        console.log(cities);

      mapTerraDotta = jQuery.noConflict();
      mapTerraDotta(function ($) {

        $('#running_sync').show();

        $.each(td.PROGRAM, function () {

          var program_data = this;

          $.ajax({
            url: ajaxurl,
            method: "POST",
            data: {
              'action': 'sync_post_action',
              'post_type': 'program',
              'unique_key': 'program_id',
              'unique_val': program_data.PROGRAM_ID,
              'name': program_data.PROGRAM_NAME,
              'data_chunk': program_data
            },
            beforeSend: function () {
            }
          }).done(function (data) {

            var wp_post_id = data;

            $.ajax({
              url: ajaxurl,
              method: "POST",
              data: {
                'action': 'sync_program_brochure_action',
                'wp_post_id' : wp_post_id,
                'program_id' : program_data.PROGRAM_ID
              },
              beforeSend: function () {
                console.log('start' + program_data.PROGRAM_ID + ' map to ' + wp_post_id);
              }
            }).done(function (data) {
              console.log(program_data.PROGRAM_ID + ' map to ' + wp_post_id + ' brochure is done');
            });


          });
          // end ajax

        });
        // end each

        $.each(regions, function (index, value) {

          var region_name = value;

          $.ajax({
            url: ajaxurl,
            method: "POST",
            data: {
              'action': 'sync_post_action',
              'post_type': 'region',
              'unique_key': 'region_id',
              'unique_val': region_name,
              'name': region_name
            },
            beforeSend: function () {
            }
          }).done(function (data) {
          });
          // end ajax

        });
        // end each

        $.each(countries, function (index, value) {

          var country_name = value;

          $.ajax({
            url: ajaxurl,
            method: "POST",
            data: {
              'action': 'sync_post_action',
              'post_type': 'country',
              'unique_key': 'country_id',
              'unique_val': country_name,
              'name': country_name
            },
            beforeSend: function () {
            }
          }).done(function (data) {
          });
          // end ajax

        });
        // end each



        $('#running_sync .status_sync h2').html('Sync Complete');

      });
      // end program mapping

    }

  </script>
  <script src="<?php echo $get_programs; ?>" type="text/javascript"></script>
  <?php

  terradotta_log_sync();

}

?>