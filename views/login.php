<!DOCTYPE html>
<html>
<head>
	<title>Mango...The Mongo Manager</title>
	<script type="text/javascript">
		script_name = "<?php echo $_SERVER['PHP_SELF']; ?>";
	</script>
	<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="screen, print" />
	<link rel="stylesheet" href="assets/css/smoothness.css" type="text/css" media="screen, print" />
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="assets/js/functions.js"></script>
</head>

<body>

<div id="header">
	<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Mango</a></h1><div class="clear-both"></div>
</div>
<div id="content">
<?php if(isset($message)): ?>
<div class="ui-state-error ui-corner-all" style="margin: 20px 0; padding: 10px;"> 
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
	<?php echo $message; ?></p>
</div>
<?php endif; ?>
	<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" /><br />
		<label for="password">Password:</label>
		<input type="password" name="password" /><br />
		<input type="submit" value="Login" />
	</form>

</div>

</body>
</html>