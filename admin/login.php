<?php
session_unset();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Skills admin panel</title>
		<meta charset="utf-8" />
		<meta name="author" content="Viktor Ivanov" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<!--[if lte IE 8]> 
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]--> 
	</head>
	<body id="home">
	<header id="header"><span class="top_message">Wellcome to admin panel for your skill meter</span>
	<br />
	<p>username: admin</p>
	<p>password: admin</p>
	</header>
	<div id="login_form">
	<form action="index.php" method="post">
		<div id="login">
		  <h1>Please login</h1>
		  <p><label for="name">Username:</label>
			<input type="text" value="" name="name" placeholder="yout name" required="true"/>
		  </p><p><label  for="password">Password:</label>
			<input type="password" value="" name="password" placeholder="password" required="true"/>
		  </p><p>
			<input value=" login "  type="submit" />
		  </p>
		</div>
	</form>
	</div>
	<footer id="bottom">
				created by Victor Ivanov/ skill meter system beta 0.1
	</footer>
	</body>
</html>