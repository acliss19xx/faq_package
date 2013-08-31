<?php defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="question-answer">
	<?php $th = Loader::helper('text');?>
	<div id="question-title<?php echo $bID ?>" class="question-title">
		<?php foreach ($faqs as $faq) { ?>
			<div class="title">
				<a href="#question<?php echo $bID . $faq->afID; ?>">Q.<?php echo $th->sanitize($faq->getQuestion()) ?></a>
			</div>
		<?php } ?>
	</div>

	<?php foreach ($faqs as $faq) { ?>
		<div id="question<?php echo $bID . $faq->afID; ?>" class="question">
			Q.<?php echo $th->sanitize($faq->getQuestion()) ?>
		</div>
		<div  id="answer<?php echo $bID . $faq->afID; ?>" class ="answer">
			A.<?php echo $faq->getAnswer() ?>
			<div class="answer-return"><a href="#question-title<?php echo $bID ?>">一覧に戻る</a></div>
		</div>
	<?php } ?>
</div>
