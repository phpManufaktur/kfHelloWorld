<?php

/**
 * helloWorld
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/extendedWYSIWYG
 * @copyright 2012 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace thirdParty\helloWorld\Data;


class helloWorld {
	
	protected $app = null;
	
	public function __construct($app) {
		$this->app = $app;
	} // __construct()
	
	/**
	 * Create the data table for the Hello World extension
	 * 
	 * @throws \Exception
	 * @return boolean
	 */
	public function CreateTable() {
		$table = FRAMEWORK_TABLE_PREFIX.'hello_world_data';
		$SQL = <<<EOD
    CREATE TABLE IF NOT EXISTS `$table` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `section_id` INT(11) NOT NULL DEFAULT '0',
      `page_id` INT(11) NOT NULL DEFAULT '0',
      `content` LONGTEXT NOT NULL,
      `timestamp` TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY (`section_id`, `page_id`)
    )
    COMMENT='helloWorld Data table'
    ENGINE=InnoDB
    AUTO_INCREMENT=1
    DEFAULT CHARSET=utf8
    COLLATE='utf8_general_ci'
EOD;
		try {
			$this->app['db']->query($SQL);
			$this->app['monolog']->addDebug('Created table hello_world_data');
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
		return true;
	} // CreateTable()
	
	/**
	 * Drop the table of the Hello World extension
	 * 
	 * @throws \Exception
	 * @return boolean
	 */
	public function DeleteTable() {
		try {
			$this->app['db']->query("DROP TABLE IF EXISTS `".FRAMEWORK_TABLE_PREFIX."hello_world_data`");
			$this->app['monolog']->addDebug('Dropped table hello_world_data');
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
		return true;
	} // DeleteTable()
	
	/**
	 * Insert a new record into the table hello_world_data
	 * 
	 * @param integer $page_id
	 * @param integer $section_id
	 * @param integer &$inserted_id reference, return the new ID
	 * @throws \Exception
	 * @return boolean
	 */
	public function Insert($page_id, $section_id, &$inserted_id) {
		try {
			$data = array(
					'page_id' => $page_id,
					'section_id' => $section_id,
					'content' => ''
					);
			$this->app['db']->insert(FRAMEWORK_TABLE_PREFIX.'hello_world_data', $data);
			$inserted_id = $this->app['db']->LastInsertId();
			$this->app['monolog']->addDebug("Inserted record with the id $inserted_id into the table hello_world_data");
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
		return true;
	} // Insert()
	
	public function Update($page_id, $section_id, $content) {
		
	} // Update()
	
} // class helloWorld