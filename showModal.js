// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io

// this is where the logic for displaying the dialog lives...

vex.defaultOptions.className = wp_vars.vexstyle; 

jQuery(document).ready(function(){  
  // vex.dialog.alert(wp_vars.content);
  $ = jQuery;
  vex.dialog.open({
    message: 'Enter your username and password:',
    input: wp_vars.input,
    buttons: [
      $.extend({}, vex.dialog.buttons.YES, {
        text: 'Login'
      }), $.extend({}, vex.dialog.buttons.NO, {
        text: 'Back'
      })
    ],
    callback: function(data) {
      if (data === false) {
        return console.log('Cancelled');
      }
      return console.log('Username', data.username, 'Password', data.password);
    }
  });
  
});

