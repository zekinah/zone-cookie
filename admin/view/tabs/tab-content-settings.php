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
<h3>II. Short Code Content Settings</h3>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <h2>Main Content</h2>
            <div class="card-body">
                <?php
                $settings = array(
                    'teeny' => true,
                    'textarea_rows' => 14,
                    'tabindex' => 1
                );
                wp_editor(esc_html(__(get_option('zn_description', ''))), 'terms_wp_content', $settings);
                ?>
                <button id="btn btn-save-content mt-3" class="btn btn-save-settings">Save Changes</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <h2>Drop Down Content</h2>
        </div>
    </div>
</div>