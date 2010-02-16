<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <head>
    <title>My Brain</title>
    <link href="css/main.css" media="all" rel="stylesheet" type="text/css">
  </head>
  <body OnLoad="document.forms[0].username.focus();">
	<div id='login'>
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