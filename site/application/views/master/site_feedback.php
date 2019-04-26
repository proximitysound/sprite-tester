<!-- Site Feedback -->

<?php echo validation_errors(); ?>
	
	<h2>Site Feedback</h2>
	
	<?php echo form_open('sprites/site_feedback'); ?>  
	
	<p>Feedback:</p>
	<?php echo form_textarea('feedback');?>
	<br>
	<input type="submit" value="Submit Feedback" />
	
	</form>
	
	</div>
