
<?php

	if(!$this->ion_auth->logged_in())
		{

			echo "<h3>"; echo anchor('auth/login','Login Here'); echo "</h3>";
		
		}else{
		//Sprite Functions
		
		echo "<h2>Sprite Functions</h2>";
		
		echo "<table>
					<thead>
					<tr>
					<th></th><th></th><th></th>
					</tr>
					</thead>
			<tbody><tr>";
		
			echo "<td><h3>"; echo anchor('sprites/index','Show All Sprites'); echo "</h3></td>";
			echo "<td><h3>"; echo anchor('sprites/usersprites','Show My Sprites'); echo "</h3></td>";
		
		}
		
	if($this->ion_auth->in_group($this->config->item('uploadGroup'))) // Only the "uploadGroup" can upload sprites
		{
		echo "<td><h3>"; echo anchor('sprites/upload','Upload New Sprite'); echo "</h3></td>";
		}
		
	echo "</tbody></table>";
		
	if($this->ion_auth->is_admin())
		{
			echo "<h2>Site Functions</h2>";
			
			echo "<table>
					<thead>
					<tr>
					<th></th><th></th>
					</tr>
					</thead>
				<tbody><tr>";
			
			echo "<td><h3>"; echo anchor('auth/index','Edit Users'); echo "</h3></td>";
			echo "<td><h3>"; echo anchor('sprites/show_site_feedback','Show Site Feedback'); echo "</h3></td>";
			
			echo "</tbody></table>";
			
		}
	

?>