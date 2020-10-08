<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/admin
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="hello-section__title">Zone Cookie</h1>
            <div class="zone-home">
                <i class="fas fa-lock"></i>
                <p>This configuration wizard will help you setup your Compliance</p>
            </div>
        </div>
        <div class="col-md-12 text-center mb-5">
            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <label><strong>GDPR Content Shortcode</strong></label>
                        <input class="form-control text-center txt-shortcode" type="text" value='[zone-gdpr-content]' readonly>
                        <small class="pull-left">Show the GDPR Content</small>
                    </div>
                    <div class="col-md-4">
                        <label><strong>CCPA Content Shortcode</strong></label>
                        <input class="form-control text-center txt-shortcode" type="text" value='[zone-ccpa-content]' readonly>
                        <small class="pull-left">Show the CCPA Content</small>
                    </div>
                    <div class="col-md-4">
                        <label><strong>Request Form Shortcode</strong></label>
                        <input class="form-control text-center txt-shortcode" type="text" value='[zone-compliance-form]' readonly>
                        <small class="pull-left">Show Form</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table id="tbl-request" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type of Request</th>
            <th>Date</th>
            <th>Status</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody id="body_request">
        <?php
        if (is_array($tbl_request) || is_object($tbl_reviews)) {
            $inc = 1;
            foreach($tbl_request as $res => $row){
                ?>
                <tr>
                    <td><?= $inc ?></td>
                    <td><?= $row->FirstName . " " . $row->LastName ?></td>
                    <td><?= $row->Type_of_Request ?></td>
                    <td><?= date('M d, Y', strtotime($row->Date)) ?></td>
                    <td>
                        <?php 
                            if($row->Status == 0) {
                                echo '<strong class="pending">Pending</strong>';
                            } elseif ($row->Status == 1) {
                                echo '<strong class="accepted">Accepted</strong>';
                            }   elseif ($row->Status == 2) {
                                echo '<strong class="declined">Declined</strong>';
                            } 
                        ?>
                    </td>
                    <td>
                        <?php
                            if ($row->Request) {
                                echo '<a href="#" title="Accept and Notify" class="btn btn-info btn-xs btn-accept-request" data-zn_requester_id="' . $row->Request_ID . '" data-zn_fname_request="' . $row->FirstName . '" data-zn_email_request="' . $row->Email . '" data-zn_request_type="'. $row->Type_of_Request .'"><i class="fas fa-check"></i></a>';
                            }
                            ?>
                        <a href="#TB_inline?width=600&height=545&inlineId=gdpr-view-request" title="View Request Details" class="thickbox btn btn-primary btn-xs zn_view_request" data-zn_fname_request="<?= $row->FirstName ?>" data-zn_lname_request="<?= $row->LastName ?>" data-zn_phone_request="<?= $row->Phone ?>" data-zn_email_request="<?= $row->Email ?>" data-zn_city_request="<?= $row->City ?>" data-zn_state_request="<?= $row->State ?>" data-zn_type_request="<?= $row->Type_of_Request ?>" data-zn_message_request="<?= $row->Additional_Message ?>" class="view-request"><i class="fas fa-eye"></i></a>
                        <?php
                            if ($row->Request) {
                                echo '<a href="#" title="Decline and Notify" class="btn btn-danger btn-xs btn-decline-request" data-zn_requester_id="' . $row->Request_ID . '" data-zn_fname_request="' . $row->FirstName . '" data-zn_email_request="' . $row->Email . '" data-zn_request_type="' . $row->Type_of_Request . '"><i class="fas fa-times"></i></a>';
                            }
                            ?>
                    </td>
                </tr>
            <?php
                $inc++;
            }
        }
        ?>
    </tbody>
</table>
<?php add_thickbox(); ?>
<div id="gdpr-view-request" style="display:none;">
    <h3 class="zone-title-short">Request Details</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><strong>FirstName</strong></label>
                <input type="text" class="form-control" id="zn_fname_request" name="zn_fname_request" readonly />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><strong>Lastname</strong></label>
                <input type="text" class="form-control" id="zn_lname_request" name="zn_lname_request" readonly />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><strong>Phone</strong></label>
                <input type="text" class="form-control" id="zn_phone_request" name="zn_phone_request" readonly />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><strong>Email</strong></label>
                <input type="text" class="form-control" id="zn_email_request" name="zn_email_request" readonly />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label><strong>Type of Request</strong></label>
                <input type="text" class="form-control" id="zn_type_request" name="zn_type_request" readonly />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label><strong>Additional Message</strong></label>
                <textarea class="form-control" id="zn_message_request" name="zn_message_request" readonly />
                </textarea>
            </div>
        </div>
    </div>
</div>