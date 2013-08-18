<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

class AclissFaqPackage extends Package {

     protected $pkgHandle = 'acliss_faq';
     protected $appVersionRequired = '5.6.1.2';
     protected $pkgVersion = '0.9';

     public function getPackageDescription() {
          return t('ページを作成しないタイプのFAQ作成.');
     }

     public function getPackageName() {
          return t('simple faq');
     }

	public function install() {

		$pkg = parent::install();
		$this->installSinglePages($pkg);
		$this->installBlocks($pkg);
	}

     public function uninstall() {

          parent::uninstall();
		$db = Loader::db();
          $db->Execute('truncate table aclissfaq');
     }


	private function installSinglePages($pkg) {
		Loader::model('single_page');

		$def = SinglePage::add('/dashboard/acliss_faq', $pkg);
		$def->update(array('cName' => t('Acliss Faq'), 'cDescription' => t('faq用のシングルページとブロックを提供します。')));

		$def = SinglePage::add('/dashboard/acliss_faq/search', $pkg);
		$def->update(array('cName' => t('Search FAQ'), 'cDescription' => t('Search FAQ.')));
		
		$def = SinglePage::add('/dashboard/acliss_faq/add', $pkg);
		$def->update(array('cName' => t('Add / Edit FAQ'), 'cDescription' => t('Add and Edit FAQ.')));
	}

	private function installBlocks($pkg) {
		$bt = BlockType::getByHandle('acliss_faq');
		if (!$bt || !is_object($bt)){
			BlockType::installBlockTypeFromPackage('acliss_faq', $pkg);
		} else {
			// the block already exists, so we want
			// to update it to use the block from our package
			// this might not be OK for marketplace stuff if
			// you are modifying other packages or the core
			Loader::db()->execute('update Pages set pkgID = ? where btID = ?', array($pkg->pkgID, $bt->getBlockTypeID()));
		}
	}
}