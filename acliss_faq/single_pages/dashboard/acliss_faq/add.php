<?php
defined('C5_EXECUTE') or die("Access Denied.");

$th = Loader::helper('text');

if (is_a($aclissfaq, "AclissFaq") && intval($_POST['create']) == 0) {
	$useAclissFaqDetails = 1;
	$isUpdate = 1;
}
if (intval($_POST['isUpdate']) > 0) {
	$isUpdate = 1;
}
if (is_a($aclissfaq, "AclissFaq") && $delete) {
	$confirmDelete = 1;
}
?>
<?php
if ($confirmDelete) {
	?>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Delete FAQ'), false, false, false); ?>
	<form method="post" enctype="multipart/form-data" id="cm-delete-acliss-faq-form" action="<?php echo $this->url('/dashboard/acliss_faq/add', 'delete', $aclissfaq->getAclissFaqID()) ?>">
		<?php echo $valt->output('delete_acliss_faq'); ?>
		<div class="ccm-pane-body">
			<h2><?php echo t("Do you really want to delete this FAQ?"); ?></h2>
			<dl>
				<dt><?php echo t("question"); ?></dt>
				<dd><?php echo $aclissfaq->getQuestion(); ?></dd>
				<dt><?php echo t("answer"); ?></dt>
				<dd><?php echo $aclissfaq->getAnswer(); ?></dd>
			</dl>
		</div>
		<div class="ccm-pane-footer">
			<div class="ccm-buttons">
				<input type="hidden" name="do_delete" value="1" />
				<input type="hidden" name="afID" value="<?php echo $aclissfaq->getAclissFaqID(); ?>" />
				<?php print $ih->button(t('Cancel'), $this->url('/dashboard/acliss_faq/search'), 'left', 'error') ?>
				<?php print $ih->submit(t('Delete Permanently'), 'ccm-user-form', 'right', 'primary'); ?>
			</div>	
		</div>
	</form>
<?php } else {
	?>
	<?php if ($isUpdate) { ?>
		<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Edit FAQ'), false, false, false); ?>
	<?php } else { ?>
		<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Add FAQ'), false, false, false); ?>
	<?php } ?>
	<form method="post" enctype="multipart/form-data" id="cm-acliss-faq-form" action="<?php echo $this->url('/dashboard/acliss_faq/add') ?>">
		<div class="ccm-pane-body">			
			<?php
			if ($useAclissFaqDetails || $isUpdate) {
				echo $valt->output('update_acliss_faq');
				?>
			<?php
			} else {
				echo $valt->output('create_acliss_faq');
				?>
	<?php } ?>

			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="ccm-grid">
				<thead>
					<tr>
						<th><?php echo t('FAQ Information') ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo t('Question') ?> <span class="required">*</span></td>
					</tr>
					<tr>
						<?php if ($useAclissFaqDetails) { ?>
							<td><input type="text" id="question" name="question" autocomplete="off" value="<?php echo $aclissfaq->getQuestion(); ?>" style="width: 95%"></td>
						<?php } else { ?>
							<td><input type="text" id="question" name="question" autocomplete="off" value="<?php echo $_POST['question'] ?>" style="width: 95%"></td>
	<?php } ?>
					</tr>
					<tr>
						<td><?php echo t('Answer') ?> <span class="required">*</span></td>
					</tr>
					<tr>
							<?php if ($useAclissFaqDetails) { ?>
							<td>
		<?php Loader::packageElement('editor_init', 'acliss_faq'); ?>
								<textarea 
									id="ccm-anwser-amenity" 
									class="advancedEditor ccm-advanced-editor" 
									name="answer" 
									style="width: 580px; height: 380px">
		<?php echo ($aclissfaq->getAnswerEditMode()); ?>
								</textarea>
							</td>
							<?php } else { ?>
							<td>
		<?php Loader::packageElement('editor_init', 'acliss_faq'); ?>
								<textarea 
									id="ccm-answer-amenity" 
									class="advancedEditor ccm-advanced-editor" 
									name="answer" 
									style="width: 580px; height: 380px">
		<?php echo ($_POST['answer']); ?>
								</textarea>
							</td>
	<?php } ?>
					</tr>

				</tbody>
			</table>

		</div>

		<div class="ccm-pane-footer">
			<div class="ccm-buttons">
	<?php if ($useAclissFaqDetails || $isUpdate) { ?>
					<input type="hidden" name="update" value="1" />
					<input type="hidden" name="isUpdate" value="1" />
					<?php if ($useAclissFaqDetails) { ?>
						<input type="hidden" name="afID" value="<?php echo $aclissfaq->getAclissFaqID(); ?>" />
					<?php } else { ?>
						<input type="hidden" name="afID" value="<?php echo $_POST['ID']; ?>" />
					<?php } ?>
					<?php print $ih->button(t('Cancel'), $this->url('/dashboard/acliss_faq/search'), 'left', 'error') ?>
					<?php print $ih->submit(t('Update'), 'ccm-user-form', 'right', 'primary'); ?>
				<?php } else { ?>
					<input type="hidden" name="create" value="1" />
					<?php print $ih->button(t('Cancel'), $this->url('/dashboard/acliss_faq/search'), 'left', 'error') ?>
					<?php print $ih->submit(t('Add'), 'ccm-user-form', 'right', 'primary'); ?>
	<?php } ?>
			</div>	
		</div>

	</form>
<?php } ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>