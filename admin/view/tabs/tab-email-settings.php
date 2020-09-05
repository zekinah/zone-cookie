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

$email_approved_template = $settings[0]['Email_Approved_Template'];
$email_disapproved_template = $settings[0]['Email_Dispproved_Template'];
$email_receiver = $settings[0]['Email_Receiver'];
$email_status = $settings[0]['Email_Status'];
?>
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <h3 class="zone-title-short">Email Approved Request Template</h3>
                    <div class="col-md-12 mt-2">
                        <?php
                        $settings = array(
                            'teeny' => true,
                            'textarea_rows' => 14,
                            'tabindex' => 1,
                            'editor_height' => 350
                        );
                        wp_editor($email_approved_template, 'email_approved_template', $settings);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <h3 class="zone-title-short">Email Disapproved Request Template</h3>
                    <div class="col-md-12 mt-2">
                        <?php
                        $settings = array(
                            'teeny' => true,
                            'textarea_rows' => 14,
                            'tabindex' => 1,
                            'editor_height' => 350
                        );
                        wp_editor($email_disapproved_template, 'email_disapproved_template', $settings);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-3">
            <h3 class="zone-title-short">Email Notification</h3>
            <input id="zn_gdpr_on_email" class="form-check-input" type="checkbox" name="zn_gdpr_on_email" <?php echo ($email_status == '1' ? 'checked' : ''); ?> data-toggle="toggle">
            <br>
            <div class="form">
                <div class="form-group">
                    <label><strong>Email Request Receiver</strong></label>
                    <input class="form-control" placeholder="Email Address" type="text" id="zn_email_receiver" name="zn_email_receiver" required value="<?= $email_receiver ?>">
                    <small>The email address that will received if their is a new request from the site.</small>
                </div>
            </div>
            <button id="btn-save-email-settings" type="button" class="btn button-primary btn-save-settings mb-3">Save Changes</button>
            <button id="btn-restore-email-settings" type="button" class="btn button-secondary btn-default  mb-3">Restore Content</button>

        </div>
    </div>
</div>