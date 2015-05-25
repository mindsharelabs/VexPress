// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io

// this is where the logic for displaying the dialog lives...

vex.defaultOptions.className = wp_vars.vexstyle; 

jQuery(document).ready(function(){  
  vex.dialog.alert(wp_vars.content);
});

