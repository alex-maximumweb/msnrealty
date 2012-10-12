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
	
	$i = 0; //just an array counter
	$total_links = 0; //total quantity of links in all incoming RSS feeds
	$max = 20; //maximum amount of links in export RSS feed (should be get from DB later)
	
	foreach( $feeds as $key=>$value ) {
		$xml = simplexml_load_file( $value );
		$j = 0;
		foreach( $xml->channel->item as $item ) {
			$_RSS_PREPARE[$key][$j]['link'] = trim($item->link);
			$_RSS_PREPARE[$key][$j]['image'] = $item->enclosure["url"];
			$_RSS_PREPARE[$key][$j]['imagelength'] = $item->enclosure["length"];
			$_RSS_PREPARE[$key][$j]['imagetype'] = $item->enclosure["type"];
			$_RSS_PREPARE[$key][$j]['title'] = $item->title;
			$_RSS_PREPARE[$key][$j]['description'] = $item->description;
			$_RSS_PREPARE[$key][$j]['pubdate'] = $item->pubDate;
			$j++;
			$total_links++;
		}
		$i++;
	}
	
	$total_input_RSS = $i;
	
	for( $i = 0; $i < $total_links; $i++ ) {
		for ( $j = 0; $j < $total_input_RSS; $j++ ) {
			if( !empty( $_RSS_PREPARE[$j][$i] ) ) {
				$_RSS_EXPORT[] = $_RSS_PREPARE[$j][$i];				
			}
		}
	}

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	echo "<rss version=\"2.0\">";
	echo "<channel>";
	echo "<title>MSN Combine Feed</title>";
	echo "<link>http://ru.msn.com/</link>";
	echo "<description></description>";
	
	foreach( $_RSS_EXPORT as $key => $value ) {
		echo "<item>";
		echo "<title>".$value['title']."</title>";
		echo "<link>".$value['link']."</link>";
		echo "<guid isPermaLink=\"true\">".$value['link']."</guid>";
		echo "<description>".$value['description']."</description>";
		echo "<enclosure length=\"".$value['imagelength']."\" type=\"".$value['imagetype']."\"></enclosure>";
		echo "<pubDate>".$value['pubdate']."</pubDate>";
		echo "</item>";		
	}	
	
	echo "</channel>";
	echo "</rss>";
		
	mysql_close();
?>