jQuery(document).ready(function() {
  
  var pad = jQuery('.pad');
  var aside = jQuery('aside');
  var aside_c = jQuery('aside').children();
  var main = jQuery('main');

  jQuery('.pad-button').on('click', function() {
    if(jQuery(pad).hasClass('d-n')) {
      // pad && main
      jQuery(pad).removeClass('d-n').addClass('w--half__md');
      jQuery(main).removeClass('w--two-thirds__md').addClass('w--half__md');

      // aside
      jQuery(aside_c).addClass('d-n');
      jQuery(aside).removeClass('w--third__md').addClass('w--bl__md');
    } else {
      // pad && main
      jQuery(pad).addClass('d-n').removeClass('w--half__md');
      jQuery(main).addClass('w--two-thirds__md').removeClass('w--half__md');

      // aside
      jQuery(aside_c).removeClass('d-n');
      jQuery(aside).addClass('w--third__md').removeClass('w--bl__md');
    }
  })
});
