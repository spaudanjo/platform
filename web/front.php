<?php

// Ushahidi Web is a front end for the Ushahidi API.
//
// > This code was crafted by the [Ushahidi Team][ushteam] and is copyright (c)
// 2014 by [Ushahidi][ush]. It is licensed under the [GNU Affero General Public
// License Version 3][license] (AGPL3).
//
// [ush]: http://ushahidi.com
// [ushteam]: team@ushahidi.com
// [license]: https://www.gnu.org/licenses/agpl-3.0.html

// This file is very simple front matter for a (mostly) [Backbone][backbone]
// and [Marionette][marionette], styled by [Foundation][foundation],
// [client-side application](/js) that is powered by [the API](/api).
//
// [backbone]: http://backbonejs.org/
// [marionette]: http://marionettejs.com/
// [foundation]: http://foundation.zurb.com/

// If you want to modify the server side configuration or template, read on.
//
// During development, the app can be run with the [built-in PHP server][phpserver].
// When being used as a router, it is expected that the router return `false`
// to use the server to pass the file through.
//
// [phpserver]: http://php.net/manual/features.commandline.webserver.php

if (php_sapi_name() === 'cli-server') {

    // Checking for the file simply involves getting the requested filename
    // from the requested URI, without the `?query=string` or `#anchor`.
    $filename = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $filename)) {
        return false;

    // We also never allow favicon to be served by the app.
    } elseif ($filename === 'favicon.ico') {
        return false;
    }
}

// Now that we are sure this is a request for our app, we can proceed.
// For dependency management and autoloading, we use [Composer][composer].
//
// **If you haven't already done so, you should run `composer install` now.**
//
// [composer]: http://getcomposer.org/

require __DIR__ . '/../vendor/autoload.php';

// The [app](app.html) is where basic configuration is read and routing generated.

$app = require __DIR__ . '/../src/UshahidiWeb/app.php';

// Slim routing gets confused when using the built-in server, which requires us
// to overload the PATH_INFO enviornment variable back to the original filename.
if (isset($filename)) {
    $app->environment['PATH_INFO'] = $filename;
}

// Once the app is ready, we run it.

$app->run();
