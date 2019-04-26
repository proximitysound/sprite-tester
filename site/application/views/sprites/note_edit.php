<!-- Note Edit -->

<?php echo validation_errors(); ?>
<h2><?php echo $title; ?></h2>

<h3>Editing note for <?php echo '"'.$note['sprite_name'].'"'; ?></h3>
<p>Created by: <?php echo $note['username']; ?></p>
<p>Date created: <?php echo $note['date_created']; ?></p>

<?php echo form_open('sprites/note_edit/'.$note['id']);?>

	<?php echo form_hidden('sprite_id', $note['sprite_id']); ?>
	<p>Animation:</p>
	<p><?php echo $this->config->item($note['progress'],'progress'); ?>

	<p>Feedback Type:</p>
	<?php echo form_dropdown('status', $this->config->item('feedback_type'), $note['feedback_type']); ?>
	<br><br>
	<?php echo form_textarea('content', $note['content']);?>
	<br>
	 
<input type="submit" name="submit" value="Update Note" />

</form>