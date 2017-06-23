// toggle `.pad` && `aside`
// w/ resize event, etc etc

jQuery(document).ready(function() {
  toggle_pad();
  jQuery(window).on('resize', function() {
    toggle_pad()
  });
});

function toggle_pad() {
  
  var ww = jQuery(window).width();
  var pad = jQuery('.pad');
  var aside = jQuery('aside');
  var aside_c = jQuery('aside').children();
  var main = jQuery('main');

  jQuery('.pad-button').on('click', function() {
    if(ww >= 600) {
      if(jQuery(pad).hasClass('d-n')) {
        // aside
        jQuery(aside_c).addClass('d-n');
        jQuery(aside).removeClass('w--third__md').addClass('w--bl__md');
      
        // pad && main
        jQuery(pad).removeClass('d-n').addClass('w--half__md');
        jQuery(main).removeClass('w--two-thirds__md h--full').addClass('w--half__md');
      } else {
        // aside
        jQuery(aside_c).removeClass('d-n');
        jQuery(aside).addClass('w--third__md').removeClass('w--bl__md');

        // pad && main
        jQuery(pad).addClass('d-n').removeClass('w--half__md');
        jQuery(main).addClass('w--two-thirds__md h--full').removeClass('w--half__md');
      }

    } else if(jQuery(pad).hasClass('d-n')) {
      // pad && main
      jQuery(pad).removeClass('d-n').addClass('w--half__md');
      jQuery(main).removeClass('w--two-thirds__md h--full').addClass('w--half__md');

    } else {
      // pad && main
      jQuery(pad).addClass('d-n').removeClass('w--half__md');
      jQuery(main).addClass('w--two-thirds__md h--full').removeClass('w--half__md');

    }
  })

};
