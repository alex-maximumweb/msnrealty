<?
	include_once($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
	dbconnect();

	$sql = "
		SELECT feeds_mapping.export_feed_id, export_feeds.exportfeed_name, feeds_mapping.provider_feed_id, provider_feeds.feed_id, provider_feeds.feed_url  
		FROM feeds_mapping 
		INNER JOIN provider_feeds 
		ON provider_feeds.feed_id = feeds_mapping.provider_feed_id 
		INNER JOIN export_feeds 
		ON export_feeds.exportfeed_id = feeds_mapping.export_feed_id 
		WHERE feeds_mapping.export_feed_id = '".$_GET['feedid']."'
	";
	$sql = mysql_query($sql);
	
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) ) {
		echo $row['feed_url']."<br/>";
	}

	mysql_close();
?>