<?php

// Change this to your own username and password.  You CAN have multiple users.
$auth = array('demo' => 'password');

define('MONGO_HOST', 'localhost');
define('MONGO_PORT', 27017);
define('MONGO_USERNAME', '');
define('MONGO_PASSWORD', '');
define('OBJECT_LIMIT', 100);



// Lets get this party started...
session_start();

if(isset($auth) && !isset($_SESSION['username']))
{
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		if(isset($auth[$_POST['username']]) && $auth[$_POST['username']] = $_POST['password'])
		{
			$_SESSION['username'] = $_POST['username'];
		}
		else
		{
			$message = "Username or Password is invalid.";
		}
	}
	if(!isset($_SESSION['username']))
	{
		include 'views/login.php';
		exit(0);
	}
}

include 'lib/helper_functions.php';
include 'lib/mongo_db.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'db_list';

$current_db = isset($_GET['db']) ? $_GET['db'] : '-none-';
$current_coll = isset($_GET['c']) ? $_GET['c'] : NULL;

$mongo = new Mongo_DB($current_db);

if($action == 'drop_db')
{
	$mongo->drop_database($current_db);
	$success = 'Database "' . $current_db . '" has been dropped.';
	$action = 'db_list';
}
elseif($action == 'drop_coll')
{
	$mongo->drop_collection($current_coll);
	$success = 'Collection "' . $current_coll . '" has been dropped.';
	$action = 'coll_list';
}
elseif($action == 'create_db')
{
	$success = 'Database "' . $current_db . '" has been created.';
	$action = 'coll_list';
}
elseif($action == 'create_coll')
{
	$mongo->create_collection($collection);
	$success = 'Collection "' . $current_coll . '" has been created.';
	$action = 'obj_list';
}
elseif($action == 'repair_db')
{
	$mongo->repair();
	$success = 'Database "' . $current_db . '" has been repaired.';
	$action = 'db_list';
}

$db_list = $mongo->list_databases();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Mango...The Mongo Manager</title>
	<script type="text/javascript">
		script_name = "<?php echo $_SERVER['PHP_SELF']; ?>";
		current_db = "<?php echo $current_db; ?>";
	</script>
	<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="screen, print" />
	<link rel="stylesheet" href="assets/css/smoothness.css" type="text/css" media="screen, print" />
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="assets/js/functions.js"></script>
</head>

<body>

<div id="header">
	<div id="databases">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="change_db">
			<input type="hidden" name="action" value="coll_list" />
			<strong>Server:</strong>&nbsp;<?php echo MONGO_HOST; ?><br />
			<strong>Database:</strong>
			<select name="db" id="db" onchange="javascript:document.change_db.submit();">
<?php foreach($db_list as $db): ?>
				<option value="<?php echo $db['name']; ?>"<?php echo ($db['name'] == $current_db) ? ' selected="selected"' : ''; ?>>
					<?php echo $db['name'] . ' (' . (!$db['empty'] ? round($db['sizeOnDisk'] / 1048576) . 'MB' : 'empty') . ')'; ?>

				</option>
<?php endforeach;?>
			</select>
		</form>
	</div>
	<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Mango</a>
<?php if($current_db != '-none-'): ?>
	- <span id="current_db"><?php echo a($current_db, url($current_db)); ?></span>
<?php endif; ?>
	</h1><div class="clear-both"></div>
</div>
<div id="content">
<?php if(isset($success)): ?>
<div class="ui-state-highlight ui-corner-all" style="margin: 20px 0; padding: 10px;"> 
	<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
	<?php echo $success; ?></p>
</div>
<?php
endif;

if($action == 'db_list')
{
	include 'views/db_list.php';
}
elseif($action == 'coll_list')
{
	include 'views/coll_list.php';
}
elseif($action == 'obj_list')
{
	include 'views/obj_list.php';
}
?>
</div>

<div id="dialog-confirm" title="Are you sure?">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This action cannot be undone.  Are you sure you wish to proceed?</p>
</div>
</body>
</html>