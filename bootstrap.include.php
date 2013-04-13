<?php

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