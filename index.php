<?
	include_once($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
	dbconnect();
	
	$sql = mysql_query("SELECT * FROM `providers`");
	echo "<h2>Список провайдеров</h2>";
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo "<a href=\"/providers.php?providerid=".$row['provider_id']."\">".$row['provider_name']."</a><br/>";
	}
	
	$sql = mysql_query("SELECT * FROM `export_feeds`");
	echo "<h2>Список выходных потоков</h2>";
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo "<a href=\"/viewfeed.php?feedid=".$row['exportfeed_id']."\">".$row['exportfeed_name']."</a><br/>";
	}
	
	mysql_close();
?>