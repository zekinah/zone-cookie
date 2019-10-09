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

require_once('Config.php');

class Zone_Gdpr_Model_Update extends Zone_Gdpr_Model_Config
{
    protected $requester;
    protected $type_request;
    protected $gdpr_request;
    protected $gdpr_content;
    protected $gdpr_layout;

    public function __construct() {
        global $wpdb;

        $this->requester = "`" . $wpdb->prefix . "zn_gdpr_requester`";
        $this->type_request  = "`" . $wpdb->prefix . "zn_gdpr_type_request`";
        $this->gdpr_request  = "`" . $wpdb->prefix . "zn_gdpr_request`";
        $this->gdpr_content = "`" . $wpdb->prefix . "zn_gdpr_content`";
        $this->gdpr_layout = "`" . $wpdb->prefix . "zn_gdpr_layout`";
    }

    public function setPageContent($zn_page_content) {
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->gdpr_content . " SET Gdpr_Page_Content = '". $zn_page_content."' WHERE Gdpr_Content_ID = '1'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }

    public function setNewGDPRContent($zn_policy,$zn_cookie,$zn_terms,$zn_message,$zn_accept,$zn_deny) {
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->gdpr_content . " SET
                `Privacy_Policy_Link` = '". $zn_policy. "',
                `Cookie_Policy_Link` = '" . $zn_cookie . "',
                `Terms_and_Condition_Link` = '" . $zn_terms . "',
                `Message` = '" . $zn_message . "',
                `Allow_Button` = '" . $zn_accept . "',
                `Deny_Button` = '" . $zn_deny . "'
            WHERE `Gdpr_Content_ID` = '1'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }

    public function setNewGDPRLayout($zn_position, $zn_layout, $zn_color_banner, $zn_color_banner_text, $zn_color_button, $zn_color_button_text, $zn_compliance) {
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->gdpr_layout . " SET
                `Position` = '". $zn_position. "',
                `Layout` = '" . $zn_layout . "',
                `Color_Banner` = '" . $zn_color_banner . "',
                `Color_Banner_Text` = '" . $zn_color_banner_text . "',
                `Color_Button` = '" . $zn_color_button . "',
                `Color_Button_Text` = '" . $zn_color_button_text . "',
                `Compliance` = '" . $zn_compliance . "'
            WHERE `Gdpr_Layout_ID` = '1'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }

    public function offTypeRequest($zn_id){
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->type_request . " SET
                `Status` = '0'
            WHERE `TypeofRequest_ID` = '". $zn_id."'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }

    public function onTypeRequest($zn_id){
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->type_request . " SET
                `Status` = '1'
            WHERE `TypeofRequest_ID` = '" . $zn_id . "'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }
}
