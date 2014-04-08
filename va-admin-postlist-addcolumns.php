<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: VA Admin Postlist Addcolumns
Description: Add the Post ID and Last updated Post list of management screen.
Version: 0.0.1
Plugin URI: http://visualive.jp/download/wordpress/plugins/
Author: VisuAlive
Author URI: http://visualive.jp/
Text Domain: va_dcc
Domain Path: /languages
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

VisuAlive WordPress Plugin, Copyright (C) 2013 VisuAlive Inc

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! class_exists( 'VA_Admin_Postlist_Addcolumns' ) ) :
define( 'VA_APAC_VERSION', '0.0.1' );
define( 'VA_APAC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'VA_APAC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
load_plugin_textdomain( 'va_dpac', false, VA_APAC_PLUGIN_PATH . '/languages' );

class VA_Admin_Postlist_Addcolumns {
	function __construct() {
		// sort request
		add_filter( 'request', array( $this, '_va_apac_posts_orderby_columns' ) );
		// Post
		add_filter( 'manage_posts_columns', array( $this, '_va_apac_posts_add_columns') );
		add_action( 'manage_posts_custom_column', array( $this, '_va_apac_postos_echo_columns' ), 10, 2 );
		add_filter( 'manage_edit-post_sortable_columns', array( $this, '_va_apac_posts_sortable_columns' ) );
		// Page
		add_filter( 'manage_pages_columns', array( $this, '_va_apac_posts_add_columns' ) );
		add_action( 'manage_pages_custom_column', array( $this, '_va_apac_postos_echo_columns' ), 10, 2 );
		add_filter( 'manage_edit-page_sortable_columns', array( $this, '_va_apac_posts_sortable_columns' ) );
	}
	/*
	 * @link http://hijiriworld.com/web/wordpress-admin-customize/#list
	 *
	 */
	// add
	function _va_apac_posts_add_columns( $defaults ) {
		$defaults['post_modified'] = __( 'Last updated', VAT2014_TEXTDOMAIN );
		$defaults['post_id'] = __( 'ID', VAT2014_TEXTDOMAIN );
		return $defaults;
	}
	function _va_apac_postos_echo_columns( $column_name, $id ) {
		if( $column_name === 'post_modified' ){
			echo get_the_modified_date( __( 'm.d.Y', VAT2014_TEXTDOMAIN ) );
		}
		if( $column_name === 'post_id' ){
			echo intval( $id );
		}
	}
	// sort
	function _va_apac_posts_orderby_columns( $vars ) {
		if ( isset($vars['orderby']) AND 'post_modified' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				// 'meta_key' => 'modified',
				// 'orderby' => 'meta_value'
				'orderby' => 'modified'
			));
		}
		if ( isset($vars['orderby']) AND 'post_id' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'orderby' => 'ID'
			));
		}
		return $vars;
	}
	function _va_apac_posts_sortable_columns( $sortable_column ) {
		$sortable_column['post_modified'] = 'post_modified';
		$sortable_column['post_id'] = 'post_id';
		return $sortable_column;
	}
}
new VA_Admin_Postlist_Addcolumns;
endif; // VA_Admin_Postlist_Addcolumns
