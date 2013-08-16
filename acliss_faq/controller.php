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

}