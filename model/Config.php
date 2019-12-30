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

require_once(ABSPATH . 'wp-config.php');
include_once('Default.php');

class Zone_Cookie_Model_Config
{

    public $wpdb;

    public function __construct()
	{
		$this->default = new Zone_Cookie_Model_Default();
	}

    public function db_connect()
    {
        $localhost    = DB_HOST;
        $user        = DB_USER;
        $pw            = DB_PASSWORD;
        $database    = DB_NAME;
        $db = new mysqli($localhost, $user, $pw, $database);
        if ($db) {
            return $db;
        } else {
            die("Connection failed: " . $db->connect_error);
        }
    }

    public function createTable()
    {
        global $wpdb;
        $db = $this->db_connect();
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
        $query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_requester` (
			 `RequesterID` int(11) NOT NULL AUTO_INCREMENT,
			 `FirstName` varchar(50) NOT NULL,
			 `LastName` varchar(50) NOT NULL,
			 `Phone` varchar(50) NOT NULL,
			 `Email` varchar(50) NOT NULL,
			 `City` varchar(100) NOT NULL,
			 `State` varchar(100) NOT NULL,
			 PRIMARY KEY (`RequesterID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
			";
        /** Type of Request */
        $query1 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_type_request` (
			`TypeofRequest_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Type_of_Request` varchar(50) NOT NULL,
			`Status` int(1) NOT NULL DEFAULT '1',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`TypeofRequest_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";
        /** Request List*/
        $query2 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_request` (
			`Request_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Requester_ID` int(11) NOT NULL,
            `TypeofRequest_ID` int(11) NOT NULL,
            `Additional_Message` TEXT NOT NULL,
            `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `Request` int(5) NOT NULL DEFAULT '1',
			`Status` int(1) NOT NULL DEFAULT '0',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`Request_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Content*/
        $query3 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_content` (
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
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Layout*/
        $query4 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_layout` (
			`Gdpr_Layout_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Position` TEXT NOT NULL,
            `Layout` TEXT NOT NULL,
            `Color_Banner` TEXT NOT NULL,
			`Color_Banner_Text` TEXT NOT NULL,
			`Color_Button` TEXT NOT NULL,
			`Color_Button_Text` TEXT NOT NULL,
			`Compliance` TEXT NOT NULL,
		   PRIMARY KEY (`Gdpr_Layout_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Settings*/
        $query5 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_settings` (
			`GDPR_Settings_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Email_Approved_Template` TEXT NOT NULL,
            `Email_Dispproved_Template` TEXT NOT NULL,
            `Email_Receiver` TEXT,
			`Email_Status` int(5) NOT NULL DEFAULT '1',
		   PRIMARY KEY (`GDPR_Settings_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";
            
        /** Inseert Request Type*/
        $queryI1 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_type_request` (`Type_of_Request`) VALUES
			('$type_of_request_1'),
			('$type_of_request_2'),
			('$type_of_request_3'),
			('$type_of_request_4');
            ";
        
        /** Insert GDPR Content */
        $queryI2 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_content` (`Gdpr_Page_Content`, `Ccpa_Page_Content`, `Privacy_Policy_Link`, `Cookie_Policy_Link`, `Terms_and_Condition_Link`, `Message`, `Allow_Button`, `Deny_Button`) VALUES
			('".$gdpr."', '".$ccpa."', '".$pp_link."', '".$cp_link."', '".$terms_link."', '".$message."', '".$allow_button."', '".$deny_button."')
            ";

        /** Insert GDPR Layout */
        $queryI3 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_layout` (`Position`, `Layout`, `Color_Banner`, `Color_Banner_Text`, `Color_Button`, `Color_Button_Text`, `Compliance`) VALUES
			( '".$postion."', '".$layout."', '".$color_banner."', '".$color_banner_text."', '".$color_button."', '".$color_button_text."', '".$compliance."')
            ";

        /** Insert Default Settings */
        $queryI4 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_settings` (`Email_Approved_Template`, `Email_Dispproved_Template`, `Email_Receiver`) VALUES
			( '" . $ea_template . "', '" . $ed_template . "', '".$e_receiver."')
            ";

        $sql = $db->query($query);
        $sql1 = $db->query($query1);
        $sql2 = $db->query($query2);
        $sql3 = $db->query($query3);
        $sql4 = $db->query($query4);
        $sql5 = $db->query($query5);
        $sql6 = $db->query($queryI1);
        $sql7 = $db->query($queryI2);
        $sql8 = $db->query($queryI3);
        $sql9 = $db->query($queryI4);

        if ($sql && $sql1 && $sql2 && $sql3 && $sql4 && $sql5) {
            if ($sql6 && $sql7 && $sql8 && $sql9) {
                return true;
            } else {
                die("MYSQL Error : " . mysqli_error($db));
            }
        } else {
            die("MYSQL Error : " . mysqli_error($db));
            // DROP TABLE `wp_zn_cookie_requester`,`wp_zn_cookie_type_request`, `wp_zn_cookie_request`, `wp_zn_cookie_content`, `wp_zn_cookie_layout`, `wp_zn_cookie_settings`
        }
    }
}
