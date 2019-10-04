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
		$this->outputZone();

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
	public function outputZone() {
		add_action( 'wp_head',array(&$this, 'outputGDPR')); 
	}

	public function outputGDPR(){
		$zn_privacy_policy = !empty(get_option('zn_privacy_policy')) ?  get_option('zn_privacy_policy') : '/privacy-policy';
		$zn_cookie_policy = !empty(get_option('zn_cookie_policy')) ?  get_option('zn_cookie_policy') : '/cookie-policy';
		$zn_terms_conditions = !empty(get_option('zn_terms_conditions')) ?  get_option('zn_terms_conditions') : '/terms-and-conditions';	
		$zn_description = get_option('zn_description');
		$zn_position = get_option('zn_position');
		$zn_layout = get_option('zn_layout');
		$zn_color_banner = get_option('zn_color_banner');
		$zn_color_banner_text = get_option('zn_color_banner_text');
		$zn_color_button = get_option('zn_color_button');
		$zn_color_button_text = get_option('zn_color_button_text');
		$zn_compliance = get_option('zn_compliance');
		$zn_allow_cookies = get_option('zn_allow_cookies');
		$zn_refuse_cookies = get_option('zn_refuse_cookies');

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
