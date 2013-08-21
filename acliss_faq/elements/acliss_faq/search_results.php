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
				<table border="0" cellspacing="0" cellpadding="0" id="ccm-acliss-faq-list-active" class="ccm-results-list">
					<thead>
						<tr>
							<th class="<?php echo $aclissfaqList->getSearchResultsClass('question') ?>">
								<a href="<?php echo $aclissfaqList->getSortByURL('question', 'asc', $bu) ?>">
								<?php echo t("Question"); ?>
								</a>
							</th>
							<th width="135px"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($aclissfaq as $faq) {

								if (!isset($striped) || $striped == 'ccm-list-record-alt') {
									$striped = '';
								} else if ($striped == '') {
									$striped = 'ccm-list-record-alt';
								}
						?>

							<tr class="ccm-list-record <?php echo $striped ?>" data-afid="<?php echo $faq->afID ?>">
								<td><?php echo $txt->highlightSearch($faq->getQuestion(), $question); ?></td>
								<td>
								<?php
									$editAction = View::url('/dashboard/acliss_faq/add', 'edit', $faq->getAclissFaqID()); 
									$deleteAction = View::url('/dashboard/acliss_faq/add', 'confirm_delete', $faq->getAclissFaqID());
									echo $ih->button(t('Edit'), $editAction, 'right', 'primary', array('style' => "margin-left: 10px")); 
									echo $ih->button(t('Delete'), $deleteAction, 'right', 'error'); 
								?>
									<img class="ccm-group-sort" src="<?php echo ASSETS_URL_IMAGES?>/icons/up_down.png" width="14" height="14" />
								</td>
							</tr>
						<?php
						}
						?>

					</tbody>
				</table>
				<script type="text/javascript">
					$(document).ready(function() {
						$("#ccm-acliss-faq-list-active tbody").sortable({
							handle: 'img.ccm-group-sort',
							cursor: 'move',
							opacity: 0.5,
							stop: function(event, ui) {
								var afID = ui.item.attr('data-afid');
								var afDisplayOrder = ui.item.index() + 1;
								var data = 'afID=' + afID + '&afDisplayOrder=' + afDisplayOrder;
								$.post('<?php echo $url->getToolsURL('acliss_faq/faq_display_order', 'acliss_faq')?>', data);
							}
						});
						$("#ccm-acliss-faq-list-active tbody").disableSelection();
					});
				</script>
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
