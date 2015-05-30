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
			)
		)
	);

	return $settings;
}
