<?php

/**
 * helloWorld
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/extendedWYSIWYG
 * @copyright 2012 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use thirdParty\helloWorld\Control\Modify;
use thirdParty\helloWorld\Data\Setup\Setup;

// add the path to the kitFramework Twig templates
$app['twig.loader.filesystem']->addPath(
		THIRDPARTY_PATH.'/helloWorld/View/Templates'
);

// scan the /Locale directory and add all available languages
try {
	$locale_path = THIRDPARTY_PATH.'/helloWorld/Data/Locale';
	if (false === ($lang_files = scandir($locale_path)))
		throw new \Exception(sprintf("Can't read the /Locale directory %s!", $locale_path));
	$ignore = array('.', '..', 'index.php');
	foreach ($lang_files as $lang_file) {
		if (in_array($lang_file, $ignore)) continue;
		$lang_name = pathinfo($locale_path.'/'.$lang_file, PATHINFO_FILENAME);
		// add the locale resource file
		$app['translator']->addResource('array', $frameworkUtils->returnArrayFromFile($locale_path.'/'.$lang_file), $lang_name);		
	}
}
catch (\Exception $e) {
	throw new \Exception(sprintf('Error scanning the /Locale directory %s.', $locale_path), 0, $e);
}

// catch helloWorld modify.php from the CMS
$app->post('/helloworld/modify', function (Request $request) use ($app) {
	$data = json_decode($request->get('data'), true);
	$Modify = new Modify($app, $data);
	return new Response($Modify->Dialog());
});

$app->post('/helloworld/save', function (Request $request) use ($app) {
	$data = json_decode($request->get('data'), true);
	return new Response('OK');
});

$app->get('/helloworld/setup', function () use ($app) {
	$Setup = new Setup($app);
	$Setup->exec();
	return new Response('OK');
});

