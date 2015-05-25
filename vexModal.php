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
$content = "this is jsust some dummy content to see if and how worpress pipes info to java script";

$input = "
  <input name=\"username\" type=\"text\" placeholder=\"Username\" required />\n
  <input name=\"password\" type=\"password\" placeholder=\"Password\" required />
";

function showModal()
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
    'vexstyle' => $vexStyle,
    'content' => $content,
    'input' => $input
  ));  
}

function loadOnFrontPage()
{
  if (is_front_page()) showModal();
}


add_action('wp_head', 'loadOnFrontPage');
