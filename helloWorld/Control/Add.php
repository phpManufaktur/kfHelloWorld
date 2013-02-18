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

use thirdParty\helloWorld\Data\helloWorld;
use Silex\Application;

class Add {
	
	// pointer to the application and the submitted data
	protected $app = null;
	protected $data = null;
	
	// set PAGE_ID and SECTION_ID
	protected static $PAGE_ID = null;
	protected static $SECTION_ID = null;
	
	/**
	 * Constructor for the class Add
	 * 
	 * @param Application $app
	 * @param array $data
	 */
	public function __construct(Application $app, $data) {
		$this->app = $app;
		$this->data = $data;
		
		// we need the locale information from the CMS
		if (!isset($this->data['locale']))
			throw new \Exception('Missing the locale information!');	
		
		// setting the locale with the language information from the CMS	
		$this->app['translator']->setLocale($this->data['locale']);	

		// PAGE_ID and SECTION_ID must be set!
		if (!isset($this->data['page_id']) || !isset($this->data['section_id']))
			throw new \Exception('Missing the PAGE_ID and/or the SECTION_ID!');
		
		// set PAGE_ID and SECTION_ID for internal use
		self::$PAGE_ID = (int) $this->data['page_id'];
		self::$SECTION_ID = (int) $this->data['section_id'];		
	} // __construct()
	
	/**
	 * Add a new record into the Hello World data table
	 * 
	 * @return string 'OK' on success or message on failure or problem
	 */
	public function exec() {
		// init the database class for Hello World
		$helloWorld = new helloWorld($this->app);
		// insert a new record into the table
		$helloWorld->Insert(self::$PAGE_ID, self::$SECTION_ID);
		return 'OK';
	} // exec()
	
} // class Add
