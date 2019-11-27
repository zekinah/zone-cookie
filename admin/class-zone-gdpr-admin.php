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

class Zone_Gdpr_Admin
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
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/zone-gdpr-admin.css', array(), $this->version, 'all');
		/* Bootstrap 4 CSS */
		echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__) . 'css/bootstrap/bootstrap.min.css">';
		wp_enqueue_style($this->plugin_name . '-cookieconsentcss', plugin_dir_url(__FILE__) . 'css/cookieconsent/cookieconsent.min.css', array(), $this->version, 'all');
		wp_enqueue_style('zone-datatable-css', plugin_dir_url(__FILE__) . 'css/datatable/jquery.dataTables.css', array(), $this->version);
		wp_enqueue_style('zone-pnotify', plugin_dir_url(__FILE__) . 'css/pnotify/pnotify.css', array(), $this->version);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/zone-gdpr-admin.js', array('jquery'), $this->version, false);
		/* Bootstrap 4 JS */
		echo '<script src="'.plugin_dir_url(__FILE__) . 'js/bootstrap/jquery-3.3.1.slim.min.js"></script>
		<script src="'.plugin_dir_url(__FILE__) . 'js/bootstrap/popper.min.js"></script>
		<script src="'.plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap.min.js"></script>';
		wp_enqueue_script($this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/cookieconsent/script.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . '-cookieconsentjs', plugin_dir_url(__FILE__) . 'js/cookieconsent/cookieconsent.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script('zone-toggle', plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap-toggle.min.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-fontawesome', plugin_dir_url(__FILE__) . 'js/fontawesome/all.js', array('jquery'), '5.9.0', false);
		wp_enqueue_script('zone-pnotify', plugin_dir_url(__FILE__) . 'js/pnotify/pnotify.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-datatable-js', plugin_dir_url(__FILE__) . 'js/datatable/jquery.dataTables.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-gdpr-ajax', plugin_dir_url(__FILE__)  . 'js/zone-gdpr-ajax.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_localize_script('zone-gdpr-ajax', 'gdprsettingsAjax', array('ajax_url' => admin_url('admin-ajax.php')));
	}

	public function deployZone()
	{
		add_action('admin_menu', array(&$this, 'zoneOptions'));

		add_action('wp_ajax_save_page_content',  array(&$this, 'save_page_content'));
		add_action('wp_ajax_restore_page_content',  array(&$this, 'restore_page_content'));
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
			'Zone GDPR', 	//Page Title
			$total ? sprintf('Zone GDPR <span class="awaiting-mod">%d</span>', $total) : 'Zone GDPR',   //Menu Title
			'manage_options', 			//Capability
			'zone-gdpr', 				//Page ID
			array(&$this, 'zoneOptionsPage'),		//Functions
			'dashicons-lock', 						//Favicon
			99							//Position
		);
		add_submenu_page(
			'zone-gdpr',      			 		 // Parent Page ID
			'Zone GDPR Settings',     		 		 // Page Title
			'Settings', 						 // Navbar Title
			'manage_options', 						 // Permission 	
			'zone-gdpr-settings', 							 // Submenu Page ID
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
		$tbl_content = $this->display->getGDPRContent();
		$tbl_layout = $this->display->getGDPRLayout();
		require_once('view/zone-main-display.php');
		wp_enqueue_script($this->plugin_name . '-function', plugin_dir_url(__FILE__) . 'js/zone-gdpr-function.js', array('jquery'), '1.0.0', false);
	}

	public function zoneSettingPage()
	{
		$settings = $this->display->getSettings();
		// print_r($settings);
		require_once('view/zone-settings-display.php');
	}

	public function save_page_content()
	{
		extract($_POST);
		if (isset($zn_page_content)) {
			$tbl_content = $this->update->setPageContent($zn_page_content);
			if ($tbl_content) {
				$data = 1;
			} else {
				$data = 0;
			}
		}
		echo $data;
		exit();
	}

	public function restore_page_content()
	{
		extract($_POST);
		if (isset($zn_nonce)) {
			$restore_content = "<h2><strong>GDPR Compliance</strong></h2> 
            <p><strong>What is GDPR?</strong></p>
            <p>The GDPR was approved and adopted by the EU Parliament in April 2016. The regulation will take effect after a two-year transition period and, unlike a Directive it does not require any enabling legislation to be passed by government; meaning it will be in force May 2018.</p>
            <p><strong>In light of a uncertain `Brexit` -  I represent a data controller in the UK and want to know if I should still continue with GDPR planning and preparation?</strong></p>
            <p>If you process data about individuals in the context of selling goods or services to citizens in other EU countries then you will need to comply with the GDPR, irrespective as to whether or not you the UK retains the GDPR post-Brexit. If your activities are limited to the UK, then the position (after the initial exit period) is much less clear. The UK Government has indicated it will implement an equivalent or alternative legal mechanisms. Our expectation is that any such legislation will largely follow the GDPR, given the support previously provided to the GDPR by the ICO and UK Government as an effective privacy standard, together with the fact that the GDPR provides a clear baseline against which UK business can seek continued access to the EU digital market. \(Ref: http://www.lexology.com/library/detail.aspx?g=07a6d19f-19ae-4648-9f69-44ea289726a0)</p>
            <p><strong>Who does the GDPR affect?</strong></p>
            <p>The GDPR not only applies to organisations located within the EU but it will also apply to organisations located outside of the EU if they offer goods or services to, or monitor the behaviour of, EU data subjects. It applies to all companies processing and holding the personal data of data subjects residing in the European Union, regardless of the company’s location.</p>
            <p>What constitutes personal data?</p>
            <p>Any information related to a natural person or ‘Data Subject’, that can be used to directly or indirectly identify the person. It can be anything from a name, a photo, an email address, bank details, posts on social networking websites, medical information, or a computer IP address.</p>
            <p><strong>What is the difference between a data processor and a data controller?</strong></p>
            <p>A controller is the entity that determines the purposes, conditions and means of the processing of personal data, while the processor is an entity which processes personal data on behalf of the controller.</p>
            <p><strong>Do data processors need `explicit` or `unambiguous` data subject consent - and what is the difference?</strong></p>
            <p>The conditions for consent have been strengthened, as companies will no longer be able to utilise long illegible terms and conditions full of legalese, as the request for consent must be given in an intelligible and easily accessible form, with the purpose for data processing attached to that consent - meaning it must be unambiguous. Consent must be clear and distinguishable from other matters and provided in an intelligible and easily accessible form, using clear and plain language. It must be as easy to withdraw consent as it is to give it.​  Explicit consent is required only for processing sensitive personal data - in this context, nothing short of “opt in” will suffice. However, for non-sensitive data, “unambiguous” consent will suffice.</p>
            <p><strong>What about Data Subjects under the age of 16?</strong></p>
            <p>Parental consent will be required to process the personal data of children under the age of 16 for online services; member states may legislate for a lower age of consent but this will not be below the age of 13.</p>
            <p><strong>What is the difference between a regulation and a directive?</strong></p>
            <p>A regulation is a binding legislative act. It must be applied in its entirety across the EU, while a directive is a legislative act that sets out a goal that all EU countries must achieve. However, it is up to the individual countries to decide how. It is important to note that the GDPR is a regulation, in contrast the the previous legislation, which is a directive.</p>
            <p><strong>How does the GDPR affect policy surrounding data breaches?</strong></p>
            <p>Proposed regulations surrounding data breaches primarily relate to the notification policies of companies that have been breached. Data breaches which may pose a risk to individuals must be notified to the DPA within 72 hours and to affected individuals without undue delay.</p>
            ";

			$tbl_content = $this->update->setPageContent($restore_content);
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
		extract($_POST);
		if (isset($zn_nonce)) {
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
		extract($_POST);
		if (isset($zn_nonce)) {
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
		extract($_POST);
		if (isset($zn_reqid_stat)) {
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
		extract($_POST);
		if (isset($zn_requester_id)) {
			$tbl_request = $this->update->acceptRequest($zn_requester_id);
			if ($tbl_request) {
				//$notify = $this->sentEmailNotif($zn_fname_request, $zn_email_request, $zn_request_type, $zn_status);
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
		extract($_POST);
		if (isset($zn_requester_id)) {
			$tbl_request = $this->update->declineRequest($zn_requester_id);
			if ($tbl_request) {
				//$notify = $this->sentEmailNotif($zn_fname_request, $zn_email_request, $zn_request_type, $zn_status);
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
		extract($_POST);
		if (isset($zn_nonce)) {
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
		extract($_POST);
		if (isset($zn_nonce)) {
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
		extract($_POST);
		if (isset($zn_nonce)) {
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
		while ($row = $tbl_request->fetch_assoc()) {
			$dataHTML .= '<tr>
                <td>' . $inc . '</td>
                <td>' . $row['FirstName'] . " " . $row['LastName'] . '</td>
                <td>' . $row['Type_of_Request'] . '</td>
                <td>' . date('M d, Y', strtotime($row['Date'])) . '</td>
				<td>';
				if ($row['Status'] == 0) {
					$dataHTML .= '<strong class="pending">Pending</strong>';
				} elseif ($row['Status'] == 1) {
					$dataHTML .= '<strong class="accepted">Accepted</strong>';
				} elseif ($row['Status'] == 2) {
					$dataHTML .= '<strong class="declined">Declined</strong>';
				}
			$dataHTML .= '</td>
                <td>
                    <a href="#TB_inline?width=600&height=545&inlineId=gdpr-view-request" title="View Request Details" class="thickbox btn btn-primary btn-xs zn_view_request" data-zn_fname_request="' . $row['FirstName'] . '" data-zn_lname_request="' . $row['LastName'] . '" data-zn_phone_request="' . $row['Phone'] . '" data-zn_email_request="' . $row['Email'] . '" data-zn_city_request="' . $row['City'] . '" data-zn_state_request="' . $row['State'] . '" data-zn_type_request="' . $row['Type_of_Request'] . '" data-zn_message_request="' . $row['Additional_Message'] . '" class="view-request"><i class="fas fa-eye"></i></a>
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
				$to = 'zjlecaros@gmail.com';
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