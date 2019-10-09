<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Gdpr
 * @subpackage Zone_Gdpr/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Zone_Gdpr
 * @subpackage Zone_Gdpr/public
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */

require_once(plugin_dir_path(__FILE__) . '../model/model.php');

class Zone_Gdpr_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->insert = new Zone_Gdpr_Model_Insert();
		$this->display = new Zone_Gdpr_Model_Display();
		$this->update = new Zone_Gdpr_Model_Update();
		$this->deployPublicZone();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zone-gdpr-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-cookieconsentcss', plugin_dir_url( __FILE__ ) . 'css/cookieconsent/cookieconsent.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/zone-gdpr-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-publicscript', plugin_dir_url( __FILE__ ) . 'js/cookieconsent/script.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-cookieconsentpublicjs', plugin_dir_url( __FILE__ ) . 'js/cookieconsent/cookieconsent.min.js', array( 'jquery' ), $this->version, false );
		

	}

	/**
	 * Outputs the GDPR Zone on the frontend
	 */
	public function deployPublicZone() {
		add_shortcode('zone-gdpr-content', array(&$this, 'zoneGdprContent'));
		add_shortcode('zone-gdpr-request', array(&$this, 'zoneGdprFormRequest'));
		add_action( 'wp_head',array(&$this, 'outputGDPR')); 
	}

	public function zoneGdprContent() {
		$tbl_content = $this->display->getGDPRContent();
		$tbl_layout = $this->display->getGDPRLayout();
		return require_once('view/templates/gdpr-content.php');
	}

	public function zoneGdprFormRequest() {
		$tbl_request_type = $this->display->getRequestType();
		return require_once('view/templates/gdpr-request-form.php');
	}

	public function outputGDPR(){
		$tbl_content = $this->display->getGDPRContent();
		$tbl_layout = $this->display->getGDPRLayout();

		$zn_privacy_policy = $tbl_content[0]['Privacy_Policy_Link'];
		$zn_cookie_policy = $tbl_content[0]['Cookie_Policy_Link'];
		$zn_terms_conditions = $tbl_content[0]['Terms_and_Condition_Link'];	
		$zn_description =  $tbl_content[0]['Message'];
		$zn_position = $tbl_layout[0]['Position'];
		$zn_layout = $tbl_layout[0]['Layout'];
		$zn_color_banner = $tbl_layout[0]['Color_Banner'];
		$zn_color_banner_text = $tbl_layout[0]['Color_Banner_Text'];
		$zn_color_button = $tbl_layout[0]['Color_Button'];
		$zn_color_button_text = $tbl_layout[0]['Color_Button_Text'];
		$zn_compliance = $tbl_layout[0]['Compliance'];
		$zn_allow_cookies = $tbl_content[0]['Allow_Button'];
		$zn_refuse_cookies = $tbl_content[0]['Deny_Button'];

		// echo '<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>';
		if ($zn_position == 'default' || $zn_layout == 'default') {
				$consent = '<script type="text/javascript">
							window.addEventListener("load", function(){
								window.cookieconsent.initialise({
									"palette": {
										"popup": {
											"background": "'.$zn_color_banner.'",
											"text": "'.$zn_color_banner_text.'"
										},
										"button": {
											"background": "'.$zn_color_button.'",
											"text": "'.$zn_color_button_text.'"
										}
									},
									"type": "'.$zn_compliance.'",
									"showLink": false,
									"content": {
										"message": "'.$zn_description.'",
										"allow": "'.$zn_allow_cookies.'",
										"dismiss": "'.$zn_allow_cookies.'",
										"deny": "'.$zn_refuse_cookies.'"
									}
								}, function (popup) {
									p2 = popup;
								}, function (err) {
									console.error(err);
								})
							});
						</script>';

			} else {
				$consent = '<script type="text/javascript">
					window.addEventListener("load", function(){
						window.cookieconsent.initialise({
							"palette": {
								"popup": {
									"background": "'.$zn_color_banner.'",
									"text": "'.$zn_color_banner_text.'"
								},
								"button": {
									"background": "'.$zn_color_button.'",
									"text": "'.$zn_color_button_text.'"
								}
							},
							"position": "'.$zn_position.'",
							"theme": "'.$zn_layout.'",
							"type": "'.$zn_compliance.'",
							"showLink": false,
							"content": {
								"message": "'.$zn_description.'",
								"allow": "'.$zn_allow_cookies.'",
								"dismiss": "'.$zn_allow_cookies.'",
								"deny": "'.$zn_refuse_cookies.'"
							}
						}, function (popup) {
							p = popup;
						}, function (err) {
							console.error(err);
						})
					});
				</script>';
		}
		echo $consent;	
	}
}
