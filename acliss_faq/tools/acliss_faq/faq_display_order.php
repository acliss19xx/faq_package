<?php

defined('C5_EXECUTE') or die(_("Access Denied."));
$canRead = false;
$ch = Page::getByPath('/dashboard/acliss_faq/search');
$cp = new Permissions($ch);
if ($cp->canRead()) {
	$canRead = true;
}

if (!$canRead) {
	die(t("Access Denied."));
}

Loader::model('acliss_faq', 'acliss_faq');
$afID = intval($_REQUEST['afID']);
$afDisplayOrder = intval($_REQUEST['afDisplayOrder']);

if ($afID && $afDisplayOrder) {
	$af = AclissFaq::getByID($afID);
	$af->setFaqDisplayOrder($afDisplayOrder);
}