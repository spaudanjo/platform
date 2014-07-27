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
	 * @var string Field to sort results by
	 */
	 protected $_record_orderby = 'created';

	/**
	 * @var string Direct to sort results
	 */
	 protected $_record_order = 'DESC';

	/**
	 * @var int Maximum number of results to return
	 */
	 protected $_record_allowed_orderby = array('id', 'created', 'email', 'username');

	/**
	 * @var string oauth2 scope required for access
	 */
	protected $_scope_required = 'users';

	/**
	 * Load resource object
	 *
	 * @return void
	 */
	protected function _resource()
	{

		parent::_resource();

		$this->_resource = 'alert_subscriptions';

		// $this->_resource = ORM::factory('User');

		// // Get post
		// if ($user_id = $this->request->param('id', 0))
		// {
		// 	if ($user_id == 'me')
		// 	{
		// 		$user = $this->user;

		// 		if ( ! $user->loaded())
		// 		{
		// 			throw new HTTP_Exception_404('No user associated with the access token.');
		// 		}

		// 		$this->_resource = $user;
		// 	}
		// 	else
		// 	{
		// 		$user = ORM::factory('User', $user_id);

		// 		if (! $user->loaded())
		// 		{
		// 			throw new HTTP_Exception_404('User does not exist. ID: \':id\'', array(
		// 				':id' => $this->request->param('id', 0),
		// 			));
		// 		}

		// 		$this->_resource = $user;
		// 	}
		// }
	}

	public function before()
	{
		parent::before();

		// var_dump($this->request);

		// $this->view = View_Api::factory('AlertSubscription');
		// $this->view->set_acl($this->acl);
		// $this->view->set_user($this->user);
	}

	public function action_get_index_collection()
	{
		//Respond with Users
		$this->_response_payload = array(
				'count' => 1,
				'total_count' => 2,
				'results' => 3,
				'limit' => 4,
				'offset' => 5,
				'order' => 6,
				'orderby' => 7,
				'curr' => 8,
				'next' => 9,
				'prev' => 10,
		);
	}

	/**
	 * Get allowed HTTP method for current resource
	 * @param  boolean $resource Optional resources to check access for
	 * @return Array             Array of methods, TRUE if allowed
	 */
	protected function _allowed_methods($resource = FALSE)
	{
		if (! $resource)
		{
			$resource = $this->resource();
		}

		$allowed_methods = parent::_allowed_methods($resource);
		$allowed_methods['change_role'] = $this->acl->is_allowed($this->user, $resource, 'change_role');
		$allowed_methods['get_full'] = $this->acl->is_allowed($this->user, $resource, 'get_full');

		return $allowed_methods;
	}
}
