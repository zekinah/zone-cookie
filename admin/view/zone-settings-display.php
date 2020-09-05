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
        $tab_option = array('Email Settings');
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
            <div id="tab-0" class="container-fluid tab-pane nav-tab-active active">
                <!-- Home -->
                <?php require_once('tabs/tab-email-settings.php'); ?>
            </div>
        </div>
    </div>
</div>