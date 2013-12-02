<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Connect to the proper database when using Cloud
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

class Cloud
{
	/**
	 * Configures the appripriate database to connect to
	 */
	public static function database($cloud_db)
	{

		// Find out where we are before we try and swap out the database
		$current_domain = self::domain();
		$config = Kohana::$config->load('cloud');
		$cloud_domain = $config->get('cloud_domain');

		if($cloud_domain == $current_domain)
		{
			// We are not trying to access a site, just the interface where
			//   we can manage the different sites.
			return $cloud_db;
		}

		$db = new mysqli($cloud_db['default']['connection']['hostname'],
						 $cloud_db['default']['connection']['username'],
						 $cloud_db['default']['connection']['password'],
						 $cloud_db['default']['connection']['database']);

		if (mysqli_connect_errno())
		{
			throw new Kohana_Exception("Cloud Module Error: Connect failed: %s\n", mysqli_connect_error());
		}

		$site_found = false;
		$active = NULL;

		$sql = "SELECT active, db_hostname, db_username, db_password, db_database FROM cloud_sites WHERE domain = ? LIMIT 1";
		if ($stmt = $db->prepare($sql))
		{
			$stmt->bind_param("s", $current_domain);
			$stmt->execute();
			$stmt->bind_result($active, $hostname, $username, $password, $database);
			$stmt->store_result();
			$stmt->fetch();

			$site_found = (bool)$stmt->num_rows;

			if ($site_found AND $active)
			{
				// Set the proper database
				$cloud_db['default']['connection']['hostname'] = $hostname;
				$cloud_db['default']['connection']['username'] = $username;
				$cloud_db['default']['connection']['password'] = $password;
				$cloud_db['default']['connection']['database'] = $database;
			}

			$site_found = (bool)$stmt->num_rows;

			$stmt->close();
		}else{
			throw new Kohana_Exception('Cloud Module Error: There was an error looking up the proper connection details for this site.');
		}
		$db->close();

		if (! $site_found)
		{
			throw new Kohana_Exception('Cloud Module Error: There is no site configured at this address.');
		}

		if($site_found AND $active === 0)
		{
			throw new Kohana_Exception('Cloud Module Error: The site at this address is inactive.');
		}

		return $cloud_db;
	}

	/**
	 * Creates a new site
	 */
	public static function create($params)
	{
		// Make sure we have a full hostname
		$domain = $params['domain'];
		if (! strpos($domain,'.'))
		{
			$config = Kohana::$config->load('cloud');
			$cloud_domain = $config->get('cloud_domain');
			$domain .= '.'.$cloud_domain;
		}



		$site = ORM::factory('Cloud_Site');
		$site->user_id = 1;
		$site->domain = $domain;
		$site->active = 1;
		return $site->save();
	}

	/**
	 * Returns the current domain. https://ushahidi.com would return ushahidi.com
	 */
	private static function domain()
	{
		return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
	}
}
