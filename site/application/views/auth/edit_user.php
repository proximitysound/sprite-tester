<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<p>Editing info for user: <?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

	<p>
		<?php echo lang('edit_user_fname_label', 'first_name');?> <br />
		<?php echo form_input($first_name);?>
	</p>

	<p>
		<?php echo lang('edit_user_lname_label', 'last_name');?> <br />
		<?php echo form_input($last_name);?>
	
	</p>


	<p>
		<?php echo lang('edit_user_email_label', 'email');?> <br />
		<?php echo form_input($email);?>
	
	</p>
	
	<p>
		<?php echo lang('edit_user_password_label', 'password');?> <br />
		<?php echo form_input($password);?>
	</p>

	<p>
		<?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
		<?php echo form_input($password_confirm);?>
	</p>

	  
<!-- Check if user is admin -->

<?php if ($this->ion_auth->is_admin()): ?>	
		
<!-- Create array of groups for dropdown -->		

		<?php $options = array(); 
			foreach ($groups as $group):
				$options[$group['id']] = $group['name'] ;
			endforeach ?>
	
<!-- Get current user's membership level -->
	
	<?php $groupMember = $currentGroups['0']->id; ?>
	
<!-- Create dropdown for membership -->	
	
	<p>Membership Level</p>
	
	<?php echo form_dropdown('groups[]', $options, $groupMember); ?>
	
<?php endif ?>

<!-- Hidden User Info required for database -->

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden('identity', $user->username);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>


