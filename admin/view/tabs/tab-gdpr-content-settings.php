<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Gdpr
 * @subpackage Zone_Gdpr/admin
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
$zn_privacy = $tbl_content[0]['Privacy_Policy_Link'];
$zn_cookie = $tbl_content[0]['Cookie_Policy_Link'];
$zn_terms = $tbl_content[0]['Terms_and_Condition_Link'];
$zn_message = $tbl_content[0]['Message'];
$zn_allow = $tbl_content[0]['Allow_Button'];
$zn_deny = $tbl_content[0]['Deny_Button'];
$zn_form_nonce = wp_create_nonce('zn_form_nonce');
?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="form">
                <div class="form-group">
                    <label><strong>Privacy Policy pagelink</strong></label>
                    <input class="form-control" placeholder="/privacy-policy/" type="text" name="zn_privacy_policy" required value="<?= $zn_privacy ?>">
                </div>
                <div class="form-group">
                    <label><strong>Cookie Policy pagelink</strong></label>
                    <input class="form-control" placeholder="/cookie-policy/" type="text" name="zn_cookie_policy" required value="<?= $zn_cookie ?>">
                </div>
                <div class="form-group">
                    <label><strong>Terms and Conditions pagelink</strong></label>
                    <input class="form-control" placeholder="/terms-and-conditions/" type="text" name="zn_terms_conditions" required value="<?= $zn_terms ?>">
                </div>
                <div class="form-group">
                    <label><strong>Message</strong></label>
                    <textarea class="form-control" type="text" id="zn_description" name="zn_description"><?= $zn_message ?></textarea>
                    <small>Use {privacy-policy} to use Privacy Policy Link, Use {cookie-policy} to use Cookie Policy Link, Use {term-and-condition} to use Terms and Conditions Link</small>
                </div>
                <div class="form-group">
                    <label><strong>Accept button text</strong></label>
                    <input class="form-control" placeholder="Allow cookies" type="text" name="zn_allow_cookies" required value="<?= $zn_allow ?>">
                </div>
                <div class="form-group">
                    <label><strong>Deny button text</strong></label>
                    <input class="form-control" placeholder="Refuse cookies" type="text" name="zn_refuse_cookies" required value="<?= $zn_deny ?>">
                </div>
                <button id="btn-gdpr-content" type="button" data-zn_nonce="<?= $zn_form_nonce ?>" class="btn btn-save-settings  mb-3">Save Changes</button>
            </div>
        </div>
    </div>
</div>