<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_GDPR
 * @subpackage Zone_GDPR/public/view/templates
 */
$zn_nonce = wp_create_nonce('zn_nonce');
$datahtml = '';
$datahtml .= '
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
                    <input type="text" name="req_email"  placeholder="Email" required>
                </div>
            </div>
            <div class="dpr-form">
                <select class="custom-select" id="gdpr-request" required>
                    <option selected disabled>--CHOOSE ACTION--</option>';
                    $temp_id = 1;
                    while ($row = $tbl_request_type->fetch_assoc()) {
                        $datahtml .= '<option value="' . $row['TypeofRequest_ID'] . '">' . $row['Type_of_Request'] . '</option>';
                        $temp_id++;
                    }
                    $datahtml .= '</select>
            </div>
            <div class="">
                <textarea id="req_message" placeholder="Additional Message" required></textarea>
            </div>
            <div class="">
                <button class="btn-gdpr" data-zn_nonce="'. $zn_nonce.'" id="btn-submit-request">Submit</button>
            </div>
        </div>
    ';
$datahtml .= '
<script>
    
</script>
';
 return $datahtml;