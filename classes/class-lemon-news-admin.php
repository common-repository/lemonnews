<?php


/**
* LemonNewsAdmin
* Manages the admin section of the plugin
* @author Vitor Rigoni vitor@lemonjuicewebapps.com
* @version 1.0
* @package LemonNews
*/
class LemonNewsAdmin extends LemonNewsToolkit
{
	/**
	 * Number of items to be displayed each page inside the e-mails list
	 * @var int
	 */
	private $itemsPerPage;

	/**
	 * Options of data export
	 * @var array
	 */
	private $extensions = array('txt', 'xls', 'xml', 'csv');

	/**
	 * Used for search
	 * @var array
	 */
	private $searchData;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->itemsPerPage = 25;

		if (isset($_GET['deleted']))
			$this->set_flash(__("E-mail successfully deleted.", 'LemonNewsDomain'), 'success');

		if (isset($_GET['action'])) {
			$act = $_GET['action'];

			if ($act == 'export')
				$this->export($_GET['ext']);

			if ($act == 'delete')
				$this->delete_email($_GET['id']);

			if ($act == 'search') {
				$this->search_email();
			}

			if ($act == 'save') {
				$this->save();
			}

		}

		add_action( "admin_menu", array($this, "add_lemon_news_menu_page") );
		add_action( "admin_init", array($this, "lemon_news_tinymce_button") );

	}

	/**
	 * Adds the menu to the wordpress panel
	 */
	public function add_lemon_news_menu_page()
	{
		add_menu_page( LEMONJUICE_PLUGIN_NAME, LEMONJUICE_PLUGIN_NAME, "manage_options", LEMONJUICE_PLUGIN_SHORTNAME, array($this, "index"), $icon_url = LEMONJUICE_PLUGIN_IMAGES_URL . "icon-lemonnews-16x16.png", $position = null );
	}

	/**
	 * Adds filters for the tinyMCE button
	 */
	public function lemon_news_tinymce_button()
	{
		add_filter( "mce_external_plugins", array($this, "lemon_news_add_buttons") );
    	add_filter( 'mce_buttons', array($this, 'lemon_news_register_buttons') );
	}

	/**
	 * Used internally for adding the button to the tinymce editor
	 */
	public function lemon_news_add_buttons($plugin_array)
	{
		$plugin_array['lemon_news'] = LEMONJUICE_PLUGIN_SCRIPTS_URL . "tinymce-buttons.js";
		return $plugin_array;
	}

	/**
	 * Used internally for adding the button to the tinymce editor
	 */
	public function lemon_news_register_buttons($buttons)
	{
		array_push( $buttons, 'lemon_news_shortcode_button' );
		return $buttons;
	}

	/**
	 * Main admin page. Manages everything about it
	 * @return html rendered view
	 */
	public function index()
	{
		$this->register_styles_scripts();

		$model = new LemonNewsModel();
		$w = new LemonNewsWidget();

		$data = $model->getOptions();

		if (isset($_SESSION['lemon-news-search'])) {
			$data['search'] = true;
			$data['searchData'] = $this->searchData;
		}

		$data['userHelp'] = $data['lemon_news_user_help'];
		$data['formStyle'] = $data['lemon_news_style'];
		$data['widStyle'] = $w->getWidStyle();

		if (!$data['lemon_news_custom_styles'])
			$data['customCss'] = file_get_contents(LEMONJUICE_PLUGIN_STYLES_URL.'blank-styles.css');
		else
			$data['customCss'] = $data['lemon_news_custom_styles'];

		$data['nonce'] = wp_create_nonce( "lemon_news_nonce_admin" );

		$data['emailsList'] = $model->select_emails_chunk(0, $this->itemsPerPage);
		$data['countEmails'] = $model->select_count_emails();
		$data['pageQuantity'] = ceil($data['countEmails'] / $this->itemsPerPage);

		$this->render('view-lemon-news-admin', $data);
		$this->clear_flash();

	}

	/**
	 * Used for the ajax pagination inside the admin panel
	 * @return html rendered table data
	 */
	function change_email_list_page()
	{
		$model = new LemonNewsModel();
		$admin = new LemonNewsAdmin();
		$fullList = $model->select_emails_chunk($admin->itemsPerPage * $_POST['page'], $admin->itemsPerPage);
		
		$data['emailsList'] = $fullList;

		$admin->render('view-email-list-table', $data);
		die();
	}

	/**
	 * Handles ajax update request
	 * @return string True if successfully updated, or false
	 */
	function update_email()
	{
		$nonce = $_POST['nonce'];
		$id = $_POST['id'];
		$email = $_POST['email'];
		$model = new LemonNewsModel();

		if ((!wp_verify_nonce( $nonce, "lemon_news_nonce_admin" )) ||
			(!filter_var($email, FILTER_VALIDATE_EMAIL)) ||
			($model->select_count_emails_with_id($id) == 0)){
				echo "false";
				die();
		} else {
			$model->update_email($id, $email);
			echo "true";
		}
		
		die();
	}

	/**
	 * Handles e-mail deletion
	 * @param  int $id Id of the registry to be deleted
	 */
	function delete_email($id = null)
	{
		$model = new LemonNewsModel();

		if ($id == null) {
			$this->set_flash(__("Invalid e-mail.", 'LemonNewsDomain'), 'error');
			return;
		}

		if ($model->select_count_emails_with_id($id) == 0) {
			$this->set_flash(__("The selected e-mail is not registered in our database.", 'LemonNewsDomain'), 'error');
			return;	
		}

		if ($model->delete_email($id)) {
			$this->redirect("?page=lemon-news&deleted=true");
		}

	}

	/**
	 * Sets seach data so the index() method can handle it
	 */
	function search_email()
	{
		$_SESSION['lemon-news-search'] = true;
		$model = new LemonNewsModel();

		$email = $_POST['lemon-news-search'];

		$this->searchData = $model->search($email);
	}

	/**
	 * Handles the export request, directing the export manager to export the correct file type
	 * @param  string $ext file type desired
	 * @return bin      exported file
	 */
	function export($ext)
	{
		if (!in_array($ext, $this->extensions)) {
			$this->set_flash(__("Unavailable export file type.", 'LemonNewsDomain'), 'error');
			return;
		}

	    $export = new LemonNewsExportManager();

		if ($ext == "txt")
	        $export->export_txt();
	    else if ($ext == 'xls')
	    	$export->export_xls();
	    else if ($ext == 'xml')
	    	$export->export_xml();
	    else if ($ext == 'csv')
	    	$export->export_csv();
		else
		    $this->set_flash(__('There was a problem writing the file. Please try reinstalling this plugin or contact us at contact@lemonjuicewebapps.com', 'LemonNewsDomain'), 'error');
		    
	}

	function save()
	{
		$model = new LemonNewsModel();
		$model->updateOptions($_POST['data']);

		$this->set_flash(__("Options updated successfully!", 'LemonNewsDomain'), 'success');
	}

	/**
	 * Helper method to register required styles and scripts
	 */
	function register_styles_scripts()
	{
		$this->register_jquery();
		$this->register_bootstrap_script();
		$this->register_metro_bootstrap();
		$this->register_lemon_news_admin_script();
		$this->register_lemon_news_admin_style();
		$this->register_alertify();
		wp_localize_script( 'lemon-news-admin-script', 'ajax_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'plugins_url' => LEMONJUICE_PLUGIN_URL,
			'msg_success' => __("E-mail change saved successfully!", 'LemonNewsDomain'),
			'msg_error' => __("There was a problem with your request!", 'LemonNewsDomain'),
			'msg_confirm_delete' => __("Are you sure you want to delete this record?", 'LemonNewsDomain'),
			'yes' => __('Yes', 'LemonNewsDomain'),
			'cancel' => __('Cancel', 'LemonNewsDomain')
			)
		);
	}
}



















