<?
/* ------------------------------------------------------------------------------*/
/*
	Skill meter system 
	Version: beta 0.1
	author: Viktor Ivanov
	web portfolio: http://siropo.avaart.net/
	web blog: http://ivanov.avaart.net/
*/
/* ------------------------------------------------------------------------------*/


/* login check */
/* ------------------------------------------------------------------------------*/

function check_login($get_username, $get_password) {
	if($_SESSION['authuser']!=1){
		login($get_username, $get_password);
	}
	if ($_GET['logout'] == 1) {
		logout();
	}
}

function login($username, $password) {
	$_SESSION['username']=$_POST['name'];
	$_SESSION['userpass']=$_POST['password'];

	if (($_SESSION['username']==$username) and
     ($_SESSION['userpass']==$password)) {
		$_SESSION['authuser']=1;
     } else {
		echo "Login error!  <a href=\"login.php\">Try again</a>";
		echo "</div>
			</body>
		</html>";
       exit();
     }
}

function logout() {
	header( 'refresh: '.(0).'; url= '. 'login.php' );
		if(!isset($_REQUEST['logmeout'])){
		session_unset();
		session_destroy();
		exit();
	}
}

/* ------------------------------------------------------------------------------*/

error_reporting(E_ERROR | E_WARNING | E_PARSE);

include "connect.php";

$edit_percent = "0";

if ($_GET['page']=="category") {
	$button_name = "submit category";
} else {
	$button_name = "submit skill";
}

$submit_edit = $_POST['submit_edit'];

/* Check for action in form and return fuction */
/* ------------------------------------------------------------------------------*/

if (isset($_POST["submit"])) { 
	submit_form($_POST['mod']);
} 

if($_GET['action']=="delete_skill") {
	delete_skill();
}

if($_GET['action']=="delete_category") {
	delete_category();
}

if ($_POST['action'] == "update_skill") {
	order_skill();
}

if ($_POST['action'] == "update_category") {
	order_category();
}

/* Error and success  message */
/* ------------------------------------------------------------------------------*/

function error_msg($msg) {
	echo "<div id=\"wrapper\">
				<div class=\"error_msg\" class=\"bounceInDown\">message: ".$msg."<a href='javascript:history.back()' class=\"select\">go back</a>
				</div></div></body></html>";
	exit;
}

function success_msg($msg) {
	echo "<div class=\"success\" class=\"bounceInDown\">message: ".$msg."</div>";
}

/* cyrillic to latin characters for create directories for images */
/* ------------------------------------------------------------------------------*/

function ru2lat($str)
{
    $tr = array(
    "А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
    "Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i", 
    "Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n", 
    "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t", 
    "У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch", 
    "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"", 
    "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b", 
    "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo", 
    "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k", 
    "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", 
    "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", 
    "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", 
    "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu", 
    "я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",  
    ":"=>"", ";"=>"","—"=>"", "–"=>"-", "#"=>"sharp", "%"=>"persent", "*"=>"star", "?"=>"query",
	"<"=>"left_basket",">"=>"right_basket"
    );
return strtr($str,$tr);
}

/* Query to add and upade skills and category */
/* ------------------------------------------------------------------------------*/

function submit_form($mod) {
	if ($mod=="skill_query") {
		skill_query();
	} 
	if ($mod=="category_query") {
		category_query();
	} 
}

