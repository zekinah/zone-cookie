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
?>
<h3>III. General Settings</h3>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label><strong>Privacy Policy pagelink</strong></label>
            <input class="form-control" placeholder="/privacy-policy/" type="text" name="zn_privacy_policy" required value="<?= esc_attr(get_option('zn_privacy_policy')) ?>">
        </div>
        <div class="form-group">
            <label><strong>Cookie Policy pagelink</strong></label>
            <input class="form-control" placeholder="/cookie-policy/" type="text" name="zn_cookie_policy" required value="<?= esc_attr(get_option('zn_cookie_policy')) ?>">
        </div>
        <div class="form-group">
            <label><strong>Terms and Conditions pagelink</strong></label>
            <input class="form-control" placeholder="/terms-and-conditions/" type="text" name="zn_terms_conditions" required value="<?= esc_attr(get_option('zn_terms_conditions')) ?>">
        </div>
        <div class="form-group">
            <label><strong>Message</strong></label>
            <textarea class="form-control" type="text" name="zn_description"><?= get_option('zn_description') ?></textarea>
        </div>
        <div class="form-group">
            <label><strong>Accept button text</strong></label>
            <input class="form-control" placeholder="Allow cookies" type="text" name="zn_allow_cookies" required value="<?= esc_attr(get_option('zn_allow_cookies')) ?>">
        </div>
        <div class="form-group">
            <label><strong>Deny button text</strong></label>
            <input class="form-control" placeholder="Refuse cookies" type="text" name="zn_refuse_cookies" required value="<?= esc_attr(get_option('zn_refuse_cookies')) ?>">
        </div>
    </div>
</div>
<?php submit_button(); ?>