<!-- views/sprites/edit.php Creates a Sprite Submission -->


<?php echo validation_errors(); ?>
<?php echo $title; ?>

<?php echo form_open('sprites/edit/'.$sprite['id']);?>

<br>

    <label for="name">Sprite Name:</label>
    <input type="input" name="name" value="<?php echo $sprite['name']; ?>"/><br />


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
	 
<input type="submit" name="submit" value="Update Sprite Data" />

</form>