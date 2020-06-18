<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_GDPR
 * @subpackage Zone_GDPR/public/view/templates
 */
$zn_description = '';
$zn_description .= '<style>
table, th, td {
border: 1px solid black;
padding: 15px;
}
</style>';


$zn_description .= $tbl_content[0]['Ccpa_Page_Content'];

return wp_kses_post($zn_description);
