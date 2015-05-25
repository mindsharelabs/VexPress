// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io

/* pretty basic at this point, just a developer hook
 * into the Vex lib
 */

vex.defaultOptions.className = wp_vars.vexstyle; 
var $ = jQuery; 

var showFirstSlide = function(call_back){
  vex.dialog.buttons.YES.text = 'I AGREE';
  vex.dialog.buttons.NO.text = 'I DISAGREE';
  
  vex.dialog.confirm({
    message: wp_vars.message,
    overlayCSS : {
      'background' : 'rgba(0, 0, 0, 0.8)',
    },
    callback: call_back,
  });
}

jQuery(document).ready(function(){  
  showFirstSlide();
});

