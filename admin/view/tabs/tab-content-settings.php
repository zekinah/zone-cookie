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
$zn_page_content = $tbl_content[0]['Gdpr_Page_Content'];
$zn_form_nonce = wp_create_nonce('zn_form_nonce');
?>
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3">
            <h2>Page Content</h2>
            <div class="card-body">
                <?php
                $settings = array(
                    'teeny' => true,
                    'textarea_rows' => 14,
                    'tabindex' => 1,
                    'editor_height' => 500
                );
                wp_editor($zn_page_content, 'zn_page_content', $settings);
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
                    <input class="form-control txt-shortcode" type="text" value="[zone-gdpr-form]" readonly>
                </div>
            </div>
            <button id="btn-save-content" type="button" class="btn btn-save-settings  mb-3">Save Changes</button>
            <button id="btn-restore-content" data-zn_nonce="<?= $zn_form_nonce ?>" type="button" class="btn btn-default  mb-3">Restore Content</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <h2>Request Types</h2>
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
                    while ($row = $tbl_request_type->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $inc ?></td>
                            <td><?= $row['Type_of_Request'] ?></td>
                            <td>
                                <input class="form-check-input zn_on_request" data-zn_reqid_stat="<?= $row['TypeofRequest_ID'] ?>" type="checkbox" name="zn_on_request" <?php echo ($row['Status'] == '1' ? 'checked' : ''); ?> data-toggle="toggle">
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