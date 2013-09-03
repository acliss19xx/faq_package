<?php

defined('C5_EXECUTE') or die("Access Denied.");

class AclissFaqBlockController extends BlockController {

	protected $btName = 'FAQ View';
	protected $btDescription = '管理画面で登録したFAQを表示するブロック';
	protected $btTable = 'btAclissFaq';
	protected $btInterfaceWidth = "200";
	protected $btInterfaceHeight = "200";
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;

	public function getSearchableContent() {
		
	}

	public function view() {
		Loader::model('acliss_faq', 'acliss_faq');
		Loader::model('acliss_faq_list', 'acliss_faq');

		$faqList = new AclissFaqList();
		if($this->sortBy == 'addDate') {
			$faqList->sortBy('afDateAdd','desc');
		}elseif($this->sortBy == 'modifiedDate'){
			$faqList->sortBy('afDateModified','desc');
		}elseif($this->sortBy == 'displayOrder'){
			$faqList->sortBy('afDisplayOrder', 'asc');
		}
			
		$faqs = $faqList->get();

		$this->set('faqs', $faqs);
	}

}
