<?
include_once("config.inc.php");
include_once($_PATH['include']."/header.inc.php");
dbconnect();

$sql = mysql_query("INSERT INTO providers VALUES (null, '".$_POST['providername']."')");
if( !$sql ) {
	echo "error";
} else {
	echo "success";
}

mysql_close();
?>