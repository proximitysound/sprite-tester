</div>
<div class="container" id="footer">

<?php 
		
		echo "<p>Current Version: ";
		echo  anchor('home/version', $this->config->item('version'));
		echo "</p>";
		
		if($this->ion_auth->logged_in())
			{
			$user = $this->ion_auth->user()->row();
			echo "Logged in as: "; echo $user->username;
			echo " > ";
			echo anchor('auth/logout','Logout');
			
			echo "<p>";
			echo anchor('sprites/site_feedback','Submit Site Feedback');
			echo "</p>";
			
			}
?>
</div>
<br>


<?php 
		if($this->ion_auth->is_admin())
			{
			$showArray = 'onclick="showArray();" class="btn"';
			
			echo '<div class="container">';
			echo form_button('show_array', 'Show Arrays (Admin Only)', $showArray);
			
			echo '<div id="admin-array" style="display:none;">';
			$this->sprite_class->my_print_r($adminArray);
			
			}
?>
</div>
</div>
</body>
</html>