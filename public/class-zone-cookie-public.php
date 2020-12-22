<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/public
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
if (!defined('ABSPATH')) {
	exit;
}

class Zone_Cookie_Public {

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
		$this->insert = new Zone_Cookie_Model_Insert();
		$this->display = new Zone_Cookie_Model_Display();
		$this->update = new Zone_Cookie_Model_Update();
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
		 * defined in Zone_Cookie_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zone_Cookie_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zone-cookie-public.css', array(), $this->version, 'all' );
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
		 * defined in Zone_Cookie_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zone_Cookie_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/zone-cookie-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-publicscript', plugin_dir_url( __FILE__ ) . 'js/cookieconsent/script.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-cookieconsentpublicjs', plugin_dir_url( __FILE__ ) . 'js/cookieconsent/cookieconsent.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('zone-cookie-ajax', plugin_dir_url(__FILE__)  . 'js/zone-cookie-public-ajax.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_localize_script('zone-cookie-ajax', 'cookiesettingsAjax', array('ajax_url' => admin_url('admin-ajax.php'), 'ajax_nonce'=>wp_create_nonce('zn-ajax-nonce')));
	}

	/**
	 * Outputs the GDPR Zone on the frontend
	 */
	public function deployPublicZone() {
		add_shortcode('zone-gdpr-content', array(&$this, 'zoneGdprContent'));
		add_shortcode('zone-ccpa-content', array(&$this, 'zoneCcpaContent'));
		add_shortcode('zone-compliance-form', array(&$this, 'zoneGdprFormRequest'));
		add_action( 'wp_head',array(&$this, 'outputGDPR'));
		add_action('wp_ajax_nopriv_zoneGdprRequest',  array(&$this, 'zoneGdprRequest'));
		add_action('wp_ajax_zoneGdprRequest',  array(&$this, 'zoneGdprRequest'));
	}

	public function zoneGdprContent() {

		$tbl_content = $this->display->getCookieContent();
		ob_start();
		require_once('view/templates/gdpr-content.php');
		return ob_get_clean();
	}

	public function zoneCcpaContent() {
		$tbl_content = $this->display->getCookieContent();
		ob_start();
		require_once('view/templates/ccpa-content.php');
		return ob_get_clean();
	}

	public function zoneGdprRequest(){
		if(check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$req_fname = sanitize_text_field($_POST['req_fname']);
			$req_lname = sanitize_text_field($_POST['req_lname']);
			$req_phone = sanitize_text_field($_POST['req_phone']);
			$req_email = sanitize_text_field($_POST['req_email']);
			$req_city = '';
			$req_state = '';
			$req_type = sanitize_text_field($_POST['req_type']);
			$req_message = sanitize_text_field($_POST['req_message']);
			$tbl_requester = $this->insert->setNewRequester($req_fname, $req_lname, $req_phone, $req_email, $req_city, $req_state);
			$zn_requesterID = $this->display->getLastRequester();
			$tbl_request = $this->insert->setNewRequest($zn_requesterID, $req_type, $req_message);
			$settings = $this->display->getSettings();
			$zn_onEmails = $settings[0]['Email_Status'];
			if ($zn_onEmails) {
				$submitNotif = $this->emailSendingNotification($req_fname, $req_lname, $req_type);
			}
			if($tbl_requester && $tbl_request) {
				$data = 1;
			} else {
				$data = 0;
			}

		} else {
			wp_die(__('Invalid nonce specified', $this->plugin_name), __('Error', $this->plugin_name), array(
				'response' 	=> 403,
				'back_link' => 'admin.php?page=' . $this->plugin_name,
			));
		}
		echo $data;
		exit();
	}
	public function emailSendingNotification($zn_first_name, $zn_last_name, $req_type) {
		$settings = $this->display->getSettings();
		$zn_emailstats = $settings[0]['Email_Receiver'];
		$domain = 'noreply@' . preg_replace('/www\./i', '', get_home_url());

		$headers = 'From:' . $domain . '' . "\r\n";

		if ($zn_emailstats != '' || $zn_emailstats != null) {
			$to = esc_attr($zn_emailstats);
		} else {
			$to = get_option('admin_email');
		}

		$subject = 'New Information Request is submitted on the '. get_home_url();
		$message = 'Requester: ' . $zn_first_name . ' ' . $zn_last_name . '.<br>';
		$message .= 'Request Type: ' . $req_type .'.<br>';
		$message .= 'You can check it now <a href="' . get_home_url() . '/wp-admin/admin.php?page='.$this->plugin_name.'">HERE</a>';

		add_filter('wp_mail_content_type', array(&$this, 'set_html_content_type'));
		$response = wp_mail($to, $subject, $message, $headers);
		remove_filter('wp_mail_content_type', array(&$this, 'set_html_content_type'));

		if ($response) {
			return true;
		} else {
			return false;
		}
	}

