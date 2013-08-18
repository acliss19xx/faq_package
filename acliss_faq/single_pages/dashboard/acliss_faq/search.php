<?php
defined('C5_EXECUTE') or die("Access Denied.");
$ih = Loader::helper('concrete/interface');
?>


<?php if ($_REQUEST['acliss_faq_created'] || $_REQUEST['acliss_faq_updated']) { ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('FAQ Details'), "", false, false); ?>
	<div class="ccm-pane-options">
		<?php print $ih->button(t('Edit Again'), $this->url('/dashboard/acliss_faq/add/', 'edit', $aclissfaq->getAclissFaqID()), 'left', 'primary'); ?>
		<?php print $ih->button(t('Delete'), $this->url('/dashboard/acliss_faq/add/', 'confirm_delete', $aclissfaq->getAclissFaqID()), 'left', 'error'); ?>
		<?php print $ih->button(t('Back to List'), $this->url('/dashboard/acliss_faq/search/'), 'right', 'primary'); ?>
	</div>
	<div class="ccm-pane-body">
		<dl>
			<dt><?php echo t("question");?></dt>
			<dd><?php echo $aclissfaq->getQuestion();?></dd>
			<dt><?php echo t("answer");?></dt>
			<dd><?php echo $aclissfaq->getAnswer();?></dd>
		</dl>
	</div>
<?php } else { ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Search FAQ'), t('Search and Edit FAQ.'), false, false); ?>
	<div class="ccm-pane-options" id="ccm-acliss-faq-pane-options">
		<?php
		Loader::packageElement('acliss_faq/search_form', 'acliss_faq');
		?>
	</div>

	<?php
	Loader::packageElement(
	   'acliss_faq/search_results', 'acliss_faq', array(
	    'aclissfaq' => $aclissfaq,
	    'aclissfaqList' => $aclissfaqList));
	?>
<?php } ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>