function skill_query() {

	$skill_name = $_POST['skill'];
	$image_general = $_POST['img_general'];
	$img_file = $_FILES['imgfile'];
	$percent = $_POST['percent'];
	$extra_info = mysql_real_escape_string($_POST['info']);
	$category = $_POST['category_add'];
	$date = date("F j, Y");
	$submit_edit = $_POST['submit_edit'];
	$last_order_skill = $_POST['last_order_skill'];
	
	
	$query_id_cat=mysql_query("SELECT id FROM category where name='".$category."'");
	$result_id_cat=mysql_fetch_array($query_id_cat);
	$category = $result_id_cat['id'];
	
	if($skill_name == "") {
		$error_msg = true;
		error_msg("please enter your skill name!");
	} 
	if (($percent < 0) || ($percent > 100)) {
		$error_msg = true;
		error_msg(" slide must have number 0 to 100 ");
	}
	
	$create_directory = ru2lat($skill_name);
	
	if (!($_FILES['imgfile']['name'] == "")) {
		if(mkdir("../img/icons/".$create_directory  , 0777)) { 
		   success_msg("Directory has been created successfully..."); 
		} else { 
		   success_msg("Directory exist!"); 
		} 

		$uploadpath = "../img/icons/".$create_directory."/"; 
		$uploadpath = $uploadpath.basename($_FILES["imgfile"]["name"]); 
		if (!move_uploaded_file($_FILES["imgfile"]["tmp_name"], $uploadpath)) 
		die("There was an error uploading the file, please try again!"); 
		$image_name = "../img/icons/".$create_directory."/".$_FILES["imgfile"]["name"]; 
		list($width,$height) = getimagesize($image_name); 
		
		if (($width < 32) || ($height < 32)) {
			$error_msg = true;
			error_msg("image must have width and height > 32px");
		}
		
		$new_image_name = "../img/icons/".$create_directory."/thumb_".$_FILES["imgfile"]["name"]; 
		$mysql_img_link = "img/icons/".$create_directory."/thumb_".$_FILES["imgfile"]["name"]; 
		if ($width > $height) { 
				$ratio = (32/$width); 
				$new_width = round($width*$ratio); 
				$new_height = round($height*$ratio); 
			} else { 
				$ratio = (32/$height); 
				$new_width = round($width*$ratio); 
				$new_height = round($height*$ratio); 
			} 
		$image_p = imagecreatetruecolor($new_width,$new_height); 
		$img_ext = $_FILES['imgfile']['type']; 
		if ($img_ext == "image/jpg" || $img_ext == "image/jpeg") { 
			$image = imagecreatefromjpeg($image_name); 
			} else if ($img_ext == "image/png") { 
			$image = imagecreatefrompng($image_name); 
			imagecolortransparent($image_p, imagecolorallocatealpha($image_p, 0, 0, 0, 127));
			imagealphablending($image_p, false);
			imagesavealpha($image_p, true);
			} else if ($img_ext == "image/gif") { 
			$image = imagecreatefromgif($image_name); 
			imagecolortransparent($image_p, imagecolorallocatealpha($image_p, 0, 0, 0, 127));
			imagealphablending($image_p, false);
			imagesavealpha($image_p, true);
			} else { 
				$error_msg = true;
				error_msg("this is no valid image resource");
		} 
		
		imagecopyresampled($image_p,$image,0,0,0,0,$new_width,$new_height,$width,$height); 
			
		if ($img_ext == "image/png") {
			imagepng($image_p,$new_image_name,9); 
			success_msg("Image uploaded!");  
		} elseif ($img_ext == "image/gif") {
			imagegif($image_p,$new_image_name,9); 
			success_msg("Image uploaded!");  
		} else {
			imagejpeg($image_p,$new_image_name,100); 
			success_msg("Image uploaded!");  
		}
	} else {
		$mysql_img_link = $image_general;
	}
	
	if (!($submit_edit == "")) {
		$record="UPDATE skill set skill='$skill_name', percent='$percent', extra_info='$extra_info', img_src='$mysql_img_link',  category='$category', date='$date' WHERE id='$submit_edit'";
	} else {
		$record="INSERT into skill(skill, percent, extra_info, img_src, category, order_skill, date) VALUES ('$skill_name', '$percent','$extra_info', '$mysql_img_link', '$category', '$last_order_skill', '$date')";
	}
	
	if(!mysql_query($record)) {
		print mysql_error();
	}

	if(mysql_affected_rows() == 0) {
		echo mysql_error();
	} else {
		success_msg("record success");
	}	
}

function category_query() {
	$cat_name = $_POST['category_name'];
	$submit_edit = $_POST['submit_edit'];
	$order_cat = 0;
	$last_order_cat = $_POST['last_order_skill'];
	
	$result_order = mysql_query("SELECT MAX(order_cat) FROM category");
	$row_order = mysql_fetch_row($result_order);
	$highest_id = $row_order[0];
	
	$order_cat = $highest_id+1;
	
	if (!($submit_edit == "")) {
		$record="UPDATE category set name='$cat_name' where id='".$_GET['id']."'";
	} else {
		$record="INSERT into category(name, order_cat) VALUES ('$cat_name', '$order_cat')";
	}
	
	if(!mysql_query($record)) {
		print mysql_error();
	}

	if(mysql_affected_rows() == 0) {
		echo mysql_error();
	} else {
		success_msg("record success");
	}	
}

/* Delete records */
/* ------------------------------------------------------------------------------*/