	public function set_html_content_type() {
		return 'text/html';
	}

	public function zoneGdprFormRequest() {
		$tbl_request_type = $this->display->getAvailableRequestType();
		ob_start();
		require_once('view/templates/request-form.php');
		return ob_get_clean();
	}

	public function outputGDPR(){
		$tbl_content = $this->display->getCookieContent();
		$tbl_layout = $this->display->getGDPRLayout();

		$zn_consent = "";
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

		$tempo_privacy = "<a style='color:".$zn_color_banner_text."; text-decoration: underline;' href=".$zn_privacy_policy."> Privacy Policy</a>";
		$tempo_cookie = "<a style='color:".$zn_color_banner_text."; text-decoration: underline;' href=".$zn_cookie_policy."> Cookie Policy</a>";
		$tempo_terms = "<a style='color:".$zn_color_banner_text."; text-decoration: underline;' href=".$zn_terms_conditions."> Terms of Use</a>";
		$zn_description = str_replace("{privacy-policy}", $tempo_privacy, $zn_description);
		$zn_description = str_replace("{cookie-policy}", $tempo_cookie, $zn_description);
		$zn_description = str_replace("{terms}", $tempo_terms, $zn_description);
		// Position Top Static
		if ($zn_position == 'top-static') {
			$zn_position = 'top';
			$static = true;
		} else {
			$static = false;
		}
		// Layout Wire
		$border = '';
		if ($zn_layout == 'wire') {
			$zn_color_button_text = $zn_color_button;
			$border = $zn_color_button;
			$zn_color_button= 'transparent';
		}
		// Allow orDismissal is x or X
		if($zn_allow_cookies == 'x' || $zn_allow_cookies == 'X') {
			$zn_consent .= "
				<style>
					/*Responsive*/
					@media screen and (max-width: 414px) and (min-width: 320px) {
						.cc-window.cc-banner {
							padding: 1em 1.8em!important;
						}
						
						.cc-window .cc-message {
							margin-bottom: 0 !important;
						}
						.cc-window.cc-floating {
							padding: 1em 1.8em!important;
						}
						.cc-window .cc-compliance {
							width: 35px;
							float: right;
							position: absolute;
							right: 0;
							margin-right: 1px;
						}
						.cc-window.cc-banner, .cc-window.cc-bottom {
							bottom: 0px;
							max-width: 100%!important;
							left: 0px;
							-webkit-transform: none;
							-ms-transform: translate(-50%,50%);
							transform: none;
						}
					}
				</style>
			";
		}
		//Position
		if ($zn_position == 'default') {
			$zn_consent .= '<script type="text/javascript">
							window.addEventListener("load", function(){
								window.cookieconsent.initialise({
									"palette": {
										"popup": {
											"background": "'.$zn_color_banner.'",
											"text": "'.$zn_color_banner_text.'"
										},
										"button": {
											"background": "'.$zn_color_button.'",
											"text": "'.$zn_color_button_text.'",
											"border": "'.$border.'"
										}
									},
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
									p2 = popup;
								}, function (err) {
									console.error(err);
								})
							});
						</script>
				';
			} else {
				$zn_consent .= '<script type="text/javascript">
					window.addEventListener("load", function(){
						window.cookieconsent.initialise({
							"palette": {
								"popup": {
									"background": "'.$zn_color_banner.'",
									"text": "'.$zn_color_banner_text.'"
								},
								"button": {
									"background": "'.$zn_color_button.'",
									"text": "'.$zn_color_button_text.'",
									"border": "'.$border.'"
								}
							},
							"position": "'.$zn_position.'",
							"static": "'.$static.'",
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
				</script>
				';
		}
		echo $zn_consent;	
	}
}
