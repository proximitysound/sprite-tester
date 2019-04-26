<!-- /views/sprites/index.php -->

<p>Index of Sprites</p>

<script>
$(document).ready( function () {
    $('#sprite-table').DataTable();
} );
</script>

<?php 
	if(isset($error))
	{
	echo "<h3>".$error."</h3>";
	}
?>

<table cellpadding=0 cellspacing=10 id="sprite-table">
	<thead>
		<tr>
			<th>Sprite Name</th>
			<th>Author</th>
			<th>Status</th>
			<th>VT</th>
			<th>Sub #</th>
			<th>Date Created</th>
			<th>Date Modified</th>
			<th># of Tests</th>
			<?php 
				if($this->ion_auth->in_group($this->config->item('testerGroup')))
				{
				echo "<th>Actions</th>";
				}
				if($this->ion_auth->in_group($this->config->item('uploadGroup')))
				{
				echo "<th>Download</th>";
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($sprites as $sprite):?>
			<tr>
				<?php 
					if($this->ion_auth->in_group($this->config->item('managerGroup')))
						{
						echo "<td>";
						echo anchor('/sprites/view/'.$sprite['id'], $sprite['name']);
						echo "</td>";
						}
						else
						{
						echo "<td>";	
						echo $sprite['name'];
						echo "</td>";
						}
					?>
				<td><?php echo $sprite['username'];?></td>
				<td><?php echo $sprite['status_name']; ?></td>
				<td><?php echo $sprite['vt_version']; ?></td>
				<td><?php echo $sprite['submission_version']; ?></td>
				<td><?php echo $sprite['date_created']; ?></td>
				<td><?php echo $sprite['date_modified']; ?></td>
				<td><?php echo $sprite['test_count']; ?></td>
				<?php 
					if($this->ion_auth->in_group($this->config->item('testerGroup')))
					{
					echo "<td>";
					echo anchor('sprites/edit/'.$sprite['id'], 'Edit');
					echo " | " ;
					echo anchor('sprites/evaluate/'.$sprite['id'], 'Test');
					echo "</td>";
					}
					if($this->ion_auth->in_group($this->config->item('uploadGroup')))
					{
					echo "<td>"; 
					echo anchor('sprites/download/'.$sprite['id'], 'Download'); 
					echo "</td>";
					}
				?>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>