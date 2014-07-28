<?php defined('SYSPATH') OR die('No direct script access.');

class Migration_3_0_20140727143229 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database $db Database connection
	 */
	public function up(Kohana_Database $db)
	{
		// $db->query(NULL,
		// 	'CREATE TABLE `alert_subscriptions` (
		// 		 `id` int(11) unsigned NOT NULL,
		// 		`name` VARCHAR(255) NOT NULL DEFAULT)');

		$db->query(NULL, "CREATE TABLE IF NOT EXISTS `alert_subscriptions` (
			`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
			`name` VARCHAR(150) NOT NULL DEFAULT '' ,
			PRIMARY KEY (`id`)
		)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET = utf8;");

	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database $db Database connection
	 */
	public function down(Kohana_Database $db)
	{
		$db->query(NULL, 'DROP TABLE `alert_subscriptions`');
	}

}
