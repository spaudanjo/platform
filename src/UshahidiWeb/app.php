<?php
// > This code was crafted by the [Ushahidi Team][ushteam] and is copyright (c)
// 2014 by [Ushahidi][ush]. It is licensed under the [GNU Affero General Public
// License Version 3][license] (AGPL3).
//
// [ush]: http://ushahidi.com
// [ushteam]: team@ushahidi.com
// [license]: https://www.gnu.org/licenses/agpl-3.0.html

// Ushahidi Web is a front end for the Ushahidi API.

namespace Ushahidi;

// It uses the [Slim][slim] framework.
// [slim]: http://www.slimframework.com/
use \Slim\Slim;

// And it uses the [Kohana][kohana] framework.
// [kohana]: http://kohanaframework.org/
require __DIR__ . '/../../application/kohana.php';

// The app is extremely simple...
$app = new Slim(array(
    'templates.path' => __DIR__ . '/views',
));

// All it does is display the [index view](indexView.html).
$displayIndex = function ($path = null) use ($app) {

    // The application service provider is used to access configuration.
    $config = service('config');

    // Which is passed into the [index view](indexView.html).
    $app->render('indexView.php', [
        'config' => [

            // Because site and features are stored with the config service,
            // admins can modify these values at any time.
            'site'     => $config->get('site')->asArray(),
            'features' => $config->get('features')->asArray(),

            // But some configuration is can only be changed by modifying the install.
            //
            // TODO: *This configuration should also be loaded through the service.*
            'oauth'    => [
                'client' => 'ushahidiui',
            ],

            // And some configuration is dynamic.
            //
            // TODO: *All of these values should be dependency injected.*
            'baseurl'  => \URL::base(TRUE, TRUE),
            'imagedir' => \Media::uri('/images/'),
            'cssdir'   => \Media::uri('/css/'),
            'jsdir'    => \Media::uri('/js/'),
            ],
        ]);
};


// To accomodate bookmarks made in the [client app](/js), which uses
// [pushState][pushstate] URLs, any URL that is sane and doesn't look like a
// filename will also serve the index page.
//
// *Filename URLs are typically assets, and we want to ensure that a proper
// 404 header is returned, as the app does not perform any asset pass-through.*
//
// [pushstate]: http://diveintohtml5.info/history.html

$app->get('/', $displayIndex);
$app->get('/:path', $displayIndex)
    ->conditions(array(
        'path' => '[a-zA-Z0-9/_-]+',
    ));

// Then it gives control back to the [front matter](front.html).
return $app;
