<?php

/**
 * Widget
 * @author Vitor Rigoni <vitor@lemonjuicewebapps.com>
 * @version 1.0
 * @package LemonNews
 */
class LemonNewsWidget extends WP_Widget {

    /**
     * Widget Title
     * @var string
     */
	private $widgetTitle;

    /**
     * Styling possibilities for the widget. These are preset
     * @var array
     */
    private $widStyle = array(
        'CustomCss' => array('name' => 'Custom Css', 'slug' => 'CustomCss'),
        'LemonJuiceStyle' => array('name' => 'Lemon Juice Style', 'slug' => 'LemonJuiceStyle', 'color' => '#8BA022', 'hover' => '#A2BA28', 'roundBorder' => false),
        'Bloo' => array('name' => 'Bloo', 'color' => '#2886BA', 'slug' => 'Bloo', 'hover' => '#65A3C6', 'roundBorder' => false),
        'LemonJuiceStyleRounded' => array('name' => 'Lemon Juice Style Rounded', 'slug' => 'LemonJuiceStyleRounded', 'color' => '#8BA022', 'hover' => '#A2BA28', 'roundBorder' => true),
        'BlooRounded' => array('name' => 'Bloo Rounded', 'color' => '#2886BA', 'slug' => 'BlooRounded', 'hover' => '#65A3C6', 'roundBorder' => true),
        'Neutrality' => array('name' => 'Neutrality', 'slug' => 'Neutrality', 'color' => '#bfbfbf', 'hover' => '#a0a0a0', 'roundBorder' => false),
        'NeutralityRounded' => array('name' => 'Neutrality Rounded', 'slug' => 'NeutralityRounded', 'color' => '#bfbfbf', 'hover' => '#a0a0a0', 'roundBorder' => true)
    );

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'widget-lemon-news', 'description' => 'LemonNews Widget' );
        $this->WP_Widget( 'widget-lemon-news', 'LemonNews', $widget_ops );
        $this->widgetTitle = LEMONJUICE_PLUGIN_NAME;
    }

    /**
     * Getter for widStyle property
     * @return array
     */
    public function getWidStyle()
    {
        return $this->widStyle;
    }

    public function getSelectedStyle()
    {
        $style = get_option('lemon_news_style');

        return $this->widStyle[$style];
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        echo $before_widget;
        echo $before_title;
        echo $after_title;
        global $wp_styles;

        wp_register_style( 'lemon-news-widget-style', $src = LEMONJUICE_PLUGIN_STYLES_URL . "lemon-news-widget-style.php", $deps = array(), $ver = null, $media = 'all' ) ;
        wp_enqueue_style( 'lemon-news-widget-style' );


        $toolkit = new LemonNewsToolkit();
        $toolkit->register_jquery();
        $toolkit->register_lemon_news_widget_script();

        $data['nonce'] = wp_create_nonce( "lemon-news-widget-nonce-action" );
        $data['userHelp'] = get_option('lemon_news_user_help');

        wp_localize_script( 'lemon-news-widget', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
        $toolkit->render( "view-lemon-news-widget", $data );

    	echo $after_widget;
    }

    /**
     * Handles widget form submission
     * @return json response
     */
    function submit_lemon_news_widget()
    {
    	$email = array( 'email' => strtolower(sanitize_email( $_POST['email'])) );
    	$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

    	$data['message'] = "";
    	$data['cssClass'] = "";

		$model = new LemonNewsModel();

        if (!wp_verify_nonce( $nonce, "lemon-news-widget-nonce-action" )) {
            $data['message'] = __("There was a security problem with your request.", 'LemonNewsDomain');
            $data['cssClass'] = 'error';
        } else if (!filter_var($email['email'], FILTER_VALIDATE_EMAIL)) {
            $data['message'] = __("Please insert a valid e-mail adress.", 'LemonNewsDomain');
            $data['cssClass'] = 'error';
        } else if ($model->select_count_emails($email['email']) > 0) {
            $data['message'] = __("This e-mail address is already registered!", 'LemonNewsDomain');
            $data['cssClass'] = 'warning';
        } else if (!$model->insert_email($email)) {
			$data['message'] = __("There was an error while registering your e-mail.", 'LemonNewsDomain');
			$data['cssClass'] = 'error';
		} else {
    		$data['message'] = __("E-mail successfully registered!", 'LemonNewsDomain');
    		$data['cssClass'] = 'success';
        }

    	echo json_encode($data);
    	die();
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
    function update( $new_instance, $old_instance ) {
    
        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
    function form( $instance ) {
        // $instance = wp_parse_args( (array) $instance, array( array of option_name => value pairs ) );

        // display field names here using:
        // $this->get_field_id( 'option_name' ) - the CSS ID
        // $this->get_field_name( 'option_name' ) - the HTML name
        // $instance['option_name'] - the option value
    }
}