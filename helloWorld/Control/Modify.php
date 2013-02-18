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
class Modify {
	
	// pointer to the application and the submitted data
	protected $app = null;
	protected $data = null;
	
	// set PAGE_ID and SECTION_ID
	protected static $PAGE_ID = null;
	protected static $SECTION_ID = null;
	
	/**
	 * Constructor for the class Modify
	 * 
	 * @param Application $app
	 * @param array $data
	 */
	public function __construct($app, $data) {
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
	 * Create the modify dialog for the Hello World extension
	 * 
	 * @return string dialog
	 */
	public function Dialog() {
		
		$helloWorld = new helloWorld($this->app);
		if (false === ($record = $helloWorld->Select(self::$PAGE_ID, self::$SECTION_ID))) {
			// problem: there exists no data record for this PAGE_ID and SECTION_ID!
			return $this->app['translator']->trans('For the PAGE_ID %page_id% and SECTION_ID %section_id% does not exists a data record!',
					array('%page_id%' => self::$PAGE_ID, '%section_id%' => self::$SECTION_ID));
		}
		
		// the data array contains all information for the template
		$data = array(
				'action' => CMS_URL.'/modules/helloworld/save.php',
				'page_id' => array(
						'name' => 'page_id',
						'value' => self::$PAGE_ID
						),
				'section_id' => array(
						'name' => 'section_id',
						'value' => self::$SECTION_ID
						),
				'content' => array(
						'name' => 'content',
						'value' => $record['content']
						)
				);
		// call Twig to render and return the complete modify dialog
		return $this->app['twig']->render('modify.twig', $data);
	} // Dialog()
	
} // class Modify
