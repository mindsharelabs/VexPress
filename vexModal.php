<?php
/*
Plugin Name: VexPress 
Plugin URI:  #
Description: basic modal dialog using the vex library
Version:     0.1-alpha
Author:      winston riley
 */

$pluginDIR = "/wp-content/plugins/VexPress/";
$vexStyle = "vex-theme-plain";



function vexp_showModal()
{
  global $pluginDIR;
  global $vexStyle;
  global $content;
  global $input;

  // vex replies on both style sheets
  wp_enqueue_style("vex-theme-os", $pluginDIR . "css/{$vexStyle}.css");
  wp_enqueue_style("vex-base", $pluginDIR . "css/vex.css");
  
  wp_enqueue_script('vex', $pluginDIR . "js/vex.combined.min.js", array('jquery')); // vex js 

  // js built on top of vex
  wp_enqueue_script('showModal', $pluginDIR . "showModal.js", array('vex'));
  
  wp_localize_script('showModal', 'wp_vars', array(
    'vexstyle' => $vexStyle, // sets the dialog box style inside JS.
  ));  
}

function vexp_loadOnFrontPage()
{
  if (is_front_page()) vexp_showModal();
}

add_action('wp_head', 'vexp_loadOnFrontPage');
