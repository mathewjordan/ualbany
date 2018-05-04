/* eslint-disable */

export default {
  init() {
    // JavaScript to be fired on the home page
    var formMenus = $('#location, #area, #semester');

    // Reset all formMenus to their first option
    formMenus.each(function(){
    	$(this).val($(this).find("option:first").val());
    });

    formMenus.change(function() {
      var menu     = $(this)[0].id,
          value    = $(this).val(),
          origin   = window.location.origin,
          redirect = '';

      if (menu) {
	      var archive = { location: 'countries/', area: 'subjects/', semester: 'terms?term=' };
	      redirect += origin + '/' + archive[menu] + value;
	      window.location = redirect;
      }
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
