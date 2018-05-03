/* eslint-disable */

export default {
  init() {
    // JavaScript to be fired on the home page
    $('#location, #area').change(function() {
      var menu     = $(this)[0].id,
          value    = $(this).val(),
          origin   = window.location.origin,
          redirect = '';

      if (menu) {
	      var archive = { location: 'countries', area: 'subjects' };
	      redirect += origin + '/' + archive[menu] + '/' + value;
	      window.location.replace(redirect);
      }
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
