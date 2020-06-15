<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/zekinah/
 * @since      1.0.0
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/includes
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
class Zone_Cookie_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$db = new Zone_Cookie_Model_Config();
		$db->dropTable();
	}

}
