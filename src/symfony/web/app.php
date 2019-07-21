<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

// Use APC for autoloading to improve performance.
// Change 'sf2' to a unique prefix in order to prevent cache key conflicts
// with other applications also using APC.
/*
$loader = new ApcClassLoader('sf2', $loader);
$loader->register(true);
*/
/*
use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;

if(_CFG_DEBUG == true || (array_key_exists("EVERYBILL_SERVER_ID", $_SERVER) && $_SERVER["EVERYBILL_SERVER_ID"] === "HotelCalifornia")) {
	$rollbarEnvironment = "development";
} else {
	$rollbarEnvironment = "production";
}

$rollbarConfig = array(
        'access_token' => '4de1410a32ec46afa71191901f413232',
        'environment' => $rollbarEnvironment
);

//Rollbar::init($rollbarConfig);
*/
require_once __DIR__.'/../app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
