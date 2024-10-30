<?php 

/*
Plugin Name: Lemon News
Plugin URI: 
Description: A simple plugin to help you manage user's e-mail lists. You can view and export this list in different formats to use them externally. E.g.: Creating email-marketing lists for usage in third-party websites.
Version: 1.0
Author: Vitor Rigoni - Lemon Juice Web Apps
Author URI: http://yourdomain.com
License: GPL2
*/

/*  Copyright 2013 Vitor Rigoni - LemonJuice Web Apps (email : vitor@lemonjuicewebapps.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*==============
	Defines
================*/

// Other constants
define('LEMONJUICE_PLUGIN_NAME', 'LemonNews');
define('LEMONJUICE_PLUGIN_SHORTNAME', 'lemon-news');

// Paths
define("LEMONJUICE_PLUGIN_PATH", dirname(__FILE__) . "/");
define('LEMONJUICE_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define("LEMONJUICE_PLUGIN_CLASSES_PATH", LEMONJUICE_PLUGIN_PATH . "classes/");
define("LEMONJUICE_PLUGIN_VIEWS_PATH", LEMONJUICE_PLUGIN_PATH . "views/");
define("LEMONJUICE_PLUGIN_UTILITIES_PATH", LEMONJUICE_PLUGIN_PATH . "utility/");
define('LEMONJUICE_PLUGIN_STYLES_URL', LEMONJUICE_PLUGIN_URL . "css/");
define('LEMONJUICE_PLUGIN_SCRIPTS_URL', LEMONJUICE_PLUGIN_URL . "js/");
define("LEMONJUICE_PLUGIN_IMAGES_URL", LEMONJUICE_PLUGIN_URL . "img/");
define("LEMONJUICE_PLUGIN_LANGUAGES_PATH",  dirname(plugin_basename( __FILE__ )) . "/languages/");


/*==============
	Includes
================*/

require_once(LEMONJUICE_PLUGIN_CLASSES_PATH . "class-lemon-news-model.php");
require_once(LEMONJUICE_PLUGIN_CLASSES_PATH . "class-lemon-news-toolkit.php");
require_once(LEMONJUICE_PLUGIN_CLASSES_PATH . "class-lemon-news-admin.php");
require_once(LEMONJUICE_PLUGIN_CLASSES_PATH . "class-lemon-news-installer.php");
require_once(LEMONJUICE_PLUGIN_CLASSES_PATH . "class-lemon-news-widget.php");
require_once(LEMONJUICE_PLUGIN_CLASSES_PATH . "class-lemon-news-export-manager.php");


/*==============
	Actions
================*/
add_action( 'widgets_init', create_function( "", "register_widget( 'LemonNewsWidget' );" ) );
add_action( 'plugins_loaded', 'load_lemon_news' );
add_shortcode( 'lemonnews', "add_lemon_news" );

register_activation_hook( __FILE__, "init_lemon_news_activation" );
register_deactivation_hook( __FILE__, "init_lemon_news_deactivation" );

// Ajax actions
add_action( 'wp_ajax_nopriv_submit_lemon_news', array("LemonNewsWidget", 'submit_lemon_news_widget') );
add_action( 'wp_ajax_submit_lemon_news', array("LemonNewsWidget", 'submit_lemon_news_widget') );
add_action( 'wp_ajax_change_email_list_page', array("LemonNewsAdmin", 'change_email_list_page') );
add_action( 'wp_ajax_update_email', array("LemonNewsAdmin", 'update_email') );

/*==============
	Functions
================*/

/**
 * Runs on plugin load
 */
function load_lemon_news()
{
	load_plugin_textdomain( 'LemonNewsDomain', false, LEMONJUICE_PLUGIN_LANGUAGES_PATH );
	if (is_admin()) $adm = new LemonNewsAdmin();
}

/**
 * Runs on plugin install
 */
function init_lemon_news_activation()
{
	$inst = new LemonNewsInstaller();
	$inst->activate();
}

/**
 * Runs on plugin deactivation
 */
function init_lemon_news_deactivation()
{
	$inst = new LemonNewsInstaller();
	$inst->deactivate();
}

/**
 * Function called by shortcode or manually that instantiates the widget
 */
function add_lemon_news()
{
	the_widget( "LemonNewsWidget" );
}

/**
 * Debugging function. Nothing for you here.
 */
if (!function_exists('dump')) {
	function dump($value)
	{
		require_once LEMONJUICE_PLUGIN_VIEWS_PATH . "view-debug.php";
	}
}













