<?php

defined('C5_EXECUTE') or die("Access Denied.");

/**
 *
 * A filtered list of custom objects
 * @package Item List Demo
 *
 */
class AclissFaqList extends DatabaseItemList {

	private $queryCreated;
	protected $autoSortColumns = array("ID");
	protected $itemsPerPage = 10;

	protected function setBaseQuery() {
		$this->setQuery('SELECT * FROM aclissfaq');
	}

	public function createQuery() {
		if (!$this->queryCreated) {
			$this->setBaseQuery();
			$this->queryCreated = 1;
		}
	}

	public function get($itemsToGet = 0, $offset = 0) {
		Loader::model("acliss_faq", "acliss_faq");
		$aclissfaqList = array();
		$this->createQuery();
		$r = parent::get($itemsToGet, $offset);
		foreach ($r as $row) {
			$aclissfaq = AclissFaq::getByID($row['ID']);
			$aclissfaqList[] = $aclissfaq;
		}
		return $aclissfaqList;
	}

	public function getTotal() {
		$this->createQuery();
		return parent::getTotal();
	}

	public static function getAllAclissFaq() {
		Loader::model("acliss_faq", "acliss_faq");
		$aclissfaqList = array();
		$aclissfaqList = new AclissFaqList();
		$aclissfaqList->createQuery();
		$aclissfaq = $aclissfaqList->get();
		return $aclissfaq;
	}

	public function filterByQuestion($question){
		$db = Loader::db();
		$question = $db->quote("%" . $question . "%");
		$this->filter(false, '(question LIKE ' . $question . ")");
	}
}
