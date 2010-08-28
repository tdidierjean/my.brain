<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>My Brain</title>
    <link href="css/main.css" media="all" rel="stylesheet" type="text/css">
	<link href="css/custom-theme/jquery-ui-1.7.2.custom.css" media="all" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<div id='login' class="loginBloc">
		<?php
		if (isset($_GET["no_session"]) && $_GET["no_session"] == 1){
		?>
			<div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all"> 
				<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> 
					<strong>Alert:</strong> Login denied.
				</p>
			</div>
			<br />
		<?php
		}
		?>
		<form method="post" action="auth.php">
			<label for="username">Username: </label><br />
			<input type="text" name="username" id="username"><br />
			<label for="password">Password: </label><br />
			<input type="password" name="password" id="password"><br />
			<input type="submit" name="submit" id="submit" value="Submit">
		</form>
	</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){$("#username").focus()});
</script>
	