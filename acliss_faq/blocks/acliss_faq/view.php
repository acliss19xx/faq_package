<?php defined('C5_EXECUTE') or die("Access Denied.");
?>
<?php $th = Loader::helper('text'); ?>
<div class="question-answer">
	<?php foreach ($faqs as $faq) { ?>
		<div class="question">
			Q.<?php echo $th->sanitize($faq->getQuestion()) ?>
		</div>
		<div  class="answer">
			A.<?php echo $faq->getAnswer() ?>
		</div>
	<?php } ?>
</div>

