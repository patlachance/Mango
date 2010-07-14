<?php
// Set a bunch of variables to be used later.
$collection = $_GET['c'];
$page_num = isset($_GET['p']) ? $_GET['p'] : 1;
$offset = (($page_num - 1) * OBJECT_LIMIT);
$total = $mongo->count($collection);
$pages = ceil($total / OBJECT_LIMIT);
$sort = isset($_GET['sort']) ? $_GET['sort'] : array('_id' => 'ASC');
$sort_by = key($sort);
$sort_dir = strtoupper($sort[$sort_by]);
$doc_list = $mongo->limit(OBJECT_LIMIT, $offset);

foreach($sort as $key => $val)
{
	$doc_list = $doc_list->order_by($key, $val);
}

$doc_list = $doc_list->get($collection);
$title = $collection . ' (' . $total . ')';
$keys = array();
foreach($doc_list as $doc)
{
	$keys = array_merge($keys, get_keys($doc));
}
ksort($keys);
echo breadcrumbs(array(
	a('Mango', url()), 
	'<b>db:</b> ' . a($current_db, url($current_db, NULL, 'coll_list')), 
	'<b>collection:</b> ' .a($collection, url($current_db, $collection, 'obj_list')),
	$total . ' objects' 
));
?>
	<h2><?php echo $title; ?></h2>

<div class="toolbar">
	<div class="sorter">
		<form action="modbadmin.php" method="get">
			<input type="hidden" name="db" value="<?php echo $current_db; ?>" />
			<input type="hidden" name="c" value="<?php echo $collection; ?>" />
			<input type="hidden" name="o" value="<?php echo $offset; ?>" />
			<strong>Sort:</strong>
			<select name="sort" id="sort">
<?php foreach($keys as $key => $val): ?>
				<option value="<?php echo $val; ?>"<?php echo ($key == $sort_by) ? ' selected="selected"' : ''; ?>>
					<?php echo $val; ?>

				</option>
<?php endforeach;?>
			</select>
			<select name="sort_dir" id="sort_dir">
				<option value="asc"<?php echo ($sort_dir == 'ASC') ? ' selected="selected"' : ''; ?>>ASC</option>
				<option value="desc"<?php echo ($sort_dir == 'DESC') ? ' selected="selected"' : ''; ?>>DESC</option>
			</select>
			<input type="button" onclick="javascript: document.location='<?php echo url($current_db, $collection, 'obj_list', $offset); ?>&amp;sort[' + document.getElementById('sort').value + ']=' + document.getElementById('sort_dir').value; void(0);" value="Sort" />
		</form>
	</div>
	<?php echo (OBJECT_LIMIT <= $total) ? pagination($page_num, OBJECT_LIMIT, $total, url($current_db, $collection, 'obj_list')) : '<br class="clear-both" />'; ?>
</div>
<ul id="documents">
<?php
foreach($doc_list as $doc):
	$data = print_r($doc, TRUE);
	$data = substr($data, 8, -2);
	$data = preg_replace('/^    /', '', $data);
	$data = preg_replace('/\n    /', "\n", $data);
	$data = preg_replace('/\n\s+\(/', " (\n", $data);
	$data = preg_replace('/\n\n/', "\n", $data);
?>
		<li><h4><?php echo $doc['_id']; ?>&nbsp;<a href="#">Delete</a></h4>
<pre><?php echo $data ?></pre>
		</li>
<?php
endforeach;
?>
</ul>