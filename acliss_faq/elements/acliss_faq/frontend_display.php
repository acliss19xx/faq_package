<?php
defined('C5_EXECUTE') or die("Access Denied.");
$question = $aclissfaq->getQuestion();
$answer = $aclissfaq->getAnswer();
?>
<h1><?php echo $question;?></h1>
<div class="answer">
	<?php echo $answer;?>
</div>