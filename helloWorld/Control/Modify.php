<?php

/**
 * helloWorld
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/extendedWYSIWYG
 * @copyright 2012 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace thirdParty\helloWorld\Control;

class Modify {
	
	protected $app = null;
	protected $data = null;
	
	public function __construct($app, $data) {
		$this->app = $app;
		$this->data = $data;	
	} // __construct()
	
	public function Dialog() {
		$data = array(
				'action' => CMS_URL.'/modules/helloworld/save.php',
				'page_id' => array(
						'name' => 'page_id',
						'value' => $this->data['page_id']
						),
				'section_id' => array(
						'name' => 'section_id',
						'value' => $this->data['section_id']
						),
				);
		return $this->app['twig']->render('modify.twig', $data);
	} // Dialog()
	
} // class Modify
