<?php

/**
 * Example settings page
 */
add_filter('vex_press_register_settings', 'vex_press_settings');

function vex_press_settings($settings) {

	// VexPress General Settings section
	$settings[] = array(
		'section_id'          => 'general',
		'section_title'       => 'Settings',
		//'section_description' => 'Some intro description about this section.',
		'section_order'       => 5,
		'fields'              => array(
			array(
				'id'    => 'vexp_message',
				'title' => 'Dialog Message',
				'desc'  => 'Enter content for your Vex modal dialog',
				'type'  => 'editor',
				'std'   => ''
			),
			array(
				'id'    => 'vexp_agreeColor',
				'title' => 'Color of agree button',
				'desc'  => 'Slect the Color you would like the affirmative button to be',
				'type'  => 'color',
				'std'   => ''
			),
			array(
				'id'    => 'vexp_agreeText',
				'title' => 'confirm button text',
				'desc'  => 'enter the text you would like displayed as the <strong>confirm</strong> button',
				'type'  => 'text',
				'std'   => 'OK'
			),
			array(
				'id'    => 'vexp_disagreeText',
				'title' => 'cancell button text',
				'desc'  => 'enter the text you would like displayed as the <strong>cancel</strong> button',
				'type'  => 'text',
				'std'   => 'CANCEL'
			),
			array(
				'id'    => 'vexp_backgroundColor',
				'title' => 'Background Color',
				'desc'  => 'Slect the Color you would like as the background:',
				'type'  => 'color',
				'std'   => ''
			),
			array(
				'id'    => 'vexp_opacity',
				'title' => 'Opacity',
				'desc'  => 'value must be in the range [0,1]',
				'type'  => 'text',
				'std'   => ''
			),
			array(
				'id'    => 'vexp_pageid',
				'title' => 'Visible Title',
				'desc'  => 'enter the title of the page that the dialog is to be displayed on (special options: all) empty str is front',
				'type'  => 'text',
				'std'   => ''
			)
        
		)
	);

	return $settings;
}
