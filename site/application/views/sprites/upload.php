<!-- views/sprites/create.php Creates a Sprite Submission -->

<?php echo validation_errors(); ?>

<?php echo $error;?>

<?php echo form_open_multipart('sprites/do_upload');?>

<label for="userfile">File</label>

<input type="file" name="userfile" />

<?php echo form_hidden('user_id', $userid);?>

<br>

    <label for="name">Sprite Name:</label>
    <input type="input" name="name" /><br />

<!-- Create array of statuses for dropdown -->		

	<?php $options = array(); 
		foreach ($statuses as $status):
			$options[$status['id']] = $status['status_name'] ;
		endforeach ?>
	
<!-- Create dropdown for status -->	
	<br>
	<p>Status</p>
	<?php echo form_dropdown('status', $options, ''); ?>
	<br><br>
 
<input type="submit" name="submit" value="Submit new Sprite" />

</form>

