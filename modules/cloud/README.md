# Cloud

A module that allows you to set up a multi-site Ushahidi v3 "cloud" site.

## How Does This Work?

Cloud utilizes a single application that connects to a different database for every site that is set up. These sites are configured at varioud domains. https://site1.yoursite.com, https://anothersite.yoursite.com, etc. With this model, https://yoursite.com becomes a gateway for people to come and create new sites on subdomains.

When a user sets up a new site, a new database is created for that site. This module figures out which database to use when someone is accessing each individual site.

## Installation

* Uncomment the line for "cloud" in /application/config/modules.php
* Copy /application/config/cloud.php to your config directory for your environment (probably /application/config/environments/development/)
* Edit the cloud_domain to be the domain of your site with no slashes or protocol (ie: ushahidi.com)
* In your database.php config file, probably in the same directory as the cloud.php file you just modified, wrap the array that's being returned with Cloud::database(), ensuring that the database you configured is called "default". It should look something like this:

```php
return Cloud::database(array('default' => array
(
	'type'       => 'MySQLi',
	'connection' => array(
		'hostname'   => 'YOUR_DB HOSTNAME',
		'database'   => 'YOUR_DB_NAME',
		'username'   => 'YOUR_DB_USERNAME',
		'password'   => 'YOUR_DB_PASSWORD',
		'persistent' => FALSE,
	),
	'table_prefix' => '',
	'charset'      => 'utf8',
	'caching'      => TRUE,
	'profiling'    => TRUE,
)));
```

* Ensure that your 'base_url' in your init.php config file remains a single forward slash like '/'. The reason for this is the URL for the deployment will be dynamic, depeneding on which site is being viewed, and this allows us to use any domain.