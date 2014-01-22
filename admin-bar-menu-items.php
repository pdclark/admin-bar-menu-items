<?php
/*
Plugin Name: Admin Bar Menu Items
Plugin URI: https://github.com/10up/admin-bar-menu-items
Description: Add menu items to the Admin Bar using a menu called "Admin" in <a href="nav-menus.php">Appearance > Menus</a>.
Version: 1.0
Author: Paul Clark, 10up
Author URI: http://pdclark.com 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Add WP Menus to the Admin Menubar
function storm_admin_bar_custom_menus() {
	
	if ( !is_admin_bar_showing() ) { return; }

	global $wp_admin_bar;

	// Get menu "Admin" from Appearance > Menus
	$menu_items = wp_get_nav_menu_items('admin');
	
	// Associate parent IDs with slugs
	foreach ( (array) $menu_items as $key => $item) {
		if ( $item->post_parent == 0 ) {
			// TODO: Revise to work with pages and posts
			$menu_slugs[ $item->ID ] = $item->post_name;
		}
	}
	
	// Add menu items to Admin bar
	foreach ( (array) $menu_items as $key => $item) {
		if ( $item->menu_item_parent == 0 ) {
			$wp_admin_bar->add_menu( array( 'id' => $item->post_name, 'title' => $item->post_title, 'href' => $item->url ));
		}else {
			$wp_admin_bar->add_menu( array( 'parent' => $menu_slugs[ $item->menu_item_parent ], 'title' => $item->post_title, 'href' => $item->url ) );
		}
	}
	
}
add_action( 'admin_bar_menu', 'storm_admin_bar_custom_menus', 999 );
