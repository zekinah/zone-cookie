<?php

/**
 * Provide a public area view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/public/view/templates
 */
?>
        <div id="zn-request-form">
            <h2>Request Form</h2>
            <div class="req-col-main">
                <div class="req-col-6">
                    <input type="text" name="req_fname" placeholder="First Name" required>
                </div>
                <div class="req-col-6">
                    <input type="text" name="req_lname"  placeholder="Last Name" required>
                </div>
            </div>
            <div class="req-col-main">
                <div class="req-col-6">
                <input type="text" name="req_phone"  placeholder="Phone" required>
                </div>
                <div class="req-col-6">
                    <input type="email" name="req_email"  placeholder="Email" required>
                </div>
            </div>
            <div class="dpr-form">
                <select class="custom-select" id="gdpr-request" required>
                    <option selected disabled>--CHOOSE ACTION--</option>
                    <?php
                    $temp_id = 1;
                    foreach($tbl_request_type as $res => $row){
                        echo '<option value="' . $row->TypeofRequest_ID . '">' . $row->Type_of_Request . '</option>';
                        $temp_id++;
                    }
                    ?>
                    </select>
            </div>
            <div class="">
                <textarea id="req_message" placeholder="Additional Message" required></textarea>
            </div>
            <div class="action">
                <input class="btn-gdpr" type="submit" value="Submit" id="btn-submit-request">
            </div>
        </div>