// =========================================
// = VEX MODAL DIALOG PLUGIN FOR WORDPRESS =
// ================================== wrm.io
'use strict';
jQuery.noConflict();

vex.defaultOptions.className = wp_vars.vexStyle;
vex.defaultOptions.showCloseButton = true;
vex.defaultOpacity = .6;

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
 * clamps the specified value beween 0 and 1.
 */
var clamp = function(val) {
  if (isNaN(val)) return vex.defaultOpacity;
  return Math.max(0, Math.min(1, val) );
}

var vexShowSlide = function(call_back) {
	vex.dialog.buttons.YES.text = wp_vars.vexBtnYes;
	vex.dialog.buttons.NO.text = wp_vars.vexBtnNo;

  var color = vexHexToRGBColorParser(wp_vars.vexOverlayStyle);
  var opacity = clamp(parseFloat(wp_vars.opacity));
  
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
};

jQuery(document).ready(function($) {
	vexShowSlide();
});

