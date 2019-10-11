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

class Zone_Gdpr_Model_Display extends Zone_Gdpr_Model_Config {
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

    public function getAllRequest() {
      $db = $this->db_connect();
      $sql= "
        SELECT 
        requester.`FirstName`,
        requester.`LastName`,
        requester.`Phone`,
        requester.`Email`,
        requester.`City`,
        requester.`State`,
        type_request.`Type_of_Request`,
        request.`Request_ID`,
        request.`Additional_Message`,
        request.`Date`,
        request.`Request`,
        request.`Status`,
        request.`Trash`
        FROM ". $this->gdpr_request." AS request
        INNER JOIN ". $this->requester. " AS requester
        ON request.`Requester_ID` = requester.`RequesterID`
        LEFT JOIN ". $this->type_request. " AS type_request
        ON request.`TypeofRequest_ID` = type_request.`TypeofRequest_ID`
        ";
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getLastRequest($zn_ID) {
      $db = $this->db_connect();
      $sql= "
        SELECT 
        requester.`FirstName`,
        requester.`LastName`,
        requester.`Phone`,
        requester.`Email`,
        requester.`City`,
        requester.`State`,
        type_request.`Type_of_Request`,
        request.`Request_ID`,
        request.`Additional_Message`,
        request.`Date`,
        request.`Request`,
        request.`Status`,
        request.`Trash`
        FROM ". $this->gdpr_request." AS request
        INNER JOIN ". $this->requester. " AS requester
        ON request.`Requester_ID` = requester.`RequesterID`
        LEFT JOIN ". $this->type_request. " AS type_request
        ON request.`TypeofRequest_ID` = type_request.`TypeofRequest_ID`
        WHERE request.`Request_ID` = ". $zn_ID."
        ";
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getGDPRContent() {
      $db = $this->db_connect();
      $sql="
        SELECT * FROM ".$this->gdpr_content. " WHERE `Gdpr_Content_ID` = 1
        ";
      $result = $db->query($sql);
      if($result){
              $clone = array();
              while ($row = $result->fetch_assoc()) {
                  $array['Gdpr_Page_Content'] = $row['Gdpr_Page_Content'];
                  $array['Privacy_Policy_Link'] = $row['Privacy_Policy_Link'];
                  $array['Cookie_Policy_Link'] = $row['Cookie_Policy_Link'];
                  $array['Terms_and_Condition_Link'] = $row['Terms_and_Condition_Link'];
                  $array['Message'] = $row['Message'];
                  $array['Allow_Button'] = $row['Allow_Button'];
                  $array['Deny_Button'] = $row['Deny_Button'];
                  $clone[] = $array;
              }
              return $clone;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getGDPRLayout() {
      $db = $this->db_connect();
      $sql="
        SELECT * FROM ".$this->gdpr_layout. " WHERE `Gdpr_Layout_ID` = 1
        ";
      $result = $db->query($sql);
      if($result){
              $clone = array();
              while ($row = $result->fetch_assoc()) {
                  $array['Position'] = $row['Position'];
                  $array['Layout'] = $row['Layout'];
                  $array['Color_Banner'] = $row['Color_Banner'];
                  $array['Color_Banner_Text'] = $row['Color_Banner_Text'];
                  $array['Color_Button'] = $row['Color_Button'];
                  $array['Color_Button_Text'] = $row['Color_Button_Text'];
                  $array['Compliance'] = $row['Compliance'];
                  $clone[] = $array;
              }
              return $clone;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getRequestType(){
      $db = $this->db_connect();
      $sql="
        SELECT * FROM ".$this->type_request. " WHERE Trash = 0
        ";
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function checkRequestTypeStat($zn_stat){
      $db = $this->db_connect();
      $sql="
        SELECT `Status` FROM ".$this->type_request. " WHERE Trash = 0 && TypeofRequest_ID = ". $zn_stat."
        ";
      $result = $db->query($sql);
      if($result){
        $row = $result->fetch_assoc();
        return $row['Status'];
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getAvailableRequestType(){
      $db = $this->db_connect();
      $sql="
        SELECT * FROM ".$this->type_request. " WHERE Trash = 0 && Status = 1
        ";
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getLastRequester(){
      $db = $this->db_connect();
      $sql = "
        SELECT RequesterID FROM " . $this->requester . " ORDER BY RequesterID DESC LIMIT 1
        ";
      $result = $db->query($sql);
      if ($result) {
        $row = $result->fetch_assoc();
        return $row['RequesterID'];
      } else {
        die("MYSQL Error : " . mysqli_error($db));
      }
    }

    public function getRequestNotif() {
		$db = $this->db_connect();
		$sql = "
			SELECT COUNT(Request) as Total_Request FROM " . $this->gdpr_request . " WHERE Request = 1
			";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['Total_Request'];
		} else {
			die("MYSQL Error : " . mysqli_error($db));
		}
	}


}