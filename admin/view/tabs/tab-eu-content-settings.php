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
$zn_gdpr_content = $tbl_content[0]['Gdpr_Page_Content'];
?>
<h3 class="zone-title-short">EU Compliance: General Data Protection Regulation (GDPR)</h3>
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3">
            <h3 class="zone-title-short">Page Content</h3>
            <div class="card-body">
                <?php
                $settings_gdpr = array(
                    'teeny' => true,
                    'textarea_rows' => 14,
                    'tabindex' => 1,
                    'editor_height' => 500,
                    'wpautop' => false
                );
                wp_editor( wpautop($zn_gdpr_content), 'zn_gdpr_content', $settings_gdpr);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-3">
            <div class="form">
                <div class="form-group">
                    <label><strong>GDPR Content Shortcode</strong></label>
                    <input class="form-control txt-shortcode" type="text" value="[zone-gdpr-content]" readonly>
                </div>
                <div class="form-group">
                    <label><strong>Request Form Shortcode</strong></label>
                    <input class="form-control txt-shortcode" type="text" value="[zone-compliance-form]" readonly>
                </div>
            </div>
            <button id="btn-save-gdpr-content" type="button" class="btn button-primary btn-save-settings  mb-3">Save Changes</button>
            <button id="btn-restore-gdpr-content" type="button" class="btn button-secondary btn-default  mb-3">Restore Content</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <h3 class="zone-title-short">Request Types</h3>
            <table id="tbl-type-request" class="display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Type of Request</th>
                        <th>Visibility</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $inc = 1;
                    foreach($tbl_request_type as $res => $row){
                        ?>
                        <tr>
                            <td><?= $inc ?></td>
                            <td><?= $row->Type_of_Request ?></td>
                            <td>
                                <input class="form-check-input zn_on_request" type="checkbox" name="zn_on_request" data-zn_reqid_stat="<?= $row->TypeofRequest_ID ?>" <?php echo ($row->Status == '1' ? 'checked' : ''); ?> data-toggle="toggle">
                            </td>
                        </tr>
                    <?php
                        $inc++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>