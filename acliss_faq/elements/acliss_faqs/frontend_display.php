<?php
defined('C5_EXECUTE') or die("Access Denied.");
$question = $aclissFaq->getQuestion();
$answer = $aclissFaq->getAnswer();
?>
<h1><?php echo $question;?></h1>
<div class="content">
	<?php echo $answer;?>
</div>