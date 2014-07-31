<?php

/**
 * Repository for Alert Subscriptions
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\Entity;

interface AlertSubscriptionRepository
{

	/**
	 * @return array of Ushahidi\Entity\AlertSubscription
	 */
	public function getAll();

	/**
	 * @param int $id
	 * @return Ushahidi\Entity\AlertSubscription
	 */
	public function get($id);

}

