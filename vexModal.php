<?php
/*
Plugin Name: vexModal
Plugin URI:  #
Description: basic modal dialog using the vex library
Version:     0.1-alpha
Author:      winston
 */

$pluginDIR = "/wp-content/plugins/vexModal/";
$vexStyle = "vex-theme-wireframe";

function showModal()
{
  global $pluginDIR;
  global $vexStyle;

  wp_enqueue_style("vex-theme-os", $pluginDIR . "css/{$vexStyle}.css");
  wp_enqueue_style("vex-base", $pluginDIR . "css/vex.css");

  wp_enqueue_script('vex', $pluginDIR . "js/vex.combined.min.js", array('jquery'));
  wp_enqueue_script('showModal', $pluginDIR . "js/showModal.js", array('vex'));
  
  wp_localize_script('showModal', 'wp_vars', array(
    'vexstyle' => $vexStyle,
  ));  
}

function loadOnFrontPage()
{
  if (is_front_page()) showModal();
}


add_action('wp_head', 'loadOnFrontPage');