<?php defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="question-answer">

	<?php foreach ($faqs as $faq) { ?>
		<div class="question-title">
			<a href="#question<?php echo $faq->afID ?>">Q.<?php echo $faq->getQuestion() ?></a>
		</div>
	<?php } ?>

	<div class="saigo">
		<?php foreach ($faqs as $faq) { ?>
			<div id="question<?php echo $faq->afID ?>" class="question">
				Q.<?php echo $faq->getQuestion() ?>
			</div>
			<div  id="answer<?php echo $faq->afID ?>" class ="answer">
				A.<?php echo $faq->getAnswer() ?>
			</div>
		<?php } ?>
	</div>
</div>
