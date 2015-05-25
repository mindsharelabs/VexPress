<?php
/*
Plugin Name: VexPress 
Plugin URI:  #
Description: basic modal dialog using the vex library
Version:     0.1-alpha
Author:      winston riley
 */

$pluginDIR = "/wp-content/plugins/VexPress/";
$vexStyleSheet = "vex-theme-plain";

// register the vex press options, a way to pass info to JS.
add_action('admin_init', 'vexp_init');
function vexp_init()
{
  register_setting('vexp_options', 'vexp_message');
}



function vexp_showModal()
{
  global $pluginDIR;
  global $vexStyleSheet;

  // vex replies on both style sheets
  wp_enqueue_style("vex-theme-os", $pluginDIR . "css/{$vexStyleSheet}.css");
  wp_enqueue_style("vex-base", $pluginDIR . "css/vex.css");
  
  wp_enqueue_script('vex', $pluginDIR . "js/vex.combined.min.js", array('jquery')); // vex js 

  // js built on top of vex
  wp_enqueue_script('showModal', $pluginDIR . "showModal.js", array('vex'));
  
  wp_localize_script('showModal', 'wp_vars', array(
    'vexstyle' => $vexStyleSheet, // sets the dialog box style inside JS.
    'message' => get_option('vexp_message'),
  ));  
}

add_action('wp_head', 'vexp_loadOnFrontPage');
function vexp_loadOnFrontPage()
{
  if (is_front_page()) vexp_showModal();
}

// sets up the HTML for the setting admin page
function vexp_settings_page()
{
  ?>
  <div class = "wrap">
    <?php screen_icon(); ?>
    <h2>Vex Press </h2>
    <form action="options.php" method="post">
      <?php settings_fields('vexp_options'); ?>
      <label for="vexp_message">Dialog Message</label>
      <br />
      <textarea type="text" id="vexp_message" name="vexp_message"/>
        <?php echo esc_attr(get_option('vexp_message')); ?>
      </textarea>
      <br />
      <input type="submit" name="submit" value="Save Message" />
    </form>
  </div>
  <?php
}

add_action('admin_menu', 'vexp_plugin_menu');
function vexp_plugin_menu()
{
  add_options_page("Vex Press Settings", "Vex Press", 'manage_options', 'vexp', 'vexp_settings_page');
}


