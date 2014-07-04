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
	<body>
	<header id="header">
		<div class="clear">
			<?
				include "common.php";
				check_login($admin_username, $admin_password);
			?>
			<div class="message"><span class="top_message">Plese select category to order skills with drag and drop elements!</span></div>
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
		
		<h1>Display your skills records<? if(isset($_REQUEST['category_filter'])) echo " in category " . $_REQUEST['category_filter']; ?></h1>
		<p>Click to edit skill, select category to order the skills with drag and drop</p>
		<form method="post">
		
		<div class="filter_box clear">
					<? category_array('filter'); ?>
					<input type="submit" name="btn_submit" value=" select " class="submit filter">
		</div>
		<div id="sortable">
		<?
			if (!(isset($error_msg))) {
				echo display_skill();
			}	else {
				echo error_msg($msg);
			}
		?>	
		</div>
		</form>
		<div class="total">
			total skill: <? echo $count_skill; ?>
		</div>
		</div>
		<div id="mainform" class="myform flash clear">
			<form method="post" id="form" name="form" enctype="multipart/form-data">
				<div class="clear">
					<h1><? echo $msg_form; ?></h1>
					<p>Fill form fields to record skill</p>
					<label for="skill_name" <? echo $style_text_edit; ?>>Category
						<span class="small">select category for skill</span>
					</label><? category_array('add'); ?>
				</div>
				<div class="clear">
					<label for="skill_name" <? echo $style_text_edit; ?>>Skill name
						<span class="small">add your skill name</span>
					</label><input type="text" name="skill" id="skill_name" value="<? echo $edit_skill; ?>" placeholder="Enter your skill name" required="true" />
				</div>
				<div class="clear">
					<label for="percent_skill" <? echo $style_text_edit; ?>>Percent skill
						<span class="small">add your persent from 0 to 100 </span>
					</label><input type="range" min="0" max="100" value="<? echo $edit_percent; ?>" name="percent" id="percent_skill" onchange="showValue(this.value)" />
					<div class="persent_value"><output id="rangevalue"><? echo $edit_percent; ?></output>%</div>
				</div>
				<div class="clear">
					<label for="extra_info" <? echo $style_text_edit; ?>>Extra info
						<span class="small">add more extra information about your skill</span>
					</label><textarea name="info" id="extra_info"><? echo $extra_info; ?></textarea>
				</div>
				<div class="clear">
					<label for="img_general" <? echo $style_text_edit; ?>>Please select a picture from list:
						<span class="small">Srcipt will add image to your skill</span>
					</label>
				
					<div id="img_container">
						<div class="select_img">
							<img src="../img/icons/no_image/no_image.png" class="img_display" alt="no image" title="no image">

							<input type="radio" name="img_general" value="img/icons/no_image/no_image.png" class="radio_btn" 
							<? if (($img_src == "img/icons/no_image/no_image.png") || ($img_src == "")) {
									echo "checked=\"checked\"";
								} 
							?>
							/>
						</div>
						<? echo  img_container($img_src, $_GET['id']); ?>
					</div>
				</div>
				<div class="clear"> 
					<label for="image_add" <? echo $style_text_edit; ?>>Please select a picture to upload:
						<span class="small">Srcipt will create your custom image trumb 50x50px for your skill</span>
					</label><input type="file" name="imgfile" id="image_add" />
					<input type="hidden" value="update_skill" id="order_mod" />
					<input type="hidden" value="<? echo $_GET['id']; ?>" name="submit_edit" />
					<input type="hidden" value="skill_query" name="mod" />
					<input type="submit" name="submit" value="<? echo $button_name; ?>" class="submit" /> 
				</div>
			</form>
		</div>
	</div>

	<footer id="bottom">
				created by <a href="http://siropo.avaart.net/" title="author Viktor Ivanov" alt="author Viktor Ivanov" target="_blank" class="author">Victor Ivanov</a>/ skill meter system beta 0.1
	</footer>
	<? if ((isset($_REQUEST['category_filter'])) and ($_REQUEST['category_filter'] != "")) {  ?>
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
	<? } ?>
	</body>
</html>