<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Cloud UI Controller
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\UI\Controllers
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

class Controller_Cloud extends Controller_Template {

	public $template = 'cloud/index';

	public function action_index()
	{
		$this->template->sites = ORM::factory('Cloud_Site')->find_all();
	}

	public function action_create()
	{
		Cloud::create($this->request->post());
		$this->redirect('cloud');
	}

}