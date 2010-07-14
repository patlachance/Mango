<?php
$i = 0;
foreach($db_list as $db)
{
	$db_list[$db['name']]['collection_count'] = count($mongo->switch_db($db['name'])->list_collections());
}
?>
<h2>Databases - <a href="#" id="create-db">Create Database</a></h2>
<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Collection Count</th>
			<th>Size on Disk</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php
$even = FALSE; 
foreach($db_list as $db):
?>
		<tr<?php echo $even ? ' class="alt"' : ''; ?>>
			<td><?php echo a($db['name'], url($db['name'], NULL, 'coll_list')); ?></td>
			<td><?php echo $db['collection_count']; ?></td>
			<td><?php echo (!$db['empty'] ? round($db['sizeOnDisk'] / 1048576) . 'MB' : 'Empty'); ?></td>
			<td>
				<?php echo a('Repair', url($db['name'], NULL, 'repair_db')); ?>
				<?php echo ($db['name'] != 'admin') ? ' | ' . a('Drop', url($db['name'], NULL, 'drop_db'), 'class="dropper"') : '&nbsp;'; ?>
			</td>
		</tr>
<?php
$even = !$even;
endforeach;
?>
	</tbody>
</table>
<div id="db-create-dialog" title="Create New Database">
	<div class="validate-tips"></div>
	<form>
		<label for="db">Database: </label>
		<input type="text" name="new_db" id="new_db" class="text ui-widget-content ui-corner-all" />
	</form>
</div>
