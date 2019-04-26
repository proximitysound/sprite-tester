<!-- views/sprites/updaet.php - Updates an existing sprite -->

<?php echo validation_errors(); ?>

<?php echo $error;?>

<?php echo form_open_multipart('sprites/do_update/'.$sprite['id']);?>

<label for="userfile">File</label>

<input type="file" name="userfile" />

<?php echo form_hidden('submission_version', $sprite['submission_version']);?>

<br>

<!-- Create array of statuses for dropdown -->		

	<?php $options = array(); 
		foreach ($statuses as $status):
			$options[$status['id']] = $status['status_name'] ;
		endforeach ?>
	
<!-- Create dropdown for status -->	
	<br>
	<p>Status</p>
	<?php echo form_dropdown('status', $options, $sprite['status']); ?>
	<br><br>
 
<input type="submit" name="submit" value="Update Sprite" />

</form>

<?php $this->sprite_class->my_print_r($sprite);

