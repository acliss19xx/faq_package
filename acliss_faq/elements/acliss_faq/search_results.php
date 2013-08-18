<?php
defined('C5_EXECUTE') or die("Access Denied.");
$ih = Loader::helper('concrete/interface');
$form = Loader::helper('form');
?> 

<div id="ccm-acliss-faq-search-results">

	<div class="ccm-pane-body">
		<div style="margin-bottom: 10px">
			<?php print $ih->button(t('Add FAQ'), View::url('/dashboard/acliss_faq/add'), 'right', 'primary'); ?>
			<div class="clearfix"></div>
		</div>
		<div id="ccm-list-wrapper">
			<a name="ccm-acliss-faq-list-wrapper-anchor"></a>
			<?php
			$txt = Loader::helper('text');
			$question = $_REQUEST['question'];
			$url = Loader::helper('concrete/urls');
			$bu = $url->getToolsURL('acliss_faq/search_results', 'acliss_faq');

			if (count($aclissfaq) > 0) {
				?>	
				<table border="0" cellspacing="0" cellpadding="0" id="ccm-acliss-faq-list" class="ccm-results-list">
					<tr>
						<th class="<?php echo $aclissfaqList->getSearchResultsClass('question') ?>">
							<a href="<?php echo $aclissfaqList->getSortByURL('question', 'asc', $bu) ?>">
							<?php echo t("Question"); ?>
							</a>
						</th>
						<th width="135px"></th>
					</tr>
					<?php
					foreach ($aclissfaq as $faq) {
						$editAction = View::url('/dashboard/acliss_faq/add', 'edit', $faq->getAclissFaqID());
						$deleteAction = View::url('/dashboard/acliss_faq/add', 'confirm_delete', $faq->getAclissFaqID());

						if (!isset($striped) || $striped == 'ccm-list-record-alt') {
							$striped = '';
						} else if ($striped == '') {
							$striped = 'ccm-list-record-alt';
						}
						?>

						<tr class="ccm-list-record <?php echo $striped ?>">
							<td><?php echo $txt->highlightSearch($faq->getQuestion(), $question); ?></td>
							<td>
								<?php print $ih->button(t('Edit'), $editAction, 'right', 'primary', array('style' => "margin-left: 10px")); ?>
								<?php print $ih->button(t('Delete'), $deleteAction, 'right', 'error'); ?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			<?php } else { ?>
				<div id="ccm-list-none"><?php echo t('No FAQ Found.') ?></div>
			<?php } ?>

		</div>

		<?php $aclissfaqList->displaySummary(); ?>
		<div class="clearfix"></div>
	</div>

	<div class="ccm-pane-footer">
		<?php $aclissfaqList->displayPagingV2($bu, false); ?>
		<div class="clearfix"></div>
	</div>

</div>
