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
<div class="zone-card">
    <div class="wrap">
        <h1 class="zone-title">Zone Cookie</h1>
        <span class="zone-version">v<?= $this->version; ?></span>
    </div>
    <hr class="wp-header-end">
    <div class="container-fluid">
        <?php
        $tab_option = array('Requests', 'EU Compliance Page Content', 'CCPA Compliance Page Content', 'Cookie Content', 'Cookie Layout');
        echo '<ul class="nav nav-tabs nav-tab-wrapper" role="tablist">';
        foreach ($tab_option as $key => $option_setting) {
            if ($key == 0) {
                $class = "nav-tab nav-tab-active active";
            } else {
                $class = "nav-tab";
            }
            echo '<li class="nav-item">';
            echo '<a class="' . $class . '" data-toggle="tab" href="#tab-' . $key . '">' . $option_setting . '</a>';
            echo '</li>';
        }
        echo ' </ul>';
        ?>
        <div class="tab-content">
            <!-- REQUEST -->
            <div id="tab-0" class="container-fluid tab-pane nav-tab-active active"><br>
                <?php require_once('tabs/tab-request.php'); ?>
            </div>
            <!-- EU COMPLIANCE CONTENT SETTING -->
            <div id="tab-1" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-eu-content-settings.php'); ?>
            </div>
            <!-- CCPA COMPLIANCE CONTENT SETTING -->
            <div id="tab-2" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-ccpa-content-settings.php'); ?>
            </div>
            <!-- GENERAL SETTING -->
            <div id="tab-3" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-gdpr-content-settings.php'); ?>
            </div>
            <!-- GDPR SETTING -->
            <div id="tab-4" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-gdpr-settings.php'); ?>
            </div>
        </div>
    </div>
</div>