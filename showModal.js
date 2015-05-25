// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io

// this is where the logic for displaying the dialog lives...

vex.defaultOptions.className = wp_vars.vexstyle; 
var $ = jQuery; 

var showFirstSlide = function(call_back){
  vex.dialog.buttons.YES.text = 'I AGREE';
  vex.dialog.buttons.NO.text = 'I DISAGREE';
  
  vex.dialog.confirm({
    message: 'Do you Want to be stronger and such?',
    overlayCSS : {
      'background' : 'rgba(0, 0, 0, 0.8)',
    },
  });
}

jQuery(document).ready(function(){  
  showFirstSlide();
});

