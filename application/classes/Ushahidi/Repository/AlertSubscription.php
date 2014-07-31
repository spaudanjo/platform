<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Ushahidi AlertSubscription Repository
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Ushahidi\Entity\AlertSubscription;
use Ushahidi\Entity\AlertSubscriptionRepository;

class Ushahidi_Repository_AlertSubscription extends Ushahidi_Repository implements
	AlertSubscriptionRepository
{

	protected function getTable()
	{
		return 'alert_subscriptions';
	}

	// Ushahidi_Repository
	protected function getEntity(Array $data = null)
	{
		return new AlertSubscription($data);
	}

	// AlertSubscriptionRepository
	public function getAll(Array $params = null)
	{

		// Start the query, removing empty values
		$query = $this->selectQuery();

		// if (!empty($params['orderby'])) {
		// 	$query->order_by($params['orderby'], Arr::get($params, 'order'));
		// }

		// if (!empty($params['offset'])) {
		// 	$query->offset($params['offset']);
		// }
		// if (!empty($params['limit'])) {
		// 	$query->limit($params['limit']);
		// }

		$results = $query->execute($this->db);

		return $this->getCollection($results->as_array());
	}

	public function get($id)
	{
		return $this->getEntity($this->selectOne(compact('id')));
	}
}
