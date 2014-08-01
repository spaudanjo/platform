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
	 * Retrieve A Alert Subscription
	 *
	 * GET /api/tags/:id
	 *
	 * @return void
	 */
	public function action_get_index()
	{
		$repo 					= service("repository.alert_subscription");
		$format					= service("formatter.entity.api");
		$alert_subscription_id 	= $this->request->param('id');
		$alert_subscription 	= $repo->get($alert_subscription_id);

		if(!$alert_subscription->id)
		{
			throw new HTTP_EXCEPTION_404('Alert Subscription :id does not exist', array(':id' => $alert_subscription_id));
		}

		$this->_response_payload = $format($alert_subscription);
		$this->_response_payload['allowed_methods'] = $this->_allowed_methods();
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

	/**
	* Create a new Alert Subscription
	*
	* POST /api/alert_subscriptions
	* @return void 
	*/
	public function action_post_index_collection()
	{
		$usecase 	= service("usecase.alert_subscription.create");
		$format 	= service("formatter.entity.alert_subscription");
		$parser 	= service("parser.alert_subscription.create");

		try
		{
			$parsed_request_data = $parser($this->_request_payload);
			$alert_subscription = $usecase->interact($parsed_request_data);
		}
		catch (Ushahidi\Exception\ValidatorException $e)
		{
			// Also handles ParseException
			throw new HTTP_Exception_400('Validation Error: \':errors\'', array
				(
				':errors' => implode(', ', Arr:flatten($e->getErrors())),
			));
		}

		$this->_response_payload = $format($alert_subscription);
		$this->_response_payload['allowed_methods'] = $this->_allowed_methods();
	}

}
