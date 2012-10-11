<?
	include_once($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
	dbconnect();
	$sql = mysql_query("SELECT * FROM `provider_feeds` WHERE `provider_id` = '".$_GET['providerid']."'");
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo "<a href=\"/fetch.php?feedid=".$row['feed_id']."\">".$row['feed_title']."</a><br/>";
	}	
	mysql_close();
?>