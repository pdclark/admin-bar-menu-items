<?php

/*
Plugin Name: Admin Bar Menu Items
Plugin URI: https://github.com/brainstormmedia/admin-bar-menu-items
Description: Add menu items to the Admin Bar using a menu called "Admin" in Appearance > Menus
Version: 1.0
Author: Brainstorm Media
Author URI: http://brainstormmedia.com 
*/

/**
 * Copyright (c) 2012 Brainstorm Media. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
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