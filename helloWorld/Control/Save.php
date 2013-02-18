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

class Save {
	
	// pointer to the application and the submitted data
	protected $app = null;
	protected $data = null;
	
	// set PAGE_ID and SECTION_ID
	protected static $PAGE_ID = null;
	protected static $SECTION_ID = null;
	
	// set the CONTENT
	protected static $CONTENT = null;
	
	/**
	 * Constructor for the class Save
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
		if (!isset($this->data['POST']['page_id']) || !isset($this->data['POST']['section_id']))
			throw new \Exception('Missing the PAGE_ID and/or the SECTION_ID!');
		
		// set PAGE_ID and SECTION_ID for internal use
		self::$PAGE_ID = (int) $this->data['POST']['page_id'];
		self::$SECTION_ID = (int) $this->data['POST']['section_id'];
		
		// enshure that the CONTENT isset
		self::$CONTENT = isset($this->data['POST']['content']) ? $this->data['POST']['content'] : '';
	} // __construct()
	
	/**
	 * Check the data of the record and update the specified record
	 * 
	 * @return string 'OK' on success or message on failure or problem
	 */
	public function exec() {
		if (empty(self::$CONTENT))
			return $this->app['translator']->trans('The "content" field must be set and contain any data!');

		// save the content
		$helloWorld = new helloWorld($this->app);
		$helloWorld->Update(self::$PAGE_ID, self::$SECTION_ID, self::$CONTENT);
		
		return 'OK';
	} // exec()
	
} // class Save
