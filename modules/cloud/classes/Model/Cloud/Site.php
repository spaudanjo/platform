<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for Cloud Site
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application\Models
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

class Model_Cloud_Site extends ORM {
	/**
	 * TODO: When DB schema is built out, include relationships
	 *
	 * @var array Relationships
	 */
	protected $_has_many = array();
	protected $_belongs_to = array();

	// Insert/Update Timestamps
	protected $_created_column = array('column' => 'created', 'format' => "Y-m-d H:i:s");

	/**
	 * Filters for the cloud site model
	 *
	 * @return array Filters
	 */
	public function filters()
	{
		return array(
			'domain' => array(
				array('trim'),
				array('UTF8::strtolower')
			),

			'custom_domain' => array(
				array('trim'),
				array('UTF8::strtolower')
			),
		);
	}

	/**
	 * Rules for the cloud site
	 *
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			'site_id' => array(
				array('numeric')
			),

			'user_id' => array(
				array('not_empty'),
				array('numeric')
			),

			'domain' => array(
				array('not_empty'),
				array('max_length', array(':value', 100)),
			),

			'custom_domain' => array(
				array('max_length', array(':value', 100)),
			),

			'active' => array(
				array('numeric'),
				array('max_length', array(':value', 1))
			)
		);
	}

}
