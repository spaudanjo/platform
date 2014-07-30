<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Ushahidi API Alert Subscriptions Controller
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application\Controllers
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

class Controller_Api_AlertSubscriptions extends Ushahidi_Api {

	/**
	 * @var string oauth2 scope required for access
	 */
	protected $_scope_required = 'alert_subscriptions';

	/**
	 * Load resource object
	 *
	 * @return void
	 */
	protected function _resource()
	{
		parent::_resource();

		$this->_resource = 'alert_subscriptions';
	}


	/**
	 * Retrieve all AlertSubscriptions
	 *
	 * GET /api/alert_subscription
	 *
	 * @return void
	 */
	public function action_get_index_collection()
	{
		$repo = service('repository.alert_subscription');
		$format = service('formatter.entity.api');
		
		$alert_subscriptions = $repo->getAll();

		$count = count($alert_subscriptions);

		$results = [];

		foreach ($alert_subscriptions as $alert_subscription)
		{
			$result = $format($alert_subscription);
			$results = $result;
		}
        
		$this->_response_payload = array(
			'count' => $count, 
			'results' => $results
			);
		$this->_response_payload['allowed_methods'] = $this->_allowed_methods();
	}

}
