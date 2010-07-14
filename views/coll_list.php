<?php
$collection_list = $mongo->list_collections();
$title = 'Collections (' . count($collection_list) . ')';
echo breadcrumbs(array(
	a('Mango', url()), 
	'<b>db:</b> ' . a($current_db, url($current_db, NULL, 'coll_list')), 
	$title
));
?>
<h2><?php echo $title; ?> - <a href="#" id="create-coll">Create Collection</a></h2>
<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Document Count</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php
$even = FALSE; 
foreach($collection_list as $name => $count):
?>
		<tr<?php echo $even ? ' class="alt"' : ''; ?>>
			<td><?php echo a($name, url($current_db, $name, 'obj_list')); ?></td>
			<td><?php echo $count ?></td>
			<td><?php echo a('Drop', url($current_db, $name, 'drop_coll'), 'class="dropper"'); ?></td>
		</tr>
<?php
$even = !$even;
endforeach;
?>
	</tbody>
</table>
<div id="coll-create-dialog" title="Create New Collection">
	<div class="validate-tips"></div>
	<form>
		<label for="db">Collection: </label>
		<input type="text" name="new_coll" id="new_coll" class="text ui-widget-content ui-corner-all" />
	</form>
</div>
