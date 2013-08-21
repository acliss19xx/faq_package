<?php

defined('C5_EXECUTE') or die("Access Denied.");

class DashboardAclissFaqSearchController extends Controller {

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
          $aclissfaqList = $this->getRequestedSearchResults();
          $aclissfaqList->sortBy('afDisplayOrder','asc');
          $aclissfaq = $aclissfaqList->getPage();

          $this->set('aclissfaqList', $aclissfaqList);
          $this->set('aclissfaq', $aclissfaq);

          if ($_REQUEST['acliss_faq_created']) {
               $this->set('message', t('FAQ Created.'));
               $aclissfaq = AclissFaq::getByID($_REQUEST['afID']);
               $this->set('aclissfaq', $aclissfaq);
          }

          if ($_REQUEST['acliss_faq_updated']) {
               $this->set('message', t('FAQ Updated.'));
               $aclissfaq = AclissFaq::getByID($_REQUEST['afID']);
               $this->set('aclissfaq', $aclissfaq);
          }

          if ($_REQUEST['acliss_faq_deleted']) {
               $this->set('message', t('FAQ Deleted.'));
          }
     }

     public function getRequestedSearchResults() {

          Loader::model('acliss_faq', 'acliss_faq');
          Loader::model('acliss_faq_list', 'acliss_faq');

          $aclissfaqList = new AclissFaqList();

          if ($_REQUEST['question'] != '') {
               $aclissfaqList->filterByQuestion($_GET['question']);
          }
          if ($_REQUEST['answer']) {
               $aclissfaqList->setItemsPerPage($_REQUEST['answer']);
          }
          return $aclissfaqList;
     }
}