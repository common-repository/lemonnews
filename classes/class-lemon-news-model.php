<?php


/**
* Handles all database related requests
* @author Vitor Rigoni <vitor@lemonjuicewebapps.com>
* @version 1.0
* @package LemonNews
*/
class LemonNewsModel
{
	/**
	 * plugin table (yes, we need one =P)
	 * @var string
	 */
	private $table = "lemon_news";

	/**
	 * holds the full name of the table, using the wordpress installation tables prefix
	 * @var string
	 */
	private $tableFullName;

	/**
	 * Class constructor
	 */
	function __construct()
	{
		global $wpdb;
		$this->tableFullName = $wpdb->prefix . $this->table;
		setlocale(LC_ALL, get_locale());
	}

	/**
	 * Handles data insertion inside database
	 * @param  array  $userData Data sent by the user, already sanitized by the controller
	 * @return bool           true if inserted, or false
	 */
	function insert_email($userData = array())
	{
		global $wpdb;

		$fixedData = array( 'date_created' =>  strftime("%e %B %Y") );
		$data = array_merge($userData, $fixedData);

		if (empty($data['email']))
			return false;

		if ($wpdb->insert(
				$this->tableFullName,
				$data
			)) return true;
		else
			return false;
	}

	/**
	 * Updates an e-mail inside the database
	 * @param  int $id    Id of the registry to be updated
	 * @param  string $email new e-mail
	 * @return bool        true if successful, or false
	 */
	function update_email($id, $email)
	{
		global $wpdb;

		$set['email'] = $email;
		$set['date_modified'] = strftime("%e %B %Y");
		$where['id'] = $id;

		return $wpdb->update(
				$this->tableFullName,
				$set,
				$where
			);
	}

	function delete_email($id)
	{
		global $wpdb;

		$where['id'] = $id;

		return $wpdb->delete(
				$this->tableFullName,
				$where,
				array('%d')
			);
	}

	/**
	 * Selects a single e-mail from the database
	 * @param  string $email e-mail to be selected
	 * @return object        object containing information. false if nothing found
	 */
	function select_single_email($email)
	{
		global $wpdb;

		$sql = $wpdb->prepare("SELECT * FROM $this->tableFullName WHERE email = '%s'", $email);

		return $wpdb->get_row( $sql, object );
	}

	/**
	 * Multipurpose function to count the database. If no parameter is passed, it'll count all the e-mails registered.
	 * @param  string $email e-mail to be accounted for
	 * @return int        quantity found
	 */
	function select_count_emails($email = '')
	{
		global $wpdb;

		if (empty($email))
			$sql = "SELECT COUNT(*) FROM $this->tableFullName";
		else
			$sql = $wpdb->prepare("SELECT COUNT(*) FROM $this->tableFullName WHERE email = '%s'", $email);
		
		$count = $wpdb->get_row($sql, ARRAY_A);

		return (int)$count['COUNT(*)'];
	}

	/**
	 * Checks for the existance of and e-mail by ID
	 * @param  int $id id of the e-mail to be checked
	 * @return int     quantity found
	 */
	function select_count_emails_with_id($id)
	{
		global $wpdb;

		$sql = $wpdb->prepare( "SELECT COUNT(*) FROM $this->tableFullName where id = %f", $id );

		$count = $wpdb->get_row($sql, ARRAY_A);

		return (int)$count['COUNT(*)'];
	}

	/**
	 * Selects all data. With great power, comes great responsibility.
	 * @return array array of data
	 */
	function select_emails()
	{
		global $wpdb;

		$sql = "SELECT * FROM $this->tableFullName";

		return $wpdb->get_results($sql);
	}

	/**
	 * Selects a range of data
	 * @param  int $start from where to start
	 * @param  int $end   where to end
	 * @return array        data
	 */
	function select_emails_chunk($start, $end)
	{
		global $wpdb;

		$sql = $wpdb->prepare("SELECT * FROM $this->tableFullName LIMIT %d, %d", $start, $end);
		
		return $wpdb->get_results($sql);
	}

	/**
	 * Searches for an e-mail inside the database
	 * @param  string $email e-mail to be searched
	 * @return array|false        data found or false 
	 */
	function search($email = '')
	{
		global $wpdb;

		if (!empty($email)) {
			$email = like_escape( $email );
			return $wpdb->get_results("SELECT * FROM $this->tableFullName WHERE email LIKE '%$email%';");
		} else {
			return false;
		}
	}

	/**
	 * Retrieves options from the database
	 * @return array data containing the saved options
	 */
	function getOptions()
	{
		$data = array();

		$data['lemon_news_user_help'] = get_option( 'lemon_news_user_help' );
		$data['lemon_news_style'] = get_option( 'lemon_news_style' );
		$data['lemon_news_custom_styles'] = get_option( 'lemon_news_custom_styles' );

		return $data;
	}

	/**
	 * Updates options inside the database
	 * @param  array $data array containing the two options to be updated
	 */
	function updateOptions($data)
	{
		update_option( 'lemon_news_user_help', esc_html( $data['userHelp'] ) );
		update_option( 'lemon_news_style', esc_html( $data['formStyle'] ) );
		update_option( 'lemon_news_custom_styles', esc_html( $data['customCss'] ) );
	}

}




















