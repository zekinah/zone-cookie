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
$zn_position = $tbl_layout[0]['Position'];
$zn_layout = $tbl_layout[0]['Layout'];
$zn_color_banner = $tbl_layout[0]['Color_Banner'];
$zn_banner_text = $tbl_layout[0]['Color_Banner_Text'];
$zn_color_button = $tbl_layout[0]['Color_Button'];
$zn_button_text = $tbl_layout[0]['Color_Button_Text'];
$zn_compliance = $tbl_layout[0]['Compliance'];

?>
<div id="actionbutton">
    <button id="btn-gdpr-layout" type="button" class="btn button-primary btn-save-settings">Save Changes</button>
    <button id="openpopup" type="button" class="btn button-secondary btn-show">Show</button>
    <button id="closepopup" type="button" class="btn button-secondary btn-close">Close</button>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <!-- POSITION -->
            <h3 class="zone-title-short"><i class="fas fa-arrows-alt"></i> Position</h3>
            <div class="card-body">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_position_default" name="zn_position" type="radio" value="default" <?php echo ($zn_position == 'default' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_position_default">Banner bottom</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_position_top" name="zn_position" type="radio" value="top" <?php echo ($zn_position == 'top' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_position_top">Banner top</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_position_top_static" name="zn_position" type="radio" value="top-static" <?php echo ($zn_position == 'top' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_position_top_static">Banner top (pushdown)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_position_left" name="zn_position" type="radio" value="bottom-left" <?php echo ($zn_position == 'bottom-left' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_position_left">Floating left</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_position_right" name="zn_position" type="radio" value="bottom-right" <?php echo ($zn_position == 'bottom-right' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_position_right">Floating right</label>
                </div>
            </div>
        </div>
        <!-- LAYOUT -->
        <div class="card mb-3">
            <h3 class="zone-title-short"><i class="fas fa-eye"></i> Layout</h3>
            <div class="card-body">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_layout_block" name="zn_layout" type="radio" value="default" <?php echo ($zn_layout == 'default' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_layout_block">Block</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_layout_classic" name="zn_layout" type="radio" value="classic" <?php echo ($zn_layout == 'classic' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_layout_classic">Classic</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_layout_edgeless" name="zn_layout" type="radio" value="edgeless" <?php echo ($zn_layout == 'edgeless' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_layout_edgeless">Edgeless</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="zn_layout_wire" name="zn_layout" type="radio" value="wire" <?php echo ($zn_layout == '' ? 'checked' : ''); ?> />
                    <label class="form-check-label" for="zn_layout_wire">Wire</label>
                </div>
            </div>
        </div>
        <!-- PALETTE -->
        <div class="card mb-3">
            <h3 class="zone-title-short"><i class="fas fa-palette"></i> Palette</h3>
            <div class="card-body">
                <button id="default_palette" type="button" class="btn button-primary btn-show">Use Dafault</button>
                <button id="reset_palette" type="button" class="btn button-secondary btn-close">Reset</button>
                <br><br>
                <strong class="card-text">Create your own</strong>
                <br><br>
                <div class="form-group">
                    <label class="form-check-label mr-5">Banner</label>
                    <input class="form-control zn-color-field" id="zn_color_banner" name="zn_color_banner" type="text" data-default-color="#effeff" value="<?= $zn_color_banner ?>" />
                </div>
                <div class="form-group">
                    <label class="form-check-label mr-4">Banner Text</label>
                    <input class="form-control zn-color-field" id="zn_color_banner_text" name="zn_color_banner_text" type="text" data-default-color="#effeff" value="<?= $zn_banner_text ?>" />
                </div>
                <div class="form-group">
                    <label class="form-check-label mr-5">Button</label>
                    <input class="form-control zn-color-field" id="zn_color_button" name="zn_color_button" type="text" data-default-color="#effeff" value="<?= $zn_color_button ?>" />
                </div>
                <div class="form-group">
                    <label class="form-check-label mr-4">Button Text</label>
                    <input class="form-control zn-color-field" id="zn_color_button_text" name="zn_color_button_text" type="text" data-default-color="#effeff" value="<?= $zn_button_text ?>" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <h3 class="zone-title-short"><i class="fas fa-user-lock"></i> Compliance Type</h3>
            <div class="card-body">
                <div class="form-check">
                    <input id="zn_compliance_def" name="zn_compliance" type="radio" value="default" <?php echo ($zn_compliance == 'default' ? 'checked' : ''); ?> />
                    <label for="zn_compliance_def">Just tell users that we use cookies</label>
                </div>
                <div class="form-check">
                    <input id="zn_compliance_opt_out" name="zn_compliance" type="radio" value="opt-out" <?php echo ($zn_compliance == 'opt-out' ? 'checked' : ''); ?> />
                    <label for="zn_compliance_opt_out">Let users opt out of cookies (Advanced)</label><br>
                    <small>You tell your users that you use cookies, and give them one button to disable cookies, and another to dismiss the message.</small>
                </div>
                <div class="form-check">
                    <input id="zn_compliance_opt_in" name="zn_compliance" type="radio" value="opt-in" <?php echo ($zn_compliance == 'opt-in' ? 'checked' : ''); ?> />
                    <label for="zn_compliance_opt_in">Ask users to opt into cookies (Advanced)</label><br>
                    <small>You tell your users that you wish to use cookies, and give them one button to enable cookies, and another to refuse them.</small>
                </div>
            </div>
        </div>

    </div>
</div>