<?php

use Symfony\Component\HttpFoundation\Request;
use thirdParty\HelloWorld\Control\Sample05;
use thirdParty\HelloWorld\Control\Sample06;
use thirdParty\HelloWorld\Control\Sample07;
use thirdParty\HelloWorld\Control\Sample08;
use thirdParty\HelloWorld\Control\SiteModified;
use Symfony\Component\HttpFoundation\Session\Session;

// scan the /Locale directory and add all available languages
$app['utils']->addLanguageFiles(THIRDPARTY_PATH.'/HelloWorld/Data/Locale');


/**
 * Example 1
 *
 * "Hello World"
 */
$app->post('/command/helloworld', function ()
{
    return 'Hello World!';
})
->setOption('info', THIRDPARTY_PATH.'/HelloWorld/command.helloworld.json');

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
 * Show the CMS parameters as associated array
 *
 */
$app->post('/command/sample04', function (Request $request) {
    ob_start();
    echo "<pre>";
    print_r($request->request->all());
    echo "</pre>";
    return ob_get_clean();
})
->setOption('info', THIRDPARTY_PATH.'/HelloWorld/command.sample04.json');

/**
 * Example 5
 *
 * Use an object for the handling
 */
$app->post('/command/sample05', function () {
    $Sample = new Sample05();
    return $Sample->sayHello();
})
->setOption('info', THIRDPARTY_PATH.'/HelloWorld/command.sample05.json');

/**
 * Example 6
 *
 * Use Class kitCommand\Basic and the template engine Twig to display some
 * information about the used content management system
 */
$app->match('/command/sample06', function (Request $request) use ($app) {
    print_r($app['session']->all());

    //print_r($app['request']->session->all());
    //$sess = $request->getSession();
    //print_r($sess->get('kitcmd_ce4q65u1m'));
    //echo "test: ".
   // print_r($app['request']->getSession()->all());
    $Sample = new Sample06($app, 'ce4q65u1m');
    //echo "sess: ".$Sample->getSessionID();
    //print_r($app['session']->get('kitcmd_ce4q65u1m'));
    return $Sample->exec();
});

/**
 * Example 7b
 *
 * Use class kitCommand\Basic, Twig, Translator and the Form factory to create
 * and display a form to type in some data and give a response
 */
$app->match('/command/sample07b/{parameters}', function ($parameters) use ($app) {
    $Sample = new Sample07($app, $parameters);
    return $Sample->Sample07b();
});


/**
 * Sample 8: Start
 *
 * Use the function createIFrame() of class kitCommand\Basic to create a iframe
 * which will contain the response of the kitCommand. The iframe source point to
 * a route of the kitFramework.
 */
$app->match('/command/sample08', function () use ($app) {
    $Sample = new Sample08($app);
    $cmsGET = $Sample->getCMSgetParameters();
    $route = $Sample->getRedirectRoute();
    $parameter_id = isset($cmsGET['parameter_id']) ? $cmsGET['parameter_id'] : $Sample->getParameterID();

    // the source of the iframe points to a route of the kitFramework (see below)
    if (!empty($route)) {
        if (isset($cmsGET['id'])) {
            // i.e. in Step04 there is additional the ID needed
            $source = FRAMEWORK_URL."/helloworld/sample08/$route/".$cmsGET['id'].'?pid='.$parameter_id;
        }
        else {
            // redirect to the desired step
            $source = FRAMEWORK_URL."/helloworld/sample08/$route?pid=".$parameter_id;
        }
    }
    else {
        // no redirect, go to start
        $source = FRAMEWORK_URL."/helloworld/sample08/start?pid=".$parameter_id;
    }
    return $Sample->createIFrame($source);
});

/**
 * Sample 8: Route to start (default)
 *
 * Respond with a full rendered HTML5 page which is independend from any settings
 * of the Content Management System
 */
$app->match('/helloworld/sample08/start', function () use ($app) {
    $Sample = new Sample08($app);
    return $Sample->start();
});

$app->match('/helloworld/sample08/step02', function () use ($app) {
    $Sample = new Sample08($app);
    return $Sample->step02();
});

$app->match('/helloworld/sample08/step03', function () use ($app) {
    $Sample = new Sample08($app);
    return $Sample->step03();
});

$app->match('/helloworld/sample08/step04/{id}', function ($id) use ($app) {
    $Sample = new Sample08($app);
    return $Sample->step04($id);
});


$app->match('/command/sitemodified/{parameters}', function ($parameters) use ($app) {
    $SiteModified = new SiteModified($app, $parameters);
    return $SiteModified->exec();
})
->setOption('info', THIRDPARTY_PATH.'/HelloWorld/command.sitemodified.json');


$app->match('/search/command/helloworld/{parameters}', function ($parameters) use ($app) {
    $params = json_decode(base64_decode($parameters), true);
    $search = $params['search'];
    $search['text'] = 'Ich bin ein Treffer!';
    $result = array(
        'search' => $search
    );
    return base64_encode(json_encode($result));
});