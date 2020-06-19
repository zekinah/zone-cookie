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


class Zone_Cookie_Model_Insert
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

    public function setNewRequester($zn_fname,$zn_lname,$zn_phone,$zn_email,$zn_city,$zn_state){
		$query="
            INSERT INTO".$this->requester." (FirstName,LastName,Phone,Email,City,State) VALUES 
            ('". $zn_fname. "','" . $zn_lname . "','" . $zn_phone . "','" . $zn_email . "','" . $zn_city . "','" . $zn_state . "')";
		$result = $this->wpdb->query($query);
		if($result){
			return true;
		}else{
			$this->wpdb->show_errors();
		}	
    }
    
    public function setNewRequest($zn_requesterID,$zn_typeofrequest_ID,$zn_additional_message){
        $query = "
            INSERT INTO" . $this->cookie_request . " (Requester_ID,TypeofRequest_ID,Additional_Message) VALUES 
            ('" . $zn_requesterID . "','" . $zn_typeofrequest_ID . "','" . $zn_additional_message . "')";
        $result = $this->wpdb->query($query);
        if ($result) {
            return true;
        } else {
            $this->wpdb->show_errors();
        }	
    }
	
	public function extractPost($post){
		return print_r($post);

	}

    
}
