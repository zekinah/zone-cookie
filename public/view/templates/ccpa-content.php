<?php

/**
 * Provide a public area view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/public/view/templates
 */
?>
<style async>
table, th, td {
border: 1px solid black;
padding: 15px;
}
</style>
<?php

$zn_description = $tbl_content[0]['Ccpa_Page_Content'];

echo wp_kses_post($zn_description);
