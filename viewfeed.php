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
		$feeds[] = $row['feed_url'];
	}

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	echo "<rss version=\"2.0\">";
	echo "<channel>";
	echo "<title>MSN Combine Feed</title>";
	echo "<link>http://ru.msn.com/</link>";
	echo "<description></description>";
	
	$i = 0;
	$max = 4;
	
	foreach( $feeds as $key=>$value ) {
		$xml = simplexml_load_file( $value );
		foreach( $xml->channel->item as $item ) {
			$_SQL['link'] = trim($item->link);
			$_SQL['image'] = $item->enclosure["url"];
			$_SQL['imagelength'] = $item->enclosure["length"];
			$_SQL['imagetype'] = $item->enclosure["type"];
			$_SQL['title'] = $item->title;
			$_SQL['description'] = $item->description;
			$_SQL['pubdate'] = $item->pubDate;
			echo "<item>";
			echo "<title>".$_SQL['title']."</title>";
			echo "<link>".$_SQL['link']."</link>";
			echo "<guid isPermaLink=\"true\">".$_SQL['link']."</guid>";
			echo "<description>".$_SQL['description']."</description>";
			echo "<enclosure length=\"".$_SQL['imagelength']."\" type=\"".$_SQL['imagetype']."\"></enclosure>";
			echo "<pubDate>".$_SQL['pubdate']."</pubDate>";
			echo "</item>";
		}
		if( $i == $max-1 ) {
			break;
		}
		$i++;
	}
	
	echo "</channel>";
	echo "</rss>";

	mysql_close();
?>