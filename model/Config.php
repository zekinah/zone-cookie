<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/admin/model
 * @author     Zekinah Lecaros <zjlecaros@gmail.com> 
 * 
 */

/******************************************************************
This Model is the parent model class that returns database object
 *******************************************************************/
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	exit;
}

include_once('Default.php');

class Zone_Cookie_Model_Config
{
    
    /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

    public function __construct()
	{
        $this->default = new Zone_Cookie_Model_Default();
        global $wpdb;

		if ( defined( 'Zone_Cookie_VERSION' ) ) {
			$this->version = ZONE_REDIRECT_VERSION;
		} else {
			$this->version = '1.0.9';
		}
        $this->plugin_name = 'zone-cookie';
        $this->wpdb = $wpdb;
	}

    public function createTable()
    {
        $table_prefix = $this->wpdb->prefix;
        $charset_collate = $this->wpdb->get_charset_collate();
        $queries = array();
        $queries_insert = array();
        $settings = $this->default->zonedefaultSettings(); 
        $gdpr = '';
        $ccpa = '';
        $gdprlength = count($settings['Cookie-Content']['GDPR']);
        for($x=0; $x<$gdprlength; $x++){
            $gdpr .= $settings['Cookie-Content']['GDPR'][$x];
        }
        $ccpalength = count($settings['Cookie-Content']['CCPA']);
        for($x=0; $x<$ccpalength; $x++){
            $ccpa .= $settings['Cookie-Content']['CCPA'][$x];
        }
        $pp_link = $settings['Cookie-Content']['Privacy_Policy_Link'];
        $cp_link = $settings['Cookie-Content']['Cookie_Policy_Link'];
        $terms_link = $settings['Cookie-Content']['Terms_and_Condition_Link'];
        $message = $settings['Cookie-Content']['Message'];
        $allow_button = $settings['Cookie-Content']['Allow_Button'];
        $deny_button = $settings['Cookie-Content']['Deny_Button'];
        $postion = $settings['Cookie-Layout']['Position'];
        $layout = $settings['Cookie-Layout']['Layout'];
        $color_banner = $settings['Cookie-Layout']['Color_Banner'];
        $color_banner_text = $settings['Cookie-Layout']['Color_Banner_Text'];
        $color_button = $settings['Cookie-Layout']['Color_Button'];
        $color_button_text = $settings['Cookie-Layout']['Color_Button_Text'];
        $compliance = $settings['Cookie-Layout']['Compliance'];
        $ea_template = $settings['Default-Settings']['Email_Approved_Template'];
        $ed_template = $settings['Default-Settings']['Email_Dispproved_Template'];
        $e_receiver = $settings['Default-Settings']['Email_Receiver'];
        $type_of_request_1 = $settings['Type_of_Request']['_1'];
        $type_of_request_2 = $settings['Type_of_Request']['_2'];
        $type_of_request_3 = $settings['Type_of_Request']['_3'];
        $type_of_request_4 = $settings['Type_of_Request']['_4'];

        /** Requester */
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_cookie_requester` (
			 `RequesterID` int(11) NOT NULL AUTO_INCREMENT,
			 `FirstName` varchar(50) NOT NULL,
			 `LastName` varchar(50) NOT NULL,
			 `Phone` varchar(50) NOT NULL,
			 `Email` varchar(50) NOT NULL,
			 `City` varchar(100) NOT NULL,
			 `State` varchar(100) NOT NULL,
			 PRIMARY KEY (`RequesterID`)
			)".$charset_collate;
        /** Type of Request */
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_cookie_type_request` (
			`TypeofRequest_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Type_of_Request` varchar(50) NOT NULL,
			`Status` int(1) NOT NULL DEFAULT '1',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`TypeofRequest_ID`)
		   )".$charset_collate;
        /** Request List*/
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_cookie_request` (
			`Request_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Requester_ID` int(11) NOT NULL,
            `TypeofRequest_ID` int(11) NOT NULL,
            `Additional_Message` TEXT NOT NULL,
            `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `Request` int(5) NOT NULL DEFAULT '1',
			`Status` int(1) NOT NULL DEFAULT '0',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`Request_ID`)
		   )".$charset_collate;

        /** GDPR Content*/
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_cookie_content` (
            `Gdpr_Content_ID` int(11) NOT NULL AUTO_INCREMENT,
            `Gdpr_Page_Content` TEXT NOT NULL,
            `Ccpa_Page_Content` TEXT NOT NULL,
			`Privacy_Policy_Link` TEXT,
            `Cookie_Policy_Link` TEXT,
            `Terms_and_Condition_Link` TEXT,
			`Message` TEXT NOT NULL,
			`Allow_Button` TEXT NOT NULL,
			`Deny_Button` TEXT NOT NULL,
		   PRIMARY KEY (`Gdpr_Content_ID`)
		   )".$charset_collate;

        /** GDPR Layout*/
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_cookie_layout` (
			`Gdpr_Layout_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Position` TEXT NOT NULL,
            `Layout` TEXT NOT NULL,
            `Color_Banner` TEXT NOT NULL,
			`Color_Banner_Text` TEXT NOT NULL,
			`Color_Button` TEXT NOT NULL,
			`Color_Button_Text` TEXT NOT NULL,
			`Compliance` TEXT NOT NULL,
		   PRIMARY KEY (`Gdpr_Layout_ID`)
		   )".$charset_collate;

        /** GDPR Settings*/
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_cookie_settings` (
			`GDPR_Settings_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Email_Approved_Template` TEXT NOT NULL,
            `Email_Dispproved_Template` TEXT NOT NULL,
            `Email_Receiver` TEXT,
			`Email_Status` int(5) NOT NULL DEFAULT '1',
		   PRIMARY KEY (`GDPR_Settings_ID`)
           )".$charset_collate;
           

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // create structure
        foreach ($queries as $query) {
            dbDelta($query);
        }
        add_option('zone_redirect_version', $this->version);
            
        /** Inseert Request Type*/
        $queries_insert[] = "
			INSERT INTO `" . $table_prefix . "zn_cookie_type_request` (`Type_of_Request`) VALUES
			('$type_of_request_1'),
			('$type_of_request_2'),
			('$type_of_request_3'),
			('$type_of_request_4');
            ";
        /** Insert GDPR Content */
        $queries_insert[] = "
			INSERT INTO `" . $table_prefix . "zn_cookie_content` (`Gdpr_Page_Content`, `Ccpa_Page_Content`, `Privacy_Policy_Link`, `Cookie_Policy_Link`, `Terms_and_Condition_Link`, `Message`, `Allow_Button`, `Deny_Button`) VALUES
			('".$gdpr."', '".$ccpa."', '".$pp_link."', '".$cp_link."', '".$terms_link."', '".$message."', '".$allow_button."', '".$deny_button."')
            ";

        /** Insert GDPR Layout */
        $queries_insert[] = "
			INSERT INTO `" . $table_prefix . "zn_cookie_layout` (`Position`, `Layout`, `Color_Banner`, `Color_Banner_Text`, `Color_Button`, `Color_Button_Text`, `Compliance`) VALUES
			( '".$postion."', '".$layout."', '".$color_banner."', '".$color_banner_text."', '".$color_button."', '".$color_button_text."', '".$compliance."')
            ";

        /** Insert Default Settings */
        $queries_insert[] = "
			INSERT INTO `" . $table_prefix . "zn_cookie_settings` (`Email_Approved_Template`, `Email_Dispproved_Template`, `Email_Receiver`) VALUES
			( '" . $ea_template . "', '" . $ed_template . "', '".$e_receiver."')
            ";
        // create structure
        foreach ($queries_insert as $query) {
            try {
                $this->wpdb->query($query);
            } catch (Exception $e) {
                $this->wpdb->show_errors();
            }
        }
    }

    public function dropTable()
    {
        $table_prefix = $this->wpdb->prefix;

        $this->wpdb->query("DROP TABLE IF EXISTS `" . $table_prefix . "zn_cookie_type_request`");
        $this->wpdb->query("DROP TABLE IF EXISTS `" . $table_prefix . "zn_cookie_content`");
        $this->wpdb->query("DROP TABLE IF EXISTS `" . $table_prefix . "zn_cookie_layout`");
        $this->wpdb->query("DROP TABLE IF EXISTS `" . $table_prefix . "zn_cookie_settings`");

        // DROP TABLE `wp_zn_cookie_requester`,`wp_zn_cookie_type_request`, `wp_zn_cookie_request`, `wp_zn_cookie_content`, `wp_zn_cookie_layout`, `wp_zn_cookie_settings`

    }
}