function delete_skill() {

	$delete="DELETE from skill where id='".$_GET['id']."'";
	
	if(!mysql_query($delete)) {
		print mysql_error();
	}

	if(mysql_affected_rows() == 0) {
		echo mysql_error();
	} else {
		success_msg("delete success");
		unset($_GET['action']);
	}
}

function delete_category() {

	$delete="DELETE from category where id='".$_GET['id']."'";
	
	if(!mysql_query($delete)) {
		print mysql_error();
	}

	if(mysql_affected_rows() == 0) {
		echo mysql_error();
	} else {
		success_msg("delete success");
		unset($_GET['action']);
	}
}

/* Display functions for skills and category */
/* ------------------------------------------------------------------------------*/

function display_category_order() { 

global $edit_cat, $button_name, $style_text_edit, $msg_form, $count_skill, $count_cat, $msg_form;

$msg_form = "Add new category";

if($_GET['action']=="edit_cat") {
		 $query_edit_cat=mysql_query("SELECT * FROM category where id='".$_GET['id']."'")or die(mysql_error()); 
		 $edit_row_cat=mysql_fetch_array($query_edit_cat);
			 $edit_cat = $edit_row_cat['name'];
			 $button_name = "Edit Category";
			 $style_text_edit = "class=\"orange_text\"";
			 $msg_form = "Edit current categry";
			 $select = "select";

	} 

$categories = array();
$result= mysql_query("SELECT * FROM category ORDER BY order_cat ASC");
$count_cat = mysql_num_rows($result);

while($row = mysql_fetch_assoc($result)) {
    $categories[$row['id']][] = $row['name'];
}

foreach($categories as $key => $category){
echo "
		<div id=\"arrayorder_". $key ."\" class=\"output_name ";
	if ($_GET['id'] == $key) {
		echo $select;
	}
	echo " clear\">";
   
    foreach($category as $item) {
		echo "
			<div class=\"category_name\">
				<a href=\"category_order.php?action=edit_cat&amp;id=".$key."&amp;category_filter=".$_REQUEST['category_filter']."\" class=\"link_skill\">".$item."</a>
			</div>
			<div class=\"category_delete\">
				<a href=\"?action=delete_category&amp;id=".$key."\" class=\"delete_link\" onclick=\"return confirmDelete(this);\"><img src=\"img/delete.png\" alt=\"delete category\" title=\"delete category\" /></a>
			</div>
		";
	
    }
	echo "</div>";
}
}

function display_skill() { 
	global $edit_skill, $edit_percent, $extra_info, $img_src, $category, $button_name, $style_text_edit, $msg_form, $count_skill, $msg_form;
	
	$msg_form = "Add new skill";
	
	if($_GET['action']=="edit_skill") {
		 $query_edit=mysql_query("select * from skill where id='".$_GET['id']."'")or die(mysql_error()); 
		 $edit_row=mysql_fetch_array($query_edit);
			
			$edit_skill = $edit_row['skill'];
			$edit_percent = $edit_row['percent'];
			$extra_info = $edit_row['extra_info'];
			$img_src = $edit_row['img_src'];
			$category = $edit_row['category'];
			$button_name = "Edit Skill";
			$style_text_edit = "class=\"orange_text\"";
			$msg_form = "Edit current skill";
			$select = "select";
	} 
	
	$query_id_cat=mysql_query("SELECT id FROM category where name='".$_REQUEST['category_filter']."'");
	$result_id_cat=mysql_fetch_array($query_id_cat);
	$category_filter_id = $result_id_cat['id'];

	if(($_REQUEST['category_filter'] == "all category") || ($_REQUEST['category_filter'] == "")) {
		$category_filter = "";
	} else {
		$category_filter = " WHERE category='".$category_filter_id."'";
	}

	$query=mysql_query("select * from skill".$category_filter." ORDER BY order_skill ASC")or die(mysql_error()); 
	$count_skill = mysql_num_rows($query);
	while ($result=mysql_fetch_array($query)) {
	
	$query_name_cat=mysql_query("SELECT name FROM category where id='".$result['category']."'");
	$result_name_cat=mysql_fetch_array($query_name_cat);
	$category_name = $result_name_cat['name'];

	if (isset($_REQUEST['category_filter'])) {
		$category_filter = $_REQUEST['category_filter'];
	} else {
		$category_filter = $category_name;
	}
	echo "
	<div id=\"arrayorder_". $result['id'] ."\" class=\"output_name ";
	if ($_GET['id'] == $result['id']) {
		echo $select;
	}
	echo " clear\">
		<div class=\"img_link_hold clear\">
			<div class=\"img_hold\">
				<a href=\"?action=edit_skill&amp;id=".$result['id']."&amp;category_filter=".$category_filter."\"><img src=\"../".$result['img_src']."\" alt=\"".$result['skill']."\" title=\"".$result['skill']."\" class=\"img_skill\" /></a>
			</div>
			<div class=\"link_hold\">
				<a href=\"?action=edit_skill&amp;id=".$result['id']."&amp;category_filter=".$category_filter."\" class=\"link_skill\">".$result['skill']."</a>
				<span>".$category_name."</span>
			</div>
		</div>
		<div class=\"progress_bar\">
			<div class=\"meter orange nostripes\">
				<span style=\"width: ".$result['percent']."%\"></span>
			</div>
			<input type=\"hidden\" class=\"hidden_value\" value=\"".$result['percent']."\" />
			<span class=\"view_persent span_".$result['percent']."\">".$result['percent']."%</span><a href=\"?action=delete_skill&amp;id=".$result['id']."\" class=\"delete_link\" onclick=\"return confirmDelete(this);\"><img src=\"img/delete.png\" alt=\"delete skill\" title=\"delete skill\" /></a>
		</div>
	</div>";

	}

}

