<?php defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="question-answer">
	<?php foreach ($faqs as $faq) { ?>
		<div class="question">
			Q.<?php echo $faq->getQuestion() ?>
		</div>
		<div  class="answer">
			A.<?php echo $faq->getAnswer() ?>
		</div>
	<?php } ?>
</div>

