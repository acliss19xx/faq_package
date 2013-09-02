<?php defined('C5_EXECUTE') or die("Access Denied.");
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2><?php echo t('sort By')?></h2>
	<?php 
	$options = array(
		'displayOrder' => t('displayOrder'),
		'addDate' => t('addDate'),
		'modifiedDate' => t('modifiedDate'),
	);
	echo $form->select('sortBy', $options, $sortBy);
	?>
</div>