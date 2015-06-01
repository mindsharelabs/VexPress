// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io
'use strict';
jQuery.noConflict();

vex.defaultOptions.showCloseButton = true;
vex.defaultOpacity = .65;
vex.defaultTheme = 'vex-theme-plain';

/**
 * Parse a hex string in the format of "#xxxxxx"
 * into a color obj
 *
 * "#xxxxxx" -> color {r, g, b}
 */
var vexHexToRGBColorParser = function(hex){
  var color = {};
  color.r = parseInt("0x" + hex.slice(1,3));
  color.g = parseInt("0x" + hex.slice(3,5));
  color.b = parseInt("0x" + hex.slice(5,7));
  return color;
}

/**
 * clamp :: float -> float
 * clamps the specified value beween floor and ceiling.
 * returns NaN on failiure.
 *
 * default vals floor = 0,
 *              ceiling = 1.
 */
var clamp = function(val, floor, ceiling) {
  floor = typeof floor !== 'undefined' ? floor : 0;
  ceiling = typeof ceiling !== 'undefined' ? ceiling : 1;

  return Math.max(floor, Math.min(ceiling, val));
}

var vexShowSlide = function(call_back) {
  // in case no style has been selected in the setting page.
  vex.defaultOptions.className = wp_vars.vexStyle || vex.defaultTheme;
  
	vex.dialog.buttons.YES.text = wp_vars.vexBtnYes;
	vex.dialog.buttons.NO.text = wp_vars.vexBtnNo;

  var color = vexHexToRGBColorParser(wp_vars.vexOverlayStyle);
  var opacity = clamp(parseFloat(wp_vars.opacity));
  if (isNaN(opacity)) opacity = vex.defaultOpacity;
  
  // building up the css => "rgba(r,g,b,a)"
  var colorStr = "rgba("+color.r;
  colorStr += "," + color.g;
  colorStr += "," + color.b;
  colorStr += "," + opacity + ")"

	vex.dialog.confirm({
		message: wp_vars.message,
		overlayCSS: {
			'background': colorStr,
		},
		callback: call_back
	});
  
  if (wp_vars.priBtnColor != "#"){
    jQuery(".vex-dialog-buttons .vex-dialog-button-primary").css({
      'background-color' : wp_vars.priBtnColor,
    });
  }
};

jQuery(document).ready(function($) {
	vexShowSlide();
});

