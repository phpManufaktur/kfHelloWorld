<?php

use thirdParty\HelloWorld\Control\Sample06;
use thirdParty\HelloWorld\Control\Sample07;

// scan the /Locale directory and add all available languages
$app['utils']->addLanguageFiles(THIRDPARTY_PATH.'/HelloWorld/Data/Locale');


/**
 * Example 1
 *
 * "Hello World" as kitCommand at any content of the CMS
 *
 */
$app->get('/command/helloworld/{parameters}', function ()
{
    return 'Hello World!';
});

/**
 * Example 2
 *
 * "Hello World" directly from kitFramework
 */
$app->get('/helloworld', function ()
{
    return 'Hello World!';
});

/**
 * Example 3: "Hello USER"
 */
$app->get('/helloworld/{name}', function ($name)
{
    return "Hello $name!";
});

/**
 * Example 4
 *
 * Show the automated generated parameter string
 */
$app->get('/command/sample04/{parameters}', function ($parameters)
{
    return "Parameters: $parameters";
});

/**
 * Example 5
 *
 * Show the parameters as associated array
 *
 */
$app->get('/command/sample05/{parameters}', function ($parameters) {
    $params = json_decode(base64_decode($parameters), true);
    ob_start();
    echo "<pre>";
    print_r($params);
    echo "</pre>";
    return ob_get_clean();
});

/**
 * Example 6
 *
 * Use Class phpManufaktur\Basic\Control\kitCommand\Basic for the handling
 */
$app->get('/command/sample06/{parameters}', function ($parameters) use($app) {
    $Sample = new Sample06();
    return $Sample->sayHello();
});

$app->get('/command/sample07a/{parameters}', function ($parameters) use ($app) {
    $Sample = new Sample07($app, $parameters);
    return $Sample->Sample07a();
});

$app->match('/command/sample07b/{parameters}', function ($parameters) use ($app) {
    $Sample = new Sample07($app, $parameters);
    return $Sample->Sample07b();
});

