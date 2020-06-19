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


class Zone_Cookie_Model_Update
{
    protected $requester;
    protected $type_request;
    protected $cookie_request;
    protected $cookie_content;
    protected $cookie_layout;
    protected $cookie_settings;
    protected $wpdb;

    public function __construct() {
        global $wpdb;

        $this->requester = "`" . $wpdb->prefix . "zn_cookie_requester`";
        $this->type_request  = "`" . $wpdb->prefix . "zn_cookie_type_request`";
        $this->cookie_request  = "`" . $wpdb->prefix . "zn_cookie_request`";
        $this->cookie_content = "`" . $wpdb->prefix . "zn_cookie_content`";
        $this->cookie_layout = "`" . $wpdb->prefix . "zn_cookie_layout`";
        $this->cookie_settings = "`" . $wpdb->prefix . "zn_cookie_settings`";
        $this->wpdb = $wpdb;
    }

    public function setGdprPageContent($zn_page_content) {
        $query = "
            UPDATE " . $this->cookie_content . " SET Gdpr_Page_Content = '". $zn_page_content."' WHERE Gdpr_content_ID = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function setCcpaPageContent($zn_ccpa_content) {
        $query = "
            UPDATE " . $this->cookie_content . " SET Ccpa_Page_Content = '". $zn_ccpa_content."' WHERE Gdpr_content_ID = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function setNewGDPRContent($zn_policy,$zn_cookie,$zn_terms,$zn_message,$zn_accept,$zn_deny) {
        $query = "
            UPDATE " . $this->cookie_content . " SET
                `Privacy_Policy_Link` = '". $zn_policy. "',
                `Cookie_Policy_Link` = '" . $zn_cookie . "',
                `Terms_and_Condition_Link` = '" . $zn_terms . "',
                `Message` = '" . $zn_message . "',
                `Allow_Button` = '" . $zn_accept . "',
                `Deny_Button` = '" . $zn_deny . "'
            WHERE `Gdpr_content_ID` = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function setNewGDPRLayout($zn_position, $zn_layout, $zn_color_banner, $zn_color_banner_text, $zn_color_button, $zn_color_button_text, $zn_compliance) {
        $query = "
            UPDATE " . $this->cookie_layout . " SET
                `Position` = '". $zn_position. "',
                `Layout` = '" . $zn_layout . "',
                `Color_Banner` = '" . $zn_color_banner . "',
                `Color_Banner_Text` = '" . $zn_color_banner_text . "',
                `Color_Button` = '" . $zn_color_button . "',
                `Color_Button_Text` = '" . $zn_color_button_text . "',
                `Compliance` = '" . $zn_compliance . "'
            WHERE `Gdpr_layout_ID` = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function offTypeRequest($zn_id){
        $query = "
            UPDATE " . $this->type_request . " SET
                `Status` = '0'
            WHERE `TypeofRequest_ID` = '". $zn_id."'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function onTypeRequest($zn_id){
        $query = "
            UPDATE " . $this->type_request . " SET
                `Status` = '1'
            WHERE `TypeofRequest_ID` = '" . $zn_id . "'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function acceptRequest($zn_id){
        $query = "
            UPDATE " . $this->cookie_request . " SET
                `Request` = '0',
                `Status` = '1'
            WHERE `Request_ID` = '" . $zn_id . "'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function declineRequest($zn_id){
        $query = "
            UPDATE " . $this->cookie_request . " SET
                `Request` = '0',
                `Status` = '2'
            WHERE `Request_ID` = '" . $zn_id . "'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function offEmailNotif(){
        $query = "
            UPDATE " . $this->cookie_settings . " SET
                `Email_Status` = '0'
            WHERE `GDPR_Settings_ID` = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function onEmailNotif(){
        $query = "
            UPDATE " . $this->cookie_settings . " SET
                `Email_Status` = '1'
            WHERE `GDPR_Settings_ID` = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }

    public function setNewemailSettings($zn_email_receiver, $zn_email_approved_template, $zn_email_disapproved_template){
        $query = "
            UPDATE " . $this->cookie_settings . " SET
                `Email_Approved_Template` = '". $zn_email_approved_template."',
                `Email_Dispproved_Template` = '". $zn_email_disapproved_template."',
                `Email_Receiver` = '". $zn_email_receiver."'
            WHERE `GDPR_Settings_ID` = '1'";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }
    }
}
