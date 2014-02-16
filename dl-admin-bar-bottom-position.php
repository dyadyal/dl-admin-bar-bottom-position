<?php
/*
Plugin Name: DL Admin Bar Bottom Position
Description: Этот плагин прижимает админ-панели к нижней части экрана
Plugin URI: http://vcard.dd-l.name/wp-plugins/
Version: 1.1
Author: Dyadya Lesha (info@dd-l.name)
Author URI: http://dd-l.name

*/

// Добавляем checkbox на старницу редактирования профиля
function dl_admin_bar_bottom_position_extra_checkbox( $user ) {
	$show_admin_bar_bottom_source = get_user_meta( $user->ID , 'wp_bar_bottom',  true );
	$checked = $show_admin_bar_bottom_source === '1' ? ' checked="checked" ' : '';
	?>
	<tr>
		<th></th>
		<td>
			<input type="checkbox"
				   name="wp_bar_bottom"
				   id="wp_bar_bottom"
				   <?= $checked ?>
				   value="1"
			/><label for="wp_bar_bottom"> Разместить панель инструментов внизу страницы сайта</label>
		</td>
	</tr>
<?php
}
add_action( 'personal_options', 'dl_admin_bar_bottom_position_extra_checkbox' );
 

// Сохраняем настройки профиля
function dl_admin_bar_bottom_position_save_extra( $user_id ) {
 
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
 
	$show_admin_bar_bottom = ( isset( $_POST['wp_bar_bottom'] ) &&  $_POST['wp_bar_bottom'] === '1' ) ? '1' : '0';

	$update_result = update_user_meta( $user_id, 'wp_bar_bottom', $show_admin_bar_bottom );
}
add_action( 'personal_options_update', 'dl_admin_bar_bottom_position_save_extra' );
add_action( 'edit_user_profile_update', 'dl_admin_bar_bottom_position_save_extra' );


// Отключение стандартных CSS в HTML-коде
function dl_admin_bar_bottom_position_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'dl_admin_bar_bottom_position_filter_head');
 

// CSS админки
function dl_admin_bar_bottom_position_style() {
	echo '
	<style type="text/css">
		* html body { margin-top: 0 !important; }
		body.admin-bar { margin-top: -32px;	padding-bottom: 32px; }
		body.wp-admin #footer {	padding-bottom: 32px; }
		#wpadminbar { top: auto !important; bottom: 0; }
		#wpadminbar .quicklinks .ab-sub-wrapper { bottom: 32px; }
		#wpadminbar .quicklinks .ab-sub-wrapper ul .ab-sub-wrapper { bottom: -7px; }
	</style>
	';
}
 
// Проверяем авторизацию пользователя и получем его id, если условия верны подлючаем стили
function dl_admin_bar_bottom_position_admin_init() { 	  
	if ( is_user_logged_in() && get_user_meta( get_current_user_id() , 'wp_bar_bottom',  true ) === '1' ) { 
		add_action( 'admin_head', 'dl_admin_bar_bottom_position_style' ); // в админке
		add_action( 'wp_head', 'dl_admin_bar_bottom_position_style' ); // на сайте
		}
}
add_action( 'admin_init', 'dl_admin_bar_bottom_position_admin_init' );