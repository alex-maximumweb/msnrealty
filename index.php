<?
	include_once($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
	dbconnect();	
	$sql = mysql_query("SELECT * FROM `providers`");
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo "<a href=\"/feeds.php?providerid=".$row['provider_id']."\">".$row['provider_name']."</a><br/>";
	}
	mysql_close();
?>