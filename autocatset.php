<?php
/*
Plugin Name: AutoCatSet
Plugin URI: 
Description: AutoCatSet is plugin for automatically re-set category from keyword in the tile and the content of each post.
Author: gyaku
Version: 2.1.4
Text Domain: autocatset
Author URI: http://www.gyakuchannel.com/plugin/
License:     GPL2
 
AutoCatSet is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
AutoCatSet is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with AutoCatSet. If not, see {License URI}.
*/

// Exit if this file is directly accessed.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

load_plugin_textdomain('autocatset');

$options = new AutoCatSet;
require_once dirname( __FILE__ ) . '/lib/function.php';

//1. メインClass
class AutoCatSet {

	//2．設定画面定義
	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_pages' ) );
	}

	//メニュー
	function add_pages() {
		add_menu_page( 'AutoCatSet', 'AutoCatSet', "manage_options", __FILE__, array( $this, 'option_page' ), "", 100 );
	}

	//3. 管理画面表示
	function option_page() {

		global $current_user;
		wp_get_current_user();
		if ( $current_user->user_level == 10 ) {
			//Login check
			if ( isset( $_POST[ 'autocatset_start' ] ) ) {
				require_once dirname( __FILE__ ) . '/lib/recategorize.php';
			} else {
				require_once dirname( __FILE__ ) . '/lib/option_page.php';
			}

		} else {
			_e( "You do not have Permission. Please log in at the administrator level.", "autocatset" );
		}

	}

}

///////////////////////////////////////////////////////

function autocatset_add_action_links( $links ) {
	$mylinks = array( '<a href="' . admin_url( 'options-general.php?page=' . plugin_basename( __FILE__ ) ) . '">' . __( "Options", "autocatset" ) . '</a>', );
	return array_merge( $links, $mylinks );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'autocatset_add_action_links' );

function autocatsetplugin_load() {
	wp_enqueue_script( 'autocatset_js', plugins_url( '/js/autocatset.js', __FILE__ ), array(), '1.0', true );
	wp_register_style( 'autocatset_css', plugins_url( '/css/autocatset.css', __FILE__ ) );
	wp_enqueue_style( 'autocatset_css' );
}
add_action( 'admin_enqueue_scripts', 'autocatsetplugin_load' );

function autocatset_ajax() {
	header( 'Content-Type: text/html; charset=utf-8' );
	if ( isset( $_POST[ 'autocatset_recat' ] ) ) {
		require_once dirname( __FILE__ ) . '/lib/ajax.php';
	} else {
		die();
	}
}
add_action( 'wp_ajax_autocatset_ajax', 'autocatset_ajax' );
