<?php
/*
Plugin Name: Events Manager Shortcodes
Plugin URI:  https://restezconnectes.fr
Description: Displays your events from Events Manager in a widget or your pages with a shortcode
Version:     0.2
Author:      Florent Maillefaud
Author URI:  https://restezconnectes.fr
License:     GPL3 or later
Domain Path: /languages
Text Domain: em-shortcodes
*/

/*  Copyright 2007-2017 Florent Maillefaud (email: contact at restezconnectes.fr)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

defined( 'ABSPATH' )
	or die( 'No direct load ! ' );

define( 'EMS_DIR', plugin_dir_path( __FILE__ ) );
define( 'EMS_URL', plugin_dir_url( __FILE__ ) );
define( 'EMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'EMS_PLUGIN_URL', plugins_url().'/'.strtolower('em_shortcodes').'/');

if( !defined( 'EMS_VERSION' )) { define( 'EMS_VERSION', '0.2' ); }

require EMS_DIR . 'classes/class.php';
require EMS_DIR . 'includes/shortcodes.php';

add_action( 'plugins_loaded', '_ems_load' );
function _ems_load() {
	$emshortcodes_widget = new em_shortcodes();
	$emshortcodes_widget->hooks();
}

// Enable localization
add_action( 'init', '_ems_load_translation' );
function _ems_load_translation() {
    load_plugin_textdomain( 'em-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}