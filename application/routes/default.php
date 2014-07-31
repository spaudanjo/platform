<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Ushahidi Default Routes
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application\Config
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

/**
 * Custom media router.
 */
Route::set('media', 'media/<filepath>', array(
		'filepath' => '.*', // Pattern to match the file path
	))
	->defaults(array(
		'controller' => 'Media',
		'action'     => 'serve',
	));


/**
 * Alert subscription router.
 */
Route::set('alert-subscriptions', 'api/v2/alert_subscriptions')
	->defaults(array(
		'action'     => 'index',
		'controller' => 'AlertSubscriptions',
		'directory'  => 'Api'
	));



/**
 * Set Posts API SubRoute
 */
Route::set('set-posts', 'api/v2/sets/<set_id>/posts(/<id>)',
	array(
		'set_id' => '\d+',
		'id' => '\d+'
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'Posts',
		'directory'  => 'Api/Sets'
	));

/**
 * Form Groups API SubRoute
 */
Route::set('form-groups', 'api/v2/forms/<form_id>/groups/<group_id>/<controller>(/<id>)',
	array(
		'form_id' => '\d+',
		'group_id' => '\d+',
		'id' => '\d+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api/Forms/Groups'
	));

/**
 * Forms API SubRoute
 */
Route::set('forms', 'api/v2/forms/<form_id>/<controller>(/<id>)',
	array(
		'form_id' => '\d+',
		'id' => '\d+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api/Forms'
	));

/**
 * Export Posts API SubRoute
 */
Route::set('export', 'api/v2/posts/export')
	->defaults(array(
		'action'     => 'index',
		'controller' => 'Export',
		'directory'  => 'Api/Posts'
	));

/**
 * GeoJSON API SubRoute
 */
Route::set('geojson', 'api/v2/posts/geojson(/<zoom>/<x>/<y>)',
	array(
		'zoom' => '\d+',
		'x' => '\d+',
		'y' => '\d+',
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'GeoJSON',
		'directory'  => 'Api/Posts'
	));

/**
 * GeoJSON API SubRoute
 */
Route::set('geojson-post-id', 'api/v2/posts/<id>/geojson',
	array(
		'id' => '\d+',
		'zoom' => '\d+',
		'x' => '\d+',
		'y' => '\d+',
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'GeoJSON',
		'directory'  => 'Api/Posts'
	));

/**
 * Posts API SubRoute
 */
Route::set('posts', 'api/v2/posts/<post_id>/<controller>(/<id>)',
	array(
		'post_id' => '\d+',
		'id' => '\d+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api/Posts'
	));

/**
 * Base Ushahidi API Route
 */
Route::set('current-user', 'api/v2/users/me')
	->defaults(array(
		'action'     => 'me',
		'directory'  => 'Api',
		'controller' => 'Users',
		'id'         => 'me'
	));

/**
 * Config API Route
 */
Route::set('config-api', 'api/v2/config(/<id>(/<key>))',
	array(
		'id' => '[a-zA-Z_-]+',
		'key' => '[a-zA-Z_.-]+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api',
		'controller' => 'Config',
	));

/**
 * Messages API Route
 */
Route::set('messages-api', 'api/v2/messages(/<id>(/<action>))',
	array(
		'id' => '\d+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api',
		'controller' => 'Messages'
	));

/**
 * Dataproviders API Route
 */
Route::set('dataproviders-api', 'api/v2/dataproviders(/<id>)',
	array(
		'id' => '[a-zA-Z_-]+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api',
		'controller' => 'DataProviders',
	));

/**
 * Base Ushahidi API Route
 */
Route::set('api', 'api/v2(/<controller>(/<id>))',
	array(
		'id' => '\d+'
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Api'
	));

/**
 * Translations API SubRoute
 */
Route::set('translations', 'api/v2/posts/<post_id>/translations(/<locale>)',
	array(
		'post_id' => '\d+',
		'locale' => '[a-zA-Z_]+'
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'Translations',
		'directory'  => 'Api/Posts'
	));

/**
 * OAuth Route
 * Have to add this manually because the class is OAuth not Oauth
 */
Route::set('oauth', 'oauth(/<action>)',
	array(
		'action' => '(?:index|authorize|token)',
	))
	->defaults(array(
			'controller' => 'OAuth',
			'action'     => 'index',
	));

/**
 * Ushahidi Frontend Routes
 */
Route::set('index', '(<misc>)',
	array(
		'misc' => '^(?!api/|oauth|user|media).*',
	))
	->defaults(array(
		'controller' => 'Main',
		'action'     => 'index',
	));

/**
 * Default Route
 */
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'ushahidi',
		'action'     => 'index',
	));

