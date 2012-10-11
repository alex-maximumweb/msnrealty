<?
	include_once($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
	
	dbconnect();
	
	$sql = mysql_query("SELECT feed_url FROM `provider_feeds` WHERE `feed_id` = '".$_GET['feedid']."' LIMIT 1");
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		$url = $row['feed_url'];
	}
	$xml = simplexml_load_file($url);
	
	foreach ($xml->channel->item as $item) {
		$_SQL['link'] = trim($item->link);
		$_SQL['image'] = $item->enclosure["url"];		
		$_SQL['title'] = $item->title;
		$_SQL['description'] = $item->description;
		$_SQL['pubdate'] = $item->pubDate;
		
		$checklinksql = mysql_query("SELECT `link_id` FROM `links` WHERE `link_url` = '".$_SQL['link']."' LIMIT 10");
		if(mysql_num_rows($checklinksql) > 0) {
			$sql = mysql_query("UPDATE `links` SET 
				`image_url` = '".$_SQL['image']."', 
				`link_title` = '".$_SQL['title']."', 
				`linkdatetime` = '".$_SQL['pubdate']."'  
				WHERE `link_url` = '".$_SQL['link']."'
			");
		} else {
			$sql = mysql_query("INSERT INTO `links` VALUES (null, '".$_SQL['link']."', '".$_SQL['image']."', '".$_SQL['title']."', '".$_SQL['pubdate']."')");
		}
	}
	
	mysql_close();
?>