/* Fucntion to choice images in form */
/* ------------------------------------------------------------------------------*/

function img_container($selected_img, $is_edit_mode) {
	
	$imgs = glob("../img/icons/*.{png,PNG,jpg,JPG,jpeg,JPEG,gif,GIF,bmp,BMP}", GLOB_BRACE);
	
	if (!(($is_edit_mode) == "") and ($_GET['action'] != "delete")) {
		if (strrpos($selected_img, '/icons/', -7) == false) {
			echo "
			<div class=\"select_img\"><img src=\"../$selected_img\" class=\"img_display\" alt=\"$img\" title=\"$img\" />
				<input type=\"radio\" name=\"img_general\" value=\"$selected_img\" class=\"radio_btn\" checked=\"checked\" />
			</div> ";
		}
	}
	
	foreach($imgs as $img) {
	$img_link = substr($img, 3);
		if ($selected_img == $img_link) {
			echo "
			<div class=\"select_img\"><img src=\"$img\" class=\"img_display\" alt=\"$img\" title=\"$img\" />
				<input type=\"radio\" name=\"img_general\" value=\"$img_link\" class=\"radio_btn\" checked=\"checked\" />
			</div> ";
		} else {
			echo "
				<div class=\"select_img\"><img src=\"$img\" class=\"img_display\" alt=\"$img\" title=\"$img\" />
					<input type=\"radio\" name=\"img_general\" value=\"$img_link\" class=\"radio_btn\" />
				</div> ";
		}
	}
}

/* order functions */
/* ------------------------------------------------------------------------------*/

function order_skill() {

	$array	= $_POST['arrayorder'];
		$count = 1;
		foreach ($array as $idval) {
			$query = "UPDATE skill SET order_skill = " . $count . " WHERE id = " . $idval;
			mysql_query($query) or die('Error, insert query failed');
			$count ++;	
		}
		
		echo "<span class=\"success\">All saved! refresh the page to see the changes</span>";
}

function order_category() {

	$array = $_POST['arrayorder'];

		$count = 1;
		foreach ($array as $idval) {
			$query = "UPDATE category SET order_cat = " . $count . " WHERE id = " . $idval;
			mysql_query($query) or die('Error, insert query failed');
			$count ++;	
		}

		echo "<span class=\"success\">All saved! refresh the page to see the changes</span>";
}

/* Function for select filter category */
/* ------------------------------------------------------------------------------*/

function category_array($name) {
	$categories = array();
	$result= mysql_query("SELECT name, order_cat FROM category ORDER BY order_cat ASC");

	while($row = mysql_fetch_assoc($result)) {
		$categories[$row['id']][] = $row['name'];
	}
	echo "<select name=\"category_".$name."\" class=\"filter_skill\">
					<option value=\"\">all category</option>";
	foreach($categories as $key => $category){

		foreach($category as $item) {
			if($_REQUEST['category_filter'] != "") {
					$checked_filter = '';
					if ($_REQUEST['category_filter'] == $item) $checked_filter = 'selected="selected"';
					echo '<option value="' . $item . '"' . $checked_filter . '>' . $item . "</option>";
				} else {
					echo '<option value="' . $item . '">' . $item . "</option>";
				} 
		
		}

	}
	echo "</select>";
}

?>
