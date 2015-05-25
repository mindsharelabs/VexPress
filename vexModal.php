<?php
/*
Plugin Name: vexModal
Plugin URI:  #
Description: basic modal dialog using the vex library
Version:     0.1-alpha
Author:      winston
 */


$pluginDIR = "/wp-content/plugins/vexModal/";


function showModal()
{
  global $pluginDIR;

  wp_enqueue_style("vex-theme-os", $pluginDIR . "css/vex-theme-os.css");
  wp_enqueue_style("vex-base", $pluginDIR . "css/vex.css");

  wp_enqueue_script('vex', $pluginDIR . "js/vex.combined.min.js", array('jquery'));
  wp_enqueue_script('showModal', $pluginDIR . "js/showModal.js", array('vex'));  
}

function test()
{
  die("called from test fn");
}

  
  
add_action('wp_head', 'showModal');