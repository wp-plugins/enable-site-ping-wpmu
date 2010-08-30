<?php
/*
Plugin Name: Enable Site Ping WPMU
Plugin URI: http://sean-fisher.com
Description: Enable site ping for a WPMU site.
Version: 1.0
Author: Sean Fisher
Author URI: http://sean-fisher.com/
*/

/**
 *	Enabling the site ping input on Options -> Writing.
**/
function enable_ping() {
	remove_filter('enable_update_services_configuration', '_do_return_false');
	add_filter( 'enable_update_services_configuration', '_do_return_true' );
}

/**
 *	Return true
**/
function _do_return_true() {
	return true;
}

/**
 * Return false
**/
function _do_return_false() {
	return false;
}

/**
 *	Allow the user to update the ping list.
**/
function enable_ping_whitelist($list = NULL) {
	if ( is_null( $list )) 
		$list = array( );
	
	//	Removing it if it already existed.
	foreach($list['writing'] as $key => $writing) {
		if ($writing == 'ping_sites') 
			unset($list['writing'][$key]);
	}
	
	$list['writing'][] = 'ping_sites';
	return $list;	
}

/**
 *	Making sure the ping list exists.
**/
if ( !has_action('do_pings', 'do_all_pings') )
	add_action( 'do_pings',' do_all_pings', 10, 1 );

//	Filters
add_filter('whitelist_options', 'enable_ping_whitelist');
add_action('init', 'enable_ping');

