<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/admin
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
if (!defined('ABSPATH')) {
	exit;
}

class Zone_Cookie_Admin
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->insert = new Zone_Cookie_Model_Insert();
		$this->display = new Zone_Cookie_Model_Display();
		$this->update = new Zone_Cookie_Model_Update();
		$this->default = new Zone_Cookie_Model_Default();
		$this->deployZone();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/zone-cookie-admin.css', array(), $this->version, 'all');
		/* Bootstrap 4 CSS */
		wp_enqueue_style('zone-cookie-bootstrap-css', plugin_dir_url(__FILE__) . 'css/bootstrap/bootstrap.min.css', array(), $this->version);
		wp_enqueue_style('zone-redirect-bootstrap-toggle', plugin_dir_url(__FILE__) . 'css/bootstrap/bootstrap-toggle.min.css', array(), $this->version);
		wp_enqueue_style($this->plugin_name . '-cookieconsentcss', plugin_dir_url(__FILE__) . 'css/cookieconsent/cookieconsent.min.css', array(), $this->version, 'all');
		wp_enqueue_style('zone-cookie-datatable-css', plugin_dir_url(__FILE__) . 'css/datatable/jquery.dataTables.css', array(), $this->version);
		wp_enqueue_style('zone-cookie-pnotify', plugin_dir_url(__FILE__) . 'css/pnotify/pnotify.css', array(), $this->version);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/zone-cookie-admin.js', array('jquery','wp-color-picker'), $this->version, false);
		/* Bootstrap 4 JS */
		wp_enqueue_script('zone-cookie-bootstrap-js', plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script('zone-cookie-toggle', plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap-toggle.min.js', array('jquery'), $this->version);
		wp_enqueue_script($this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/cookieconsent/script.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . '-cookieconsentjs', plugin_dir_url(__FILE__) . 'js/cookieconsent/cookieconsent.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script('zone-cookie-fontawesome', plugin_dir_url(__FILE__) . 'js/fontawesome/all.js', array('jquery'), '5.9.0', false);
		wp_enqueue_script('zone-cookie-pnotify', plugin_dir_url(__FILE__) . 'js/pnotify/pnotify.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-cookie-datatable-js', plugin_dir_url(__FILE__) . 'js/datatable/jquery.dataTables.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-cookie-ajax', plugin_dir_url(__FILE__)  . 'js/zone-cookie-ajax.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_localize_script('zone-cookie-ajax', 'cookiesettingsAjax', array('ajax_url' => admin_url('admin-ajax.php'),'ajax_nonce'=>wp_create_nonce('zn-ajax-nonce')));
	}

	public function deployZone()
	{
		add_action('admin_menu', array(&$this, 'zoneOptions'));

		add_action('wp_ajax_save_page_gdpr_content',  array(&$this, 'save_page_gdpr_content'));
		add_action('wp_ajax_save_page_ccpa_content',  array(&$this, 'save_page_ccpa_content'));
		add_action('wp_ajax_restore_gdpr_page_content',  array(&$this, 'restore_gdpr_page_content'));
		add_action('wp_ajax_restore_ccpa_page_content',  array(&$this, 'restore_ccpa_page_content'));
		add_action('wp_ajax_save_gdpr_content',  array(&$this, 'save_gdpr_content'));
		add_action('wp_ajax_save_gdpr_layout',  array(&$this, 'save_gdpr_layout'));
		add_action('wp_ajax_change_type_request',  array(&$this, 'change_type_request'));
		add_action('wp_ajax_zoneLiveNotifGDPR',  array(&$this, 'zoneLiveNotifGDPR'));
		add_action('wp_ajax_accept_request',  array(&$this, 'accept_request'));
		add_action('wp_ajax_decline_request',  array(&$this, 'decline_request'));
		add_action('wp_ajax_email_notification',  array(&$this, 'email_notification'));
		add_action('wp_ajax_update_email_settings',  array(&$this, 'update_email_settings'));
		add_action('wp_ajax_restore_email_settings',  array(&$this, 'restore_email_settings'));
	}

	/**
	 * Register Theme Options
	 */
	public function zoneOptions()
	{
		$total = $this->display->getRequestNotif();
		add_menu_page(
			'Zone Cookie', 	//Page Title
			$total ? sprintf('Zone Cookie <span class="awaiting-mod">%d</span>', $total) : 'Zone Cookie',   //Menu Title
			'manage_options', 			//Capability
			'zone-cookie', 				//Page ID
			array(&$this, 'zoneOptionsPage'),		//Functions
			'dashicons-lock', 						//Favicon
			99							//Position
		);
		add_submenu_page(
			'zone-cookie',      			 		 // Parent Page ID
			'Zone Cookie Settings',     		 		 // Page Title
			'Settings', 						 // Navbar Title
			'manage_options', 						 // Permission 	
			'zone-cookie-settings', 							 // Submenu Page ID
			array(&$this, 'zoneSettingPage')								 // Function  call	 
		);
	}

	/**
	 * Theme Options Page
	 */
	public function zoneOptionsPage()
	{
		$tbl_request = $this->display->getAllRequest();
		$tbl_request_type = $this->display->getRequestType();
		$tbl_content = $this->display->getCookieContent();
		$tbl_layout = $this->display->getGDPRLayout();
		require_once('view/zone-main-display.php');
		wp_enqueue_script($this->plugin_name . '-function', plugin_dir_url(__FILE__) . 'js/zone-cookie-function.js', array('jquery'), '1.0.0', false);
	}

	public function zoneSettingPage()
	{
		$settings = $this->display->getSettings();
		require_once('view/zone-settings-display.php');
	}

	public function save_page_gdpr_content()
	{
		$zn_gdpr_content = wp_kses_post($_POST['zn_gdpr_content']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_content = $this->update->setGdprPageContent($zn_gdpr_content);
			if ($tbl_content) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function save_page_ccpa_content()
	{
		$zn_ccpa_content = wp_kses_post($_POST['zn_ccpa_content']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_content = $this->update->setCcpaPageContent($zn_ccpa_content);
			if ($tbl_content) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function restore_gdpr_page_content()
	{
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$settings = $this->default->zonedefaultSettings(); 
			$restore_content = '';
			$gdprlength = count($settings['Cookie-Content']['GDPR']);
			for($x=0; $x<$gdprlength; $x++){
				$restore_content .= $settings['Cookie-Content']['GDPR'][$x];
			}
			$tbl_content = $this->update->setGdprPageContent($restore_content);
			if ($tbl_content) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function restore_ccpa_page_content()
	{
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$settings = $this->default->zonedefaultSettings(); 
			$restore_content = '';
			$ccpalength = count($settings['Cookie-Content']['CCPA']);
			for($x=0; $x<$ccpalength; $x++){
				$restore_content .= $settings['Cookie-Content']['CCPA'][$x];
			}
			$tbl_content = $this->update->setCcpaPageContent($restore_content);
			if ($tbl_content) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function save_gdpr_content()
	{
		$zn_privacy_policy = sanitize_text_field($_POST['zn_privacy_policy']);
		$zn_cookie_policy = sanitize_text_field($_POST['zn_cookie_policy']);
		$zn_terms_conditions = sanitize_text_field($_POST['zn_terms_conditions']);
		$zn_description = sanitize_text_field($_POST['zn_description']);
		$zn_allow_cookies = sanitize_text_field($_POST['zn_allow_cookies']);
		$zn_refuse_cookies = sanitize_text_field($_POST['zn_refuse_cookies']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_content = $this->update->setNewGDPRContent($zn_privacy_policy, $zn_cookie_policy, $zn_terms_conditions, $zn_description, $zn_allow_cookies, $zn_refuse_cookies);
			if ($tbl_content) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function save_gdpr_layout()
	{
		$zn_position = sanitize_text_field($_POST['zn_position']);
		$zn_layout = sanitize_text_field($_POST['zn_layout']);
		$zn_color_banner = sanitize_hex_color($_POST['zn_color_banner']);
		$zn_color_banner_text = sanitize_hex_color($_POST['zn_color_banner_text']);
		$zn_color_button = sanitize_hex_color($_POST['zn_color_button']);
		$zn_color_button_text = sanitize_hex_color($_POST['zn_color_button_text']);
		$zn_compliance = sanitize_text_field($_POST['zn_compliance']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_layout = $this->update->setNewGDPRLayout($zn_position, $zn_layout, $zn_color_banner, $zn_color_banner_text, $zn_color_button, $zn_color_button_text, $zn_compliance);
			if ($tbl_layout) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function change_type_request()
	{
		$zn_reqid_stat = sanitize_text_field($_POST['zn_reqid_stat']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_content = $this->display->checkRequestTypeStat($zn_reqid_stat);
			if ($tbl_content) {
				/** Off the Type of Request */
				$tbl_content = $this->update->offTypeRequest($zn_reqid_stat);
				$data = 0;
			} else {
				/** On the Type of Request */
				$tbl_content = $this->update->onTypeRequest($zn_reqid_stat);
				$data = 1;
			}
		}
		echo $data;
		exit();
	}

	public function zoneLiveNotifGDPR()
	{
		$total = $this->display->getRequestNotif();
		echo $total;
		exit();
	}

	public function accept_request()
	{
		$zn_requester_id = sanitize_text_field($_POST['zn_requester_id']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_request = $this->update->acceptRequest($zn_requester_id);
			if ($tbl_request) {
				$notify = $this->sentEmailNotif($zn_fname_request, $zn_email_request, $zn_request_type, $zn_status);
				$data = $this->getHTMLrequest($zn_requester_id);
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function decline_request()
	{
		$zn_requester_id = sanitize_text_field($_POST['zn_requester_id']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_request = $this->update->declineRequest($zn_requester_id);
			if ($tbl_request) {
				$notify = $this->sentEmailNotif($zn_fname_request, $zn_email_request, $zn_request_type, $zn_status);
				$data = $this->getHTMLrequest($zn_requester_id);
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function email_notification()
	{
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_settings = $this->display->changeEmailStatus();
			if ($tbl_settings) {
				/** Off the Email Notification */
				$tbl_settings = $this->update->offEmailNotif();
				$data = 0;
			} else {
				/** On the Email Notification */
				$tbl_settings = $this->update->onEmailNotif();
				$data = 1;
			}
		}
		echo $data;
		exit();
	}

	public function update_email_settings()
	{
		$zn_email_receiver = sanitize_text_field($_POST['zn_email_receiver']);
		$zn_email_approved_template = sanitize_text_field($_POST['zn_email_approved_template']);
		$zn_email_disapproved_template = sanitize_text_field($_POST['zn_email_disapproved_template']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_settings = $this->update->setNewemailSettings($zn_email_receiver, $zn_email_approved_template, $zn_email_disapproved_template);
			if ($tbl_settings) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function restore_email_settings()
	{
		$zn_email_receiver = sanitize_text_field($_POST['zn_email_receiver']);
		$zn_email_approved_template = sanitize_text_field($_POST['zn_email_approved_template']);
		$zn_email_disapproved_template = sanitize_text_field($_POST['zn_email_disapproved_template']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$zn_email_receiver = "";
			$zn_email_approved_template = "<p>Hello {requester},</p><p>Your {type_of_request} has been approved. Please wait for two (2) to three (3) days to be process your request. You will receive another email after your request has been processed. Thank you.</p>";
			$zn_email_disapproved_template = "<p>Hello {requester},</p><p>Sorry but your request has been disapproved. Please contact the site support for more details.</p>";
			$tbl_settings = $this->update->setNewemailSettings($zn_email_receiver, $zn_email_approved_template, $zn_email_disapproved_template);
			if ($tbl_settings) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function getHTMLrequest($zn_requester_id)
	{
		$tbl_request = $this->display->getLastRequest($zn_requester_id);
		$inc = 1;
		$dataHTML = '';
		foreach($tbl_request as $res => $row){
			$dataHTML .= '<tr>
                <td>' . $zn_requester_id . '</td>
                <td>' . $row->FirstName . " " . $row->LastName  . '</td>
                <td>' . $row->Type_of_Request . '</td>
                <td>' . date('M d, Y', strtotime($row->Date)) . '</td>
				<td>';
				if ($row->Status == 0) {
					$dataHTML .= '<strong class="pending">Pending</strong>';
				} elseif ($row->Status == 1) {
					$dataHTML .= '<strong class="accepted">Accepted</strong>';
				} elseif ($row->Status == 2) {
					$dataHTML .= '<strong class="declined">Declined</strong>';
				}
			$dataHTML .= '</td>
                <td>
                    <a href="#TB_inline?width=600&height=545&inlineId=gdpr-view-request" title="View Request Details" class="thickbox btn btn-primary btn-xs zn_view_request" data-zn_fname_request="' . $row->FirstName . '" data-zn_lname_request="' . $row->LastName . '" data-zn_phone_request="' . $row->Phone . '" data-zn_email_request="' . $row->Email . '" data-zn_city_request="' . $row->City . '" data-zn_state_request="' . $row->State . '" data-zn_type_request="' . $row->Type_of_Request . '" data-zn_message_request="' . $row->Additional_Message . '" class="view-request"><i class="fas fa-eye"></i></a>
                </td>
			</tr>';
			$inc++;
		}
		return $dataHTML;
	}

	public function sentEmailNotif($zn_fname_request, $zn_email_request, $zn_request_type, $zn_status){
		$tbl_settings = $this->display->getSettings();
		$isEmailon = $tbl_settings[0]['Email_Status'];
		if($isEmailon) {
			$domain = 'noreply@' . preg_replace('/www\./i', '', $_SERVER['SERVER_NAME']);

			$headers = 'From:' . $domain . '' . "\r\n";

			if ($zn_email_request != '' || $zn_email_request != null) {
				if (!empty(esc_attr($zn_email_request))) {
					$to = esc_attr($zn_email_request);
				}
			} else {
				$to = get_option('admin_email');
			}

			$subject = strtoupper($zn_request_type) . " " . $_SERVER['SERVER_NAME'];
			if ($zn_status == 'accept') {
				$temp_message = $tbl_settings[0]['Email_Approved_Template'];
				$temp_message = str_replace("{requester}", $zn_fname_request, $temp_message);
				$temp_message = str_replace("{type_of_request}", $zn_request_type, $temp_message);
				$message = $temp_message;
			} elseif ($zn_status == 'decline') {
				$temp_message = $tbl_settings[0]['Email_Dispproved_Template'];
				$temp_message = str_replace("{requester}", $zn_fname_request, $temp_message);
				$message = $temp_message;
			}

			add_filter('wp_mail_content_type', array(&$this, 'set_html_content_type'));
			$response = wp_mail($to, $subject, $message, $headers);
			remove_filter('wp_mail_content_type', array(&$this, 'set_html_content_type'));

			if ($response) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function set_html_content_type() {
		return 'text/html';
	}
}
?>