<?php

/**
* Handles activation and de-activation
* @author Vitor Rigoni vitor@lemonjuicewebapps.com
* @version 1.0
* @package LemonNews
*/
class LemonNewsInstaller extends LemonNewsToolkit
{
	/**
	 * wordpress installation table prefix
	 * @var string
	 */
	private $tablePrefix;

	/**
	 * Class constructor
	 */
	function __construct()
	{
		global $wpdb;
		$this->tablePrefix = $wpdb->prefix;
	}

	/**
	 * Handles plugin activation. Create tables required for the plugin to work
	 */
	public function activate()
	{
		global $wpdb;
		$sql = "CREATE TABLE IF NOT EXISTS ".$this->tablePrefix."lemon_news
				(
					id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
					date_created VARCHAR(20) NOT NULL,
					date_modified VARCHAR(20) NULL,
					email VARCHAR(255) NOT NULL
				)";

		add_option( 'lemon_news_user_help' );
		add_option( 'lemon_news_style', 'LemonJuiceStyle' );

		if (!$wpdb->query($sql))
			$this->set_flash(__("There was an <b>error</b> while installing your plugin. Please contact LemonJuice about your problem at: contact@lemonjuicewebapps.com", 'LemonNewsDomain'), 'error');	
	}

	/**
	 * Supposed to handle plugin deactivation, but I haven't found a use for it yet.
	 */
	public function deactivate()
	{
		
	}

}