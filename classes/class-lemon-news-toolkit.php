<?php

/**
* Toolkit. Contains various methods that most classes need
* @author Vitor Rigoni <vitor@lemonjuicewebapps.com>
* @version 1.0
* @package LemonNews
*/
class LemonNewsToolkit
{
	/**
	 * Class constructor. Nothing to do here.
	 */
	function __construct()
	{
		
	}

	/**
	 * Renders a view. What else to say?
	 * @param  string $view The view to be rendered
	 * @param  array  $data Data to be passed to the view
	 * @return html       Rendered view
	 */
	public function render($view = "", $data = array())
	{
		$data = array_merge($data);
		extract($data);
		require_once LEMONJUICE_PLUGIN_VIEWS_PATH . $view . ".php";
	}


	/**
	 * Sets a flash message
	 * @param string $message Message to be displayed for the user
	 * @param string $class   CSS class so we can style the message =)
	 */
	public function set_flash($message = "", $class = "updated")
	{
		$_SESSION['flash-class'] = $class;
		$_SESSION['flash-message'] = $message;
		$_SESSION['flash'] = true;
	}

	/**
	 * Clears the session containing the flash message
	 */
	public function clear_flash()
	{
		if (isset($_SESSION)) {
			unset($_SESSION['flash-class']);
			unset($_SESSION['flash-message']);
			unset($_SESSION['flash']);
		}
	}

	/**
	 * Helper method for redirecting the user to a new location
	 * @param  string $url the url to be used
	 */
	public function redirect($url = "")
	{
		header("Location: $url");
	}

	/**
	 * Register jQuery from googleapis
	 */
	public function register_jquery()
	{
		// wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js", $deps = array(), $ver = false, $in_footer = true );
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Register twitter bootstrap's scripts
	 */
	public function register_bootstrap_script()
	{
		wp_register_script( 'bootstrap', LEMONJUICE_PLUGIN_SCRIPTS_URL . "bootstrap.min.js", array('jquery'), $ver = null, $in_footer = true );
		wp_enqueue_script( 'bootstrap' );
	}

	/**
	 * Register metro-bootstrap styles
	 */
	public function register_metro_bootstrap()
	{
		wp_register_style( 'metro-boostrap', LEMONJUICE_PLUGIN_STYLES_URL . "metro-bootstrap.css", $deps = array(), $ver = null, $media = 'all' );
		wp_enqueue_style( 'metro-boostrap' );
	}

	/**
	 * Register LemonNews widget scripts
	 */
	public function register_lemon_news_widget_script()
	{
		wp_register_script( 'lemon-news-widget', LEMONJUICE_PLUGIN_SCRIPTS_URL . "lemon-news-widget.js", array('jquery'), $ver = null, $in_footer = true );
		wp_enqueue_script( 'lemon-news-widget' );
	}

	/**
	 * Register LemonNews admin scripts
	 */
	public function register_lemon_news_admin_script()
	{
		wp_register_script( 'lemon-news-admin-script', LEMONJUICE_PLUGIN_SCRIPTS_URL . "lemon-news-admin-script.js", array('jquery'), $ver = null, $in_footer = true );
		wp_enqueue_script( 'lemon-news-admin-script' );
	}

	/**
	 * Register LemonNews admin styles
	 */
	public function register_lemon_news_admin_style()
	{
		wp_register_style( 'lemon-news-admin-style', LEMONJUICE_PLUGIN_STYLES_URL . "lemon-news-admin-styles.css", $deps = array(), $ver = null, $media = 'all' );
		wp_enqueue_style( 'lemon-news-admin-style' );
	}

	/**
	 * Registers everything about alertify
	 */
	public function register_alertify()
	{
		wp_register_script( 'alertify-script', LEMONJUICE_PLUGIN_SCRIPTS_URL . "alertify.min.js", $deps = array(), $ver = null, $in_footer = true );
		wp_register_style( 'alertify-style-core', LEMONJUICE_PLUGIN_STYLES_URL . "alertify.core.css", $deps = array('metro-boostrap'), $ver = null, $media = 'all' );
		wp_register_style( 'alertify-style-bootstrap', LEMONJUICE_PLUGIN_STYLES_URL . "alertify.bootstrap.css", $deps = array('alertify-style-core'), $ver = null, $media = 'all' );
		wp_enqueue_style( 'alertify-style-core' );
		wp_enqueue_style( 'alertify-style-bootstrap' );
		wp_enqueue_script( 'alertify-script' );
	}
}





















