<?php

defined('C5_EXECUTE') or die("Access Denied.");

class DashboardAclissFaqsSearchController extends Controller {

     public function on_start() {

          Loader::model('acliss_faq', 'acliss_faq');
          Loader::model('acliss_faq_list', 'acliss_faq');
          $this->set('form', Loader::helper('form'));
          $this->set('valt', Loader::helper('validation/token'));
          $this->set('valc', Loader::helper('concrete/validation'));
          $this->set('ih', Loader::helper('concrete/interface'));
          $this->set('av', Loader::helper('concrete/avatar'));
          $this->set('dtt', Loader::helper('form/date_time'));

          $this->error = Loader::helper('validation/error');
     }

     public function view() {
          $html = Loader::helper('html');
          $form = Loader::helper('form');
          $this->set('form', $form);
          $this->addHeaderItem('<script type="text/javascript">$(function() { ccm_setupAdvancedSearch(\'acliss-faq\'); });</script>');
          $aclissFaqList = $this->getRequestedSearchResults();
          $aclissFaq = $aclissFaqList->getPage();

          $this->set('$aclissFaqList', $$aclissFaqList);
          $this->set('aclissFaq', $aclissFaq);

          if ($_REQUEST['acliss_faq_created']) {
               $this->set('message', t('FAQ Created.'));
               $aclissFaq = AclissFaq::getByID($_REQUEST['ID']);
               $this->set('aclissFaq', $aclissFaq);
          }

          if ($_REQUEST['acliss_faq_updated']) {
               $this->set('message', t('FAQ Updated.'));
               $aclissFaq = AclissFaq::getByID($_REQUEST['ID']);
               $this->set('aclissFaq', $aclissFaq);
          }

          if ($_REQUEST['acliss_faq_deleted']) {
               $this->set('message', t('FAQ Deleted.'));
          }
     }

     public function getRequestedSearchResults() {

          Loader::model('acliss_faq', 'acliss_faq');
          Loader::model('acliss_faq_list', 'acliss_faq');

          $aclissFaqList = new AclissFaqList();

          if ($_REQUEST['question'] != '') {
               $aclissFaqList->filterByTitle($_GET['question']);
          }
          if ($_REQUEST['answer']) {
               $aclissFaqList->setItemsPerPage($_REQUEST['answer']);
          }
          return $aclissFaqList;
     }
}