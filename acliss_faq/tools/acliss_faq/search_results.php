<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$cnt = Loader::controller('/dashboard/acliss_faqs/search');
$aclissfaqList = $cnt->getRequestedSearchResults();

$aclissfaq = $aclissfaqList->getPage();

Loader::packageElement('acliss_faqs/search_results', 'acliss_faq', array('aclissfaq' => $aclissfaq, 'aclissfaqList' => $aclissfaqList));