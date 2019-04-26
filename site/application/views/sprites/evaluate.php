<!-- views/sprites/evaluate -->
<h2><?php echo $message ?></h2>

<?php

	// Show Current Animation according to Progress
	
	if($evaluation['progress'] <= 97)
		{
			echo "<h3>Animation: "; echo $this->config->item($evaluation['progress'], 'progress'); echo "</h3>";
		}
	elseif ($evaluation['progress'] >= 98 && $evaluation['progress'] <= 103)
		{
			echo "<h3>Animation: "; echo $this->config->item($evaluation['progress'], 'progress'); echo "</h3>";
			echo "<p><em>Make sure Bunny Palette is selected.</em></p>";
		}
	elseif ($evaluation['progress'] == 104)
		{
			echo "<h2>Testing Complete</h2>";
		}

?>

<div style=<?php if($evaluation['progress'] != 104){ echo '"display:block;">'; }else{ echo '"display:none;">';}?>

<img src=<?php echo '"'.base_url().'gifs/'.$evaluation['progress'].'.gif"' ?> />
<h3>Progress: <?php echo $evaluation['progress'];?> /103 </h3>
<p><em>Note: Ensure all Palettes including Mitts/Gloves are checked before progressing.</em></p>

<!-- Controls -->
<?php

	$techIssue = 'onclick="showTechForm();" class="btn btn-cal1 btn-lg"';
	$feedback = 'onclick="showFeedback();" class="btn btn-cal3 btn-lg"';
	$passed = 'class="btn btn-success btn-lg"';
	
	echo form_button('technical_issue', 'Technical Issue', $techIssue);
	echo form_button('feedback', 'Creative Feedback', $feedback);
	echo anchor('sprites/evaluation_pass/'.$evaluation['id'], 'Passed', $passed);
?>

</div>

<!--Tech Issue Form -->
	
	<div id="tech-issue" class="well" style=<?php if($form_open == "Tech"){ echo '"display:block;">'; }else{ echo '"display:none;">';}?>
	
	<h2>Technical Issue</h2>
	
	<?php echo validation_errors(); ?>
		
	<?php echo form_open('sprites/tech_issue/'.$evaluation['id']); ?>
	
	<?php echo form_hidden('progress', $evaluation['progress']); ?> 
	
	<label for="palette">Palette: (optional)</label>
	<div>
	<input type="checkbox" name="palette[]" value="Green Mail" > Green Mail
	<input type="checkbox" name="palette[]" value="Blue Mail" > Blue Mail
	<input type="checkbox" name="palette[]" value="Red Mail" > Red Mail<br>
	<input type="checkbox" name="palette[]" value="Power Glove" > Power Glove
	<input type="checkbox" name="palette[]" value="Titans Mitt" > Titan's Mitt
	<input type="checkbox" name="palette[]" value="Bunny" > Bunny </br>
	</div>
	<br>
	<label for="indexes">Indexes: (optional)</label>
	<input type="text" name="indexes" />
	<br>
	<label for="frames">Frames: (optional)</label>
	<input type="text" name="frames" />
	
	<p>Feedback:</p>
	<?php echo form_textarea('tech_feedback');?>
	<br>
	<input type="submit" value="Submit Feedback" />
	
	</form>
	
	</div>

<!--Creative Feedback Form -->
	
	<div id="feedback" class="well" style=<?php if($form_open == "Creative"){ echo '"display:block;">'; }else{ echo '"display:none;">';}?>
	
	<?php echo validation_errors(); ?>
	
	<h2>Creative Feedback</h2>
	
	<?php echo form_open('sprites/feedback/'.$evaluation['id']); ?>
	
	<?php echo form_hidden('progress', $evaluation['progress']); ?>  
	
	<label for="palette">Palette: (optional)</label>
	<div>
	<input type="checkbox" name="palette[]" value="Green Mail" > Green Mail
	<input type="checkbox" name="palette[]" value="Blue Mail" > Blue Mail
	<input type="checkbox" name="palette[]" value="Red Mail" > Red Mail<br>
	<input type="checkbox" name="palette[]" value="Power Glove" > Power Glove
	<input type="checkbox" name="palette[]" value="Titans Mitt" > Titan's Mitt
	<input type="checkbox" name="palette[]" value="Bunny" > Bunny </br>
	</div>
	<br>
	<label for="indexes">Indexes: (optional)</label>
	<input type="text" name="indexes" />
	<br>
	<label for="frames">Frames: (optional)</label>
	<input type="text" name="frames" />
	
	<p>Feedback:</p>
	<?php echo form_textarea('creative_feedback');?>
	<br>
	<input type="submit" value="Submit Feedback" />
	
	</form>
	
	</div>

	
	</div>