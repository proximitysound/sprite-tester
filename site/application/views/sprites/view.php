<!-- views/sprites/view View a Sprite -->

<script>
$(document).ready( function () {
    $('#evaluations').DataTable();
} );
</script>

<script>
$(document).ready( function () {
    $('#notes').DataTable();
} );
</script>

<h2>Details for "<?php echo $spriteinfo['name']; ?>" Sprite </h2>

<h3>Evaluations performed for this submission:</h3>

<table id="evaluations">
	<thead>
		<tr>
			<th>Username</th>
			<th>Progress</th>
			<th>Date Started</th>
			<th>Date Modified</th>
			<th>Technical Issues</th>
			
		</tr>
	
	</thead>
	<tbody>
	<?php foreach ($evaluations as $evaluation):?>
		<tr>
			<td><?php echo $evaluation['username']; ?> </td>
			<td><?php echo $evaluation['progress'].'/103'; ?></td>
			<td><?php echo $evaluation['date_created'] ; ?></td>
			<td><?php echo $evaluation['date_modified'] ; ?></td>
			<td><?php echo $evaluation['error_notes'] ; ?></td>
			
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<h3>Notes Added</h3>

<table id="notes">
	<thead>
		<tr>
			<th>Username</th>
			<th>Type</th>
			<th>Animation</th>
			<th>Date Added</th>
			<th>Note</th>
			<?php
				if($this->ion_auth->in_group($this->config->item('managerGroup')))
					{
					echo "<th>Actions</th>";
					}
			?>
		</tr>
	
	</thead>
	<tbody>
	<?php foreach ($notes as $note):?>
		<tr>
			<td><?php echo $note['username']; ?> </td>
			<td><?php echo $this->config->item($note['feedback_type'], 'feedback_type'); ?> </td>
			<td><?php echo $this->config->item($note['progress'], 'progress'); ?></td>
			<td><?php echo $note['date_created'] ; ?></td>
			<td><?php echo nl2br($note['content']) ; ?></td>
			<?php
				if($this->ion_auth->in_group($this->config->item('managerGroup')))
					{
					echo "<td>";
					echo anchor('sprites/note_edit/'.$note['id'],'Edit');
					echo " | ";
					echo anchor('sprites/note_delete/'.$note['id'],'Delete');
					echo "</td>";
					}
			?>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
