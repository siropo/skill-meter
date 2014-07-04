<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Skills meter system</title>
		<meta charset="utf-8" />
		<meta name="author" content="Viktor Ivanov" />
		<meta name="description" content="Skills meter system"/>
		<meta name="keywords" content="Skill,meter,system"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate.css" />
		<link rel="stylesheet" type="text/css" href="css/diagram.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js"></script>
		<script src="js/script.js"></script>
		<!--[if lte IE 8]> 
			<link rel="stylesheet" type="text/css" href="css/ie_style.css" />
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]--> 
	</head>
	<?
		include "common.php";
	?>
	<body>
	<div class="skill_system">Skill meter system/ last update <? last_update(); ?></div>
		<div id="wrapper">
			<header id="header" class="clear">
				<hgroup class="header_info">
					<h1><a href="index.php" title="Your name" alt="Your name">Welcome to skill meter demo site</a></h1>
					<p>Add your short welcome text here</p>	
				</hgroup>
				<div class="total_skills">
					<? count_records(); ?>
					<div> total skills records: <span class="orange"><? echo $count_skill; ?></span></div>
					<div> total category records: <span class="orange"><? echo $count_category; ?></span></div>
				</div>
				
			</header>
			<div class="intro_text">
					<h3>What is Skill meter?</h3>
					<p>Skill meter is a simple system written with HTML5, CSS3, PHP and Mysql to measure your skills in different areas that you have acquired in a professional or personal level. By admin panel, you can quickly and easily put your skills and categorize them.</p>
					<h3>How to use it?</h3>
					<ol>
						<li>Save your categories such as programming, languages, design, sports or whatever  you want.</li>
						<li>Then set up your skills. You have to choose the right category. You decide how much percent  you will rate on your skill and complete the required fields for the name of the skill</li>
						<li>Add an icon for it, if it's not in the list you can add your own icon by selecting from the image upload field. What you are uploading do not need to be calibrated accurately, you need at least roughly in the same ratio of height, as 240x240px.</li>
						<li>You can add unlimited number of icons. Put them in the root directory of the script in a folder img / icons.</li>
						<li>After you have entered your skills and categories you can easily arrange them with drag and drop. You need to select the directory where they are located, so you can move them around.</li>
					</ol>
					<h3>How to install?</h3>
					<ol>
						<li>Create database on your Mysql  server and name it skill_meter.</li>
						<li>Import SQL file located in the directory sql to create table stricture in database skill_meter.</li>
						<li>Open global.php file located in the directory admin. Set  your $mysql_username and $mysql_password  to connect  to MySQL  database and change your custom $admin_username and $admin_username to access to admin panel.</li>
						<li>Use it :)!</li>
					 <h3>Skill meter is free to use and change the code. </h3>
			</div>
			<div id="display_records" class="clear">
			<div class="short_info">
				<div class="my_pic">
					<img src="img/site/me.png" width="260" height="240" title="Viktor Ivanov" alt="Viktor Ivanov" />
				</div>	
				<nav id="menu">
					<ul class="clear">
						<li><a href="admin/login.php" class="link_button">View admin panel</a></li>
						<li><a href="#" class="link_button">View my portfolio</a></li>
						<li><a href="#" class="link_button">View my blog</a></li>
						<li><a href="skill_meter_0.1_beta.zip" class="link_button">Download skill meter 0.1 beta version</a></li>
					</ul>
				</nav>
				
			</div>
			
				<div class="wrap_records">
				
					<? display_skills_front(); ?>
				</div>
			</div>
		</div>
	<footer id="bottom">
				created by <a href="http://siropo.avaart.net/" title="author Viktor Ivanov" alt="author Viktor Ivanov" target="_blank" class="author">Victor Ivanov</a>/ skill meter system beta 0.1
	</footer>
	</body>
</html>