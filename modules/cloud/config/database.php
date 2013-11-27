<?php
/**
 * Cloud Database Config And Routing
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application\Config
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

// This is the database that holds the information about your sites
$cloud_db = array
(
	'default' => array
	(
		'type'       => 'MySQLi',
		'connection' => array(
			'hostname'   => '127.0.0.1',
			'database'   => 'cloud',
			'username'   => 'root',
			'password'   => '',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => TRUE,
		'profiling'    => TRUE,
	)
);

// used to determine which database to connect with
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

$db = new mysqli($cloud_db['default']['connection']['hostname'],
					 $cloud_db['default']['connection']['username'],
					 $cloud_db['default']['connection']['password'],
					 $cloud_db['default']['connection']['database']);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

echo '<pre>';
if ($stmt = $db->prepare("SELECT db_hostname, db_username, db_password, db_database FROM site WHERE domain = ? LIMIT 1")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $domain);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    //$stmt->bind_result($db_hostname, $db_username, $db_password, $db_database);
    $stmt->bind_result($hostname, $username, $password, $database);

    /* fetch value */
    $stmt->fetch();

    var_dump($hostname);
    $cloud_db['default']['connection']['hostname'] = $hostname;
	$cloud_db['default']['connection']['username'] = $username;
	$cloud_db['default']['connection']['password'] = $password;
	$cloud_db['default']['connection']['database'] = $database;

    /* close statement */
    $stmt->close();
}else{
	var_dump('sad.');
}

var_dump($cloud_db);



$db->close();
die();




return $cloud_db;