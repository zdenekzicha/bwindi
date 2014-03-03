/*
 * Rozostreni fotky v hlavice na hp pri scrollovani
 */
var headerBlur = function(){};
headerBlur.prototype = {}

headerBlur.prototype.init = function() {
	jQuery(window).on( "scroll", function(e) { this.doSomething(e); }.bind(this));
}

headerBlur.prototype.doSomething = function(e) {
	var top = jQuery(e.target).scrollTop();
	var part = jQuery("#wideslider").height() - 200;
	var opacity = (1/part) * top;

	if(opacity <= 1) {
		jQuery("#wideslider #headerPhoto").css('opacity', 1 - opacity);
	}
};
