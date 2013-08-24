<?php defined('C5_EXECUTE') or die("Access Denied."); ?> 
<?php
$form = Loader::helper('form');
$url = Loader::helper('concrete/urls');
$urlSearchAction = $url->getToolsURL('acliss_faq/search_results', 'acliss_faq');
?>

<form method="get" id="ccm-acliss-faq-advanced-search" action="<?php echo $urlSearchAction; ?>">
	<input type="hidden" name="search" value="1" />

	<div class="ccm-pane-options-permanent-search">

		<div style="width: 160px; margin-left: 20px; float: left;">
			<?php echo $form->label('question', t('question')) ?>
<?php echo $form->text('question', $_REQUEST['question'], array('placeholder' => t('Question'), 'style' => 'width: 140px')); ?>
		</div>
		<div  style="width: 160px; margin-left: 20px; float: left;">
			<?php echo $form->label('answer', t('answer')) ?>
<?php echo $form->text('answer', $_REQUEST['answer'], array('placeholder' => t('Answer'), 'style' => 'width: 140px')); ?>
		</div>
		<div  style="width: 100px; margin-left: 20px; float: left;">
<?php echo $form->submit('ccm-search-acliss-faq', t('Search'), array('style' => 'margin-left: 10px; margin-top: 20px;')) ?>
			<img src="<?php echo ASSETS_URL_IMAGES ?>/loader_intelligent_search.gif" width="43" height="11" class="ccm-search-loading" id="ccm-acliss-faq-search-loading" />
		</div>
	</div>
</form>
