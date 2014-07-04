<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Skills admin panel</title>
		<meta charset="utf-8" />
		<meta name="author" content="Viktor Ivanov" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate.css" />
		<link rel="stylesheet" type="text/css" href="css/diagram.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="js/script.js"></script>
		<!--[if lte IE 8]> 
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]--> 
	</head>
	<body id="home">
	<header id="header">
		<div class="clear">
			<?
				include "common.php";
				check_login($admin_username, $admin_password);
			?>
			<div class="message"><span class="top_message">Plese odrer category with drag and drop, click to edit!</span></div>
			<nav id="menu">
				<ul class="clear">
					<li><a href="index.php?page=home" class="link_button">home</a></li>
					<li><a href="category_order.php?page=category" class="link_button">new category</a></li>
					<li><a href="index.php?logout=1" class="link_button">logout</a></li>
				</ul>
			</nav>
		</div>
		<div id="response_order"></div>
	</header>
	<div id="wrapper" class="clear">
		<div id="display_records">
			<h1>Display your category records</h1>
			<p>Click to edit category, order the catgory with drag and drop</p>
			<form method="post">
				<div id="sortable">
				<?
					if (!(isset($error_msg))) {
						echo display_category_order();
					}	else {
						echo error_msg($msg);
					}
				?>	
				</div>
			</form>
			<div class="total">
				total category: <? echo $count_cat; ?>
			</div>
		</div>
		<div id="mainform" class="myform flash clear">
			<form method="post" id="form" name="form" enctype="multipart/form-data">
				<h1><? echo $msg_form; ?></h1>
				<p>Fill form fields to record a new category</p>
				<label for="cat_name" <? echo $style_text_edit; ?>>Category name
					<span class="small">Add your name</span>
				</label><input type="text" name="category_name" id="cat_name" value="<? echo $edit_cat; ?>" placeholder="Enter your category name" required="true" />
				<input type="hidden" value="update_category" id="order_mod" />
				<input type="hidden" value="category_query" name="mod" />
				<input type="hidden" value="<? echo $_GET['id']; ?>" name="submit_edit" />
				<input type="submit" name="submit" value="<? echo $button_name; ?>" class="submit" /> 
			</form>
		</div>
	</div>

	<footer id="bottom">
				created by Victor Ivanov/ skill meter system beta 0.1
	</footer>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js"></script>
	<script>
		$(document).ready(function(){ 	
			  function slideout(){
		  setTimeout(function(){
		  $("#response_order").slideUp(150, function () {
			  });
			
		}, 2000);}
			
			$("#response_order").hide();
			$(function() {
			$("#sortable").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var mod = document.getElementById("order_mod").value;
					var order = $(this).sortable("serialize") + '&action=' + mod; 
					$.post("common.php", order, function(theResponse){
						$("#response_order").html(theResponse);
						$("#response_order").slideDown(150);
						slideout();
					}); 															 
				}								  
				});
			});

		});
	</script>
	</body>
</html>