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

include "admin/connect.php";

/* display skills on front */
/* ------------------------------------------------------------------------------*/

	function display_skills_front() { 

	$query_cat=mysql_query("select * from category ORDER BY order_cat ASC")or die(mysql_error()); 
	$count_cat= mysql_num_rows($query_cat);
	$count_percent_category = 0;
	
	while ($result_cat=mysql_fetch_array($query_cat)) {
			
			$query=mysql_query("select * from skill where category='".$result_cat['id']."' ORDER BY order_skill ASC")or die(mysql_error()); 
			$count_skill = mysql_num_rows($query);
			echo "<div class=\"wrap_category clear\">
						<div class=\"cat_tab\">" . $result_cat['name'] . "</div>";
			while ($result=mysql_fetch_array($query)) {
				if ($result['extra_info']=="") {
					$extra_info = "No records!";
				} else {
					$extra_info = $result['extra_info'];
				}
			echo "<div id=\"arrayorder_". $result['id'] ."\" class=\"output_name clear\">
				<div class=\"clear\">
					<div class=\"img_link_hold clear\">
						<div class=\"img_hold\">
							<div id=\"img_".$result['id']."\"><img src=\"".$result['img_src']."\" alt=\"".$result['skill']."\" title=\"".$result['skill']."\" class=\"img_skill\" /></div>
						</div>
						<div class=\"link_hold\">
							<span id=\"".$result['id']."\" class=\"link_skill\">".$result['skill']."</span>
							<span class=\"date\">added on ".$result['date']."</span>
						</div>
					</div>
					<div class=\"progress_bar\">
						<div class=\"meter orange nostripes\">
							<span style=\"width: ".$result['percent']."%\"></span>
						</div>
						<input type=\"hidden\" class=\"hidden_value\" value=\"".$result['percent']."\" />
						<span class=\"view_persent span_".$result['percent']."\">".$result['percent']."%</span>
					</div>
				</div>
				<div id=\"info_number_".$result['id']."\" class=\"extra_info\"><p>".$extra_info."</p></div>
			</div>";
			$count_percent_category += $result['percent'];
			}
			$average_scores = round($count_percent_category/$count_skill);
			echo "<div class=\"output_info clear\"><div class=\"total_info\">total skills in this category: <span class=\"orange\">" . $count_skill . "</span></div>
			<div class=\"total_info\">average rate in this category: <span class=\"orange\">" . $average_scores  . "%</span></div></div>";
			unset($count_percent_category);
			$count_percent_category = 0;
			echo "</div>";
	}
}

/* count records */
/* ------------------------------------------------------------------------------*/

function count_records() {
	global $count_skill, $count_category;
	$result_skill= mysql_query("SELECT * FROM skill");
	$count_skill= mysql_num_rows($result_skill);
	
	$result_category= mysql_query("SELECT * FROM category");
	$count_category= mysql_num_rows($result_category);
	
}

/* get last update date */
/* ------------------------------------------------------------------------------*/

function last_update() {
	global $last_date;
	$result_date = mysql_query("SELECT MAX(date) FROM skill");
	$row_date = mysql_fetch_row($result_date);
	$last_date = $row_date[0];
	echo $last_date;
}

?>