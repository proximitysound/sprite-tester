<!-- Note Delete -->

<h3>Are you sure you want to delete this note for <?php echo '"'.$note['sprite_name'].'"'; ?></h3>
<p>Created by: <?php echo $note['username']; ?></p>
<p>Date created: <?php echo $note['date_created']; ?></p>

<?php echo form_open_multipart('sprites/note_delete_confirmed/'.$note['id']);?>

<?php echo form_hidden('sprite_id', $note['sprite_id']); ?>

	<p>Feedback Type:</p>
	<?php echo $this->config->item($note['feedback_type'],'feedback_type'); ?>
	<br><br>
	<?php echo nl2br($note['content']);?>
	<br>
	
<input type="submit" name="submit" value="Delete Note" />

</form>

<h3><?php echo anchor('sprites/view/'.$note['sprite_id'],'Cancel');?></h3>


</form>