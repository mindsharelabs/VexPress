// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io
'use strict';
jQuery.noConflict();

/**
 * Pretty basic at this point, just a developer hook into the Vex lib
 */
vex.defaultOptions.className = wp_vars.vexStyle;
vex.defaultOptions.showCloseButton = true;

var vexShowSlide = function(call_back) {
	vex.dialog.buttons.YES.text = wp_vars.vexBtnYes;
	vex.dialog.buttons.NO.text = wp_vars.vexBtnNo;

	vex.dialog.confirm({
		message: wp_vars.message,
		overlayCSS: {
			'background': wp_vars.vexOverlayStyle
		},
		callback: call_back
	});
};

jQuery(document).ready(function($) {
	vexShowSlide();
});
