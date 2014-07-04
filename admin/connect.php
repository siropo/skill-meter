<?
include "global.php";
mysql_connect("localhost",$mysql_username,$mysql_password) or die ( 'Грешка при свързване с MySQL!' );
mysql_select_db($database) or die( "Не мога да намеря базата");
mysql_query('set names utf8');
?>