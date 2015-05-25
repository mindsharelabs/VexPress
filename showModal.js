// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io

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
  });
}

jQuery(document).ready(function(){  
  showFirstSlide();
});

