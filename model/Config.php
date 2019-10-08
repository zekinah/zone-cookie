<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_GDPR
 * @subpackage Zone_GDPR/admin/model
 * @author     Zekinah Lecaros <zjlecaros@gmail.com> 
 * 
 */

/******************************************************************
This Model is the parent model class that returns database object
 *******************************************************************/

require_once(ABSPATH . 'wp-config.php');


class Zone_Gdpr_Model_Config
{

    public $wpdb;

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
        /** Requester */
        $query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_gdpr_requester` (
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
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_gdpr_type_request` (
			`TypeofRequest_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Type_of_Request` varchar(50) NOT NULL,
			`Status` int(1) NOT NULL DEFAULT '1',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`TypeofRequest_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";
        /** Request List*/
        $query2 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_gdpr_request` (
			`Request_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Requester_ID` int(11) NOT NULL,
            `TypeofRequest_ID` int(11) NOT NULL,
            `Additioanal_Message` TEXT NOT NULL,
			`Status` int(1) NOT NULL DEFAULT '0',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`Request_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Content*/
        $query3 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_gdpr_content` (
            `Gdpr_Content_ID` int(11) NOT NULL AUTO_INCREMENT,
            `Gdpr_Page_Content` TEXT NOT NULL,
			`Privacy_Policy_Link` TEXT NOT NULL,
            `Cookie_Policy_Link` TEXT NOT NULL,
            `Terms_and_Condition_Link` TEXT NOT NULL,
			`Message` TEXT NOT NULL,
			`Allow_Button` TEXT NOT NULL,
			`Deny_Button` TEXT NOT NULL,
		   PRIMARY KEY (`Gdpr_Content_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Layout*/
        $query4 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_gdpr_layout` (
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
            
        /** Inseert Request Type*/
        $queryI1 = "
			INSERT INTO `" . $wpdb->prefix . "zn_gdpr_type_request` (`Type_of_Request`) VALUES
			('Request to Correct Data'),
			('Complaint Form'),
			('Request to Delete Data'),
			('Download Personal Data')
            ";

        $page_content = "<h2><strong>GDPR Compliance</strong></h2> 
            <p><strong>What is GDPR?</strong></p>
            <p>The GDPR was approved and adopted by the EU Parliament in April 2016. The regulation will take effect after a two-year transition period and, unlike a Directive it does not require any enabling legislation to be passed by government; meaning it will be in force May 2018.</p>
            <p><strong>In light of a uncertain `Brexit` -  I represent a data controller in the UK and want to know if I should still continue with GDPR planning and preparation?</strong></p>
            <p>If you process data about individuals in the context of selling goods or services to citizens in other EU countries then you will need to comply with the GDPR, irrespective as to whether or not you the UK retains the GDPR post-Brexit. If your activities are limited to the UK, then the position (after the initial exit period) is much less clear. The UK Government has indicated it will implement an equivalent or alternative legal mechanisms. Our expectation is that any such legislation will largely follow the GDPR, given the support previously provided to the GDPR by the ICO and UK Government as an effective privacy standard, together with the fact that the GDPR provides a clear baseline against which UK business can seek continued access to the EU digital market. (Ref: http://www.lexology.com/library/detail.aspx?g=07a6d19f-19ae-4648-9f69-44ea289726a0)</p>
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
        
        /** Insert GDPR Content */
        $queryI2 = "
			INSERT INTO `" . $wpdb->prefix . "zn_gdpr_content` (`Gdpr_Page_Content`, `Privacy_Policy_Link`, `Cookie_Policy_Link`, `Terms_and_Condition_Link`, `Message`, `Allow_Button`, `Deny_Button`) VALUES
			('".$page_content."', 'privacy-policy', 'cookie-policy', 'terms-and-conditions', 'This website uses cookies to ensure you get the best experience on our website.', 'Allow cookies', 'Decline')
            ";

        /** Insert GDPR Layout */
        $queryI3 = "
			INSERT INTO `" . $wpdb->prefix . "zn_gdpr_layout` (`Position`, `Layout`, `Color_Banner`, `Color_Banner_Text`, `Color_Button`, `Color_Button_Text`, `Compliance`) VALUES
			( 'default', 'default', '#0D9D96', '#FFFFFF', '#FFFFFF', '#0D9D96', 'default')
            ";

        $sql = $db->query($query);
        $sql1 = $db->query($query1);
        $sql2 = $db->query($query2);
        $sql3 = $db->query($query3);
        $sql4 = $db->query($query4);
        $sql5 = $db->query($queryI1);
        $sql6 = $db->query($queryI2);
        $sql7 = $db->query($queryI3);

        if ($sql && $sql1 && $sql2 && $sql3 && $sql4) {
            if ($sql5 && $sql6 && $sql7) {
                return true;
            } else {
                die("MYSQL Error : " . mysqli_error($db));
            }
        } else {
            die("MYSQL Error : " . mysqli_error($db));
            // DROP TABLE `wp_zn_gdpr_requester`,`wp_zn_gdpr_type_request`, `wp_zn_gdpr_request`, `wp_zn_gdpr_content`, `wp_zn_gdpr_layout`
        }
    }
}
