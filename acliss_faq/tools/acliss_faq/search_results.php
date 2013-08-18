<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$cnt = Loader::controller('/dashboard/acliss_faq/search');
$aclissfaqList = $cnt->getRequestedSearchResults();

$aclissfaq = $aclissfaqList->getPage();

Loader::packageElement('acliss_faq/search_results', 'acliss_faq', array('aclissfaq' => $aclissfaq, 'aclissfaqList' => $aclissfaqList));