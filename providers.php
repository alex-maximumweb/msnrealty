<?
	include_once("config.inc.php");
	include_once($_PATH['include']."/header.inc.php");
	dbconnect();
	
	echo "<h2>Список фидов провайдера</h2>";
	$sql = mysql_query("SELECT * FROM `provider_feeds` WHERE `provider_id` = '".$_GET['providerid']."'");
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo "<a href=\"".$row['feed_url']."\" target=\"blank\">".$row['feed_title']."</a><br/>";
	}	
	
	mysql_close();
	include_once($_PATH['include']."/footer.inc.php");
?>