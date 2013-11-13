<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Ushahidi API Base Controller
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application\Controllers
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

abstract class Ushahidi_Controller_Api_Root extends Controller_Api_Core {

	/**
	 * Check if access is allowed
	 * Overriding to always return TRUE for version info
	 *
	 * @return boolean
	 */
	protected function _check_access()
	{
		return TRUE;
	}

	/**
	 * GET /api
	 *
	 * @return void
	 */
	public function action_get_index_collection()
	{
		$this->_response_payload = array(
			'api_version' => $this->version(),
			'ushahidi_version' => $this->ushahidi_version(),
		);
	}

}
