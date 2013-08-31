<?php  defined('C5_EXECUTE') or die("Access Denied.");
?>

<script type="text/javascript">
$(function(){
	$('.question-btn').click(function(){
		var num = $(this).val();
		if($('#answer' + num).is(":visible")){
			$('#answer' + num).slideUp();
			$('#question-btn' + num).text('A表示');
		}else{
			$('#answer' + num).slideDown();
			$('#question-btn' + num).text('閉じる');
		}
	});
});
</script>

<div class="question-answer">
	<?php
	$loopcount = 1;
	foreach($faqs as $faq) { 
	?>

	<div id="question<?php echo $bID . $loopcount?>" class="question">
		<button id="question-btn<?php echo $bID . $loopcount; ?>" class="question-btn" value="<?php echo $bID . $loopcount ?>" >A表示</button>			
		Q.<?php echo $faq->getQuestion() ?>
	</div>
		
	<div id="answer<?php echo $bID . $loopcount; ?>" class="answer" style="display:none">
		A.<?php echo $faq->getAnswer() ?>
	</div>
	
	<?php
		$loopcount++;
	}
	 ?>
</div>