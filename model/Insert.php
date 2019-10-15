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

class Zone_Gdpr_Model_Insert extends Zone_Gdpr_Model_Config
{
    protected $requester;
    protected $type_request;
    protected $gdpr_request;
    protected $gdpr_content;
    protected $gdpr_layout;
    protected $gdpr_settings;

    public function __construct() {
        global $wpdb;

        $this->requester = "`" . $wpdb->prefix . "zn_gdpr_requester`";
        $this->type_request  = "`" . $wpdb->prefix . "zn_gdpr_type_request`";
        $this->gdpr_request  = "`" . $wpdb->prefix . "zn_gdpr_request`";
        $this->gdpr_content = "`" . $wpdb->prefix . "zn_gdpr_content`";
        $this->gdpr_layout = "`" . $wpdb->prefix . "zn_gdpr_layout`";
        $this->gdpr_settings = "`" . $wpdb->prefix . "zn_gdpr_settings`";
    }

    public function setNewRequester($zn_fname,$zn_lname,$zn_phone,$zn_email,$zn_city,$zn_state){
		$db = $this->db_connect();
		$query="
            INSERT INTO".$this->requester." (FirstName,LastName,Phone,Email,City,State) VALUES 
            ('". $zn_fname. "','" . $zn_lname . "','" . $zn_phone . "','" . $zn_email . "','" . $zn_city . "','" . $zn_state . "')";
		$result = $db->query($query);
		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
    }
    
    public function setNewRequest($zn_requesterID,$zn_typeofrequest_ID,$zn_additional_message){
        $db = $this->db_connect();
        $query = "
            INSERT INTO" . $this->gdpr_request . " (Requester_ID,TypeofRequest_ID,Additional_Message) VALUES 
            ('" . $zn_requesterID . "','" . $zn_typeofrequest_ID . "','" . $zn_additional_message . "')";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }	
    }
	
	public function extractPost($post){
		return print_r($post);

	}

    
}
