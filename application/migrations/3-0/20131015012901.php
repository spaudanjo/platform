<?php defined('SYSPATH') OR die('No direct script access.');

class Migration_3_0_20131015012901 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database $db Database connection
	 */
	public function up(Kohana_Database $db)
	{
		$db->query(NULL, 'ALTER TABLE `post_point`
			ADD COLUMN `label` varchar(255) DEFAULT NULL AFTER `value`
		');
	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database $db Database connection
	 */
	public function down(Kohana_Database $db)
	{
		$db->query(NULL, 'ALTER TABLE `post_point`
			DROP COLUMN `label`
		');
	}

}
