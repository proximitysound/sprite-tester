<!-- /views/sprites/usersprites.php -->

<?php echo $title; ?>

<script>
$(document).ready( function () {
    $('#sprite-table').DataTable();
} );
</script>

<table cellpadding=0 cellspacing=10 id="sprite-table">
	<thead>
		<tr>
			<th>Sprite Name</th>
			<th>Status</th>
			<th>VT</th>
			<th>Version</th>
			<th>Date Created</th>
			<th>Date Modified</th>
			<th>Actions</th>
			<th>Download</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($sprites as $sprite):?>
			<tr>
				<td><?php echo anchor('/sprites/view/'.$sprite['id'], $sprite['name']);?></td>
				<td><?php echo $sprite['status_name']; ?></td>
				<td><?php echo $sprite['vt_version']; ?></td>
				<td><?php echo $sprite['submission_version']; ?></td>
				<td><?php echo $sprite['date_created']; ?></td>
				<td><?php echo $sprite['date_modified']; ?></td>
				<td><?php echo anchor('sprites/edit/'.$sprite['id'], 'Edit Info'); 
							echo " | ";
						  echo anchor('sprites/update/'.$sprite['id'], 'Update'); 
				?></td>
				<td><?php echo anchor('sprites/download/'.$sprite['id'], 'Download'); ?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>