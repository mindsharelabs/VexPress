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
			)
        
		)
	);

	return $settings;
}
