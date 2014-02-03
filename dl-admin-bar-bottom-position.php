<?php
/*
Plugin Name: DL Admin Bar Bottom Position
Description: 
Plugin URI: http://vcard.dd-l.name/wp-plugins/
Version: 1.0
Author: Dyadya Lesha (info@dd-l.name)
Author URI: http://dd-l.name
*/


// Отключение стандартных CSS в HTML-коде
function dl_admin_bar_bottom_position_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
 
add_action('get_header', 'dl_admin_bar_bottom_position_filter_head');
 
// CSS для прилепления админки к нижнему краю страницы
function dl_admin_bar_bottom_position() {
	echo '
	<style type="text/css">
	html{margin-bottom:32px !important}
	* html body{margin-bottom:32px !important}
	#wpadminbar{top:auto !important;bottom:0}
	#wpadminbar .menupop .ab-sub-wrapper{bottom:32px;-moz-box-shadow:2px -2px 5px rgba(0,0,0,.2);-webkit-box-shadow:2px -2px 5px rgba(0,0,0,.2);box-shadow:2px -2px 5px rgba(0,0,0,.2)}
	@media screen and ( max-width:782px ){
		html{margin-bottom:46px !important}
		* html body{margin-bottom:46px !important}
		#wpadminbar{position:fixed}
		#wpadminbar .menupop .ab-sub-wrapper{bottom:46px}
	}
	</style>
	';
}
 
//add_action( 'admin_head', 'dl_admin_bar_bottom_position' ); // в админке
add_action( 'wp_head', 'dl_admin_bar_bottom_position' ); // на сайте