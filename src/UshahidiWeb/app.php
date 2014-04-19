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

// The app is extremely simple...

$app = new Slim(array(
    'templates.path' => __DIR__ . '/views',
));

// All it does is display the [index view](indexView.html).

$displayIndex = function ($path = null) use ($app) {
    /* todo: use service to pass config into the view */
    $app->render('indexView.php');
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
