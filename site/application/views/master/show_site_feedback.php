<!-- Show Site Feedback -->

<script>
$(document).ready( function () {
    $('#feedback').DataTable();
} );
</script>

<table id="feedback">
	<thead>
		<tr>
			<th>Username</th>
			<th>Note</th>
			<th>Date Created</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($notes as $note):?>
			<tr>
				<td><?php echo $note['username'];?></td>
				<td><?php echo $note['content']; ?></td>
				<td><?php echo $note['date_created']; ?></td>
			</tr>
		<?php endforeach;?>
	
	</tbody>
</table>
