<?php

/**
 * helloWorld
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/extendedWYSIWYG
 * @copyright 2012 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

if ('á' != "\xc3\xa1") {
	// the language files must be saved as UTF-8 (without BOM)
	throw new \Exception('The language file '.__FILE__.' is damaged, it must be saved UTF-8 encoded!');
}

return array(
		'For the PAGE_ID %page_id% and SECTION_ID %section_id% does not exists a data record!'
			=> 'Für die Kombination PAGE_ID %page_id% und SECTION_ID %section_id% existiert kein Datensatz!',
		'Missing the PAGE_ID and/or the SECTION_ID!'
			=> 'Die PAGE_ID und/oder SECTION_ID wurde nicht übermittelt!',
		'Please <a href="https://github.com/phpManufaktur/kfHelloWorld" target="_blank">check out the program code</a> and the <a href="https://github.com/phpManufaktur/kfHelloWorld/wiki" target="_blank">tutorial for the Hello World extension</a>.'
			=> 'Bitte <a href="https://github.com/phpManufaktur/kfHelloWorld" target="_blank">laden Sie sich den Quelltext herunter</a> und <a href="https://github.com/phpManufaktur/kfHelloWorld/wiki" target="_blank">lesen Sie die Anleitung</a> zu der Hello World Extension.',
		'Sample value, will be saved in a data table'
			=> 'Beispielwert, wird in einer Datentabelle gesichert',
		'Submit'
			=> 'Übernehmen',
		'Text string'
			=> 'Zeichenkette',
		'The "content" field must be set and contain any data!'
			=> 'Das Feld "CONTENT" muss gesetzt sein und darf nicht leer sein!',
		'The Hello World extension show you how to use the KeepInTouch Framework to create a application which can be used within the framework and also as page view addon within the Content Management System WebsiteBaker or LEPTON CMS.'
			=> 'Die "Hello World Extension" zeigt Ihnen, wie Sie das KeepInTouch Framework nutzen können, um eine Anwendung für das Framework zu erstellen die darüber hinaus auch als Add-on für das Content Management System WebsiteBaker oder LEPTON CMS genutzt werden kann.',
		'Welcome to the Hello World extension!'
			=> 'Herzlich Willkommen bei der Hello World Extension!'
		);