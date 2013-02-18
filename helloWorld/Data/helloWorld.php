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

use phpManufaktur\Toolbox\Toolbox;

class helloWorld {
	
	protected $app = null;
	
	public function __construct($app) {
		$this->app = $app;
	} // __construct()
	
	/**
	 * Create the data table for the Hello World extension
	 * 
	 * @throws \Exception
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
	} // CreateTable()
	
	/**
	 * Drop the table of the Hello World extension
	 * 
	 * @throws \Exception
	 */
	public function DeleteTable() {
		try {
			$this->app['db']->query("DROP TABLE IF EXISTS `".FRAMEWORK_TABLE_PREFIX."hello_world_data`");
			$this->app['monolog']->addDebug('Dropped table hello_world_data');
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
	} // DeleteTable()
	
	/**
	 * Insert a new record into the table hello_world_data
	 * 
	 * @param integer $page_id
	 * @param integer $section_id
	 * @param integer &$inserted_id reference, return the new ID
	 * @throws \Exception
	 */
	public function Insert($page_id, $section_id, &$inserted_id=-1) {
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
	} // Insert()
	
	/**
	 * Update the table hello_world_data with content for the desired page_id
	 * and section_id
	 * 
	 * @param integer $page_id
	 * @param integer $section_id
	 * @param string $content
	 * @throws \Exception
	 */
	public function Update($page_id, $section_id, $content) {
		try {
			$Toolbox = new Toolbox($this->app);
			$data = array(
					'content' => $Toolbox->sanitizeText($content)
					);
			$where = array(
					'page_id' => $page_id,
					'section_id' => $section_id
					);
			$this->app['db']->update(FRAMEWORK_TABLE_PREFIX.'hello_world_data', $data, $where);
			$this->app['monolog']->addDebug("Update hello_world_data where section_id=$section_id and page_id=$page_id");
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
	} // Update()
	
	/**
	 * Delete a record from the table hello_world_data
	 * 
	 * @param integer $page_id
	 * @param integer $section_id
	 * @throws \Exception
	 */
	public function Delete($page_id, $section_id) {
		try {
			$where = array(
					'page_id' => $page_id,
					'section_id' => $section_id
					);
			$this->app['db']->delete(FRAMEWORK_TABLE_PREFIX.'hello_world_data', $where);
			$this->app['monolog']->addDebug("Delete record from hello_world_data where page_id=$page_id and section_id=$section_id");
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
	} // Delete()
	
	/**
	 * Select the record for the given page_id and section_id from table hello_world_data
	 * and return the array
	 * 
	 * @param integer $page_id
	 * @param integer $section_id
	 * @throws \Exception
	 * @return boolean|multitype:Ambigous return FALSE if the record is empty
	 */
	public function Select($page_id, $section_id) {
		try {
			$Toolbox = new Toolbox($this->app);
			$SQL = "SELECT * FROM `".FRAMEWORK_TABLE_PREFIX."hello_world_data` WHERE ".
					"`section_id`='$section_id' AND `page_id`='$page_id'";
			$record = $this->app['db']->fetchAssoc($SQL);
			if (!is_array($record)) {
				$this->app['monolog']->addDebug("Selected record from hello_world_data where page_id=$page_id and section_id=$section_id is empty!");
				return false;
			}
			$this->app['monolog']->addDebug("Select record from hello_world_data where page_id=$page_id and section_id=$section_id");
			$result = array();
			foreach ($record as $key => $value) 
				$result[$key] = (is_string($value)) ? $Toolbox->unsanitizeText($value) : $value;
		  return $result;
		} catch (\Doctrine\DBAL\DBALException $e) {
			throw new \Exception($e->getMessage(), 0, $e);
		}
	} // Select()

} // class helloWorld