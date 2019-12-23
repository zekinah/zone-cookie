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
<div class="gdpr-card">
    <div class="gdpr-card-header">
        <h2>Zone Cookie Settings</h2>
    </div>
    <div class="container-fluid">
        <?php
        $tab_option = array('Email Settings');
        echo '<ul class="nav nav-tabs" role="tablist">';
        foreach ($tab_option as $key => $option_setting) {
            if ($key == 0) {
                $class = "nav-link active";
            } else {
                $class = "nav-link";
            }
            echo '<li class="nav-item">';
            echo '<a class="' . $class . '" data-toggle="tab" href="#tab-' . $key . '">' . $option_setting . '</a>';
            echo '</li>';
        }
        echo ' </ul>';
        ?>
        <div class="tab-content">
            <div id="tab-0" class="container-fluid tab-pane active">
                <!-- Home -->
                <?php require_once('tabs/tab-email-settings.php'); ?>
            </div>
        </div>
    </div>
</div>