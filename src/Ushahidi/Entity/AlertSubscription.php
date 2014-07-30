<?php

/**
 * Ushahidi Alert Subscription
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\Entity;

use Ushahidi\Entity;

class AlertSubscription extends Entity
{
	public $id;
	public $name;
	
	public function getResource()
	{
		return 'alert_subscriptions';
	}
}
