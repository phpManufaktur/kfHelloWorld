<?php

/**
 * helloWorld
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/extendedWYSIWYG
 * @copyright 2012 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace thirdParty\helloWorld\Data\Setup;

use thirdParty\helloWorld\Data\helloWorld;

class Setup {
	
	protected $app = null;
	
	public function __construct($app) {
		$this->app = $app;
	} // __construct()
	
	public function exec() {
		$helloWorld = new helloWorld($this->app);
		$helloWorld->CreateTable();
		return true;
	} // exec()
	
} // class Setup