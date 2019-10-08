<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Gdpr
 * @subpackage Zone_Gdpr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_Gdpr
 * @subpackage Zone_Gdpr/admin
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */

require_once(plugin_dir_path(__FILE__) . '../model/model.php');

class Zone_Gdpr_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.w
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->insert = new Zone_Gdpr_Model_Insert();
		$this->display = new Zone_Gdpr_Model_Display();
		$this->update = new Zone_Gdpr_Model_Update();
		$this->deployZone();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Zone_Gdpr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zone_Gdpr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zone-gdpr-admin.css', array(), $this->version, 'all' );
		/* Bootstrap 4 CSS */
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
		wp_enqueue_style( $this->plugin_name.'-cookieconsentcss', plugin_dir_url( __FILE__ ) . 'css/cookieconsent/cookieconsent.min.css', array(), $this->version, 'all' );
		wp_enqueue_style('zone-datatable-css', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.css', array(), $this->version);
		wp_enqueue_style('zone-pnotify', plugin_dir_url(__FILE__) . 'css/pnotify/pnotify.css', array(), $this->version);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Zone_Gdpr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zone_Gdpr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/zone-gdpr-admin.js', array( 'jquery' ), $this->version, false );
		/* Bootstrap 4 JS */
		echo '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>';
		wp_enqueue_script( $this->plugin_name.'-script', plugin_dir_url( __FILE__ ) . 'js/cookieconsent/script.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-cookieconsentjs', plugin_dir_url( __FILE__ ) . 'js/cookieconsent/cookieconsent.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-fontawesome', '//kit.fontawesome.com/38c326fd94.js', array( 'jquery' ), '5.9.0', false );
		wp_enqueue_script('zone-pnotify', plugin_dir_url(__FILE__) . 'js/pnotify/pnotify.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-datatable-js', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-gdpr-ajax', plugin_dir_url(__FILE__)  . 'js/zone-gdpr-ajax.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_localize_script('zone-gdpr-ajax', 'gdprsettingsAjax', array('ajax_url' => admin_url('admin-ajax.php')));
	}
	
	public function deployZone() {
		add_action( 'admin_init', array(&$this, 'gdpr_save_settings_post'));
		add_action('admin_menu',array(&$this, 'zoneOptions'));
	}

	/**
	* Register Theme Options
	*/
	public function zoneOptions(){
		  add_menu_page(
			  'Zone GDPR', 	//Page Title
			  'Zone GDPR',   //Menu Title
			  'manage_options', 			//Capability
			  'zone-gdpr', 				//Page ID
			  array(&$this, 'zoneOptionsPage'),		//Functions
			  'dashicons-lock', 						//Favicon
			  99							//Position
		  );
	}

	/**
	 * Theme Options Page
	 */
	public function zoneOptionsPage(){
		$tbl_request = $this->display->getAllRequest();
		$tbl_content = $this->display->getGDPRContent();
		$tbl_layout = $this->display->getGDPRLayout();
		require_once('view/zone-main-display.php');
		wp_enqueue_script( $this->plugin_name.'-function', plugin_dir_url( __FILE__ ) . 'js/zone-gdpr-function.js', array( 'jquery' ), '1.0.0', false );
	}
	public function gdpr_save_settings_post(){
		add_option( 'zn_position', 'default' );
		add_option( 'zn_layout', 'default' );
		add_option( 'zn_color_banner', '#0D9D96' );
		add_option( 'zn_color_banner_text', '#FFFFFF' );
		add_option( 'zn_color_button', '#FFFFFF' );
		add_option( 'zn_color_button_text', '#0D9D96' );
		add_option( 'zn_compliance', 'default' );
		
		/** Options */
		register_setting( 'option-group', 'zn_privacy_policy' );
		register_setting( 'option-group', 'zn_cookie_policy' );
		register_setting( 'option-group', 'zn_terms_conditions' );
		register_setting( 'option-group', 'zn_description' );
		register_setting( 'option-group', 'zn_allow_cookies' );
		register_setting( 'option-group', 'zn_refuse_cookies' );
		register_setting( 'option-group', 'zn_position' );
		register_setting( 'option-group', 'zn_layout' );
		register_setting( 'option-group', 'zn_color_banner' );
		register_setting( 'option-group', 'zn_color_banner_text' );
		register_setting( 'option-group', 'zn_color_button' );
		register_setting( 'option-group', 'zn_color_button_text' );
		register_setting( 'option-group', 'zn_compliance' );
	}
}