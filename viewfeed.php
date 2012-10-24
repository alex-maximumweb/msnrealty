<?
	include_once("config.inc.php");
	dbconnect();

	//reading settings for current RSS from the database
	$sql = mysql_query("SELECT items_total, exportfeed_name FROM export_feeds");
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) ) {
		$_PRESETS['items_total'] = $row['items_total'];
		$_PRESETS['feed_title'] = $row['exportfeed_name'];
	}
	
	//selecting links of input RSS feeds to be combined
	$sql = mysql_query("
		SELECT feeds_mapping.export_feed_id, export_feeds.exportfeed_name, feeds_mapping.provider_feed_id, provider_feeds.feed_id, provider_feeds.feed_url, provider_feeds.feed_title, provider_feeds.provider_id  
		FROM feeds_mapping 
		INNER JOIN provider_feeds 
		ON provider_feeds.feed_id = feeds_mapping.provider_feed_id 
		INNER JOIN export_feeds 
		ON export_feeds.exportfeed_id = feeds_mapping.export_feed_id 
		WHERE feeds_mapping.export_feed_id = '".$_GET['feedid']."'
	");
	
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) ) {
		$feeds['urls'][] = $row['feed_url'];
		$feeds['titles'][] = $row['feed_title'];
		$feeds['providerids'][] = $row['provider_id'];
	}
	
	$i = 0; //just an array counter
	$total_links = 0; //total quantity of links in all incoming RSS feeds
	$max_links = $_PRESETS['items_total']; //maximum amount of links in export RSS feed (should be get from DB later)

	foreach( $feeds['urls'] as $key=>$value ) {
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
	
	$total_input_RSS = $i; //just figuring out the total amount of input RSS feeds (also can be obtained from the database)
	$export_link_counter = 0; //counter for limiting total links in RSS feed
	
	//starting to generate array of result items for RSS feed
	for( $i = 0; $i < $total_links; $i++ ) {
		for ( $j = 0; $j < $total_input_RSS; $j++ ) {
			if( !empty( $_RSS_PREPARE[$j][$i] ) ) {
				if( $export_link_counter < $max_links ) {
					$_RSS_EXPORT[] = $_RSS_PREPARE[$j][$i];				
					$export_link_counter++;
				}
			}
		}
	}

	switch( $_GET['viewtype'] ) {
		case 'table':
			include_once( $_PATH['include']."/header.inc.php");
			echo "<h3>".$_PRESETS['feed_title']."</h3>";
			echo "&larr; <a href=\"".$_URL['siteroot']."/\">К списку фидов</a> | <a href=\"".$_URL['siteroot']."/viewfeed.php?feedid=".$_GET['feedid']."\">Посмотреть как RSS</a>";
			echo "<h5>Настройки исходящего фида</h5>";
			echo "<ul>";
				echo "<li>Название: &laquo;".$_PRESETS['feed_title']."&raquo;</li>";
				echo "<li>Количество материалов: ".$_PRESETS['items_total']."</li>";
				echo "<li><a href='#' class='btn' data-toggle='modal'>Изменить настройки</a></li>";
			echo "</ul>";
			echo "<h5>Список входящих фидов</h5>";
			echo "<ul>";			
			foreach( $feeds['urls'] as $key => $value ) {
					echo "<li><a href=\"".$value."\" target=\"_blank\">".$value."</a> &mdash; <a href=\"/providers.php?providerid=".$feeds['providerids'][$key]."\">".$feeds['titles'][$key]."</a></li>";
			}
			echo "<li><a href='#add-feed' class='btn' data-toggle='modal' />Добавить фид</a></li>";
			echo "</ul>";
			echo "<h5>Содержимое исходящего фида</h5>";			
			echo "
				<table class='table table-condensed'>
			";
			foreach( $_RSS_EXPORT as $key => $value ) {
				echo "
					<tr>
						<td style=\"width: 120px\"><a href=\"".$value['link']."\" target=\"_blank\"><img src=\"".$value['image']."\" style=\"width: 100px;\"/></a></td>
						<td>
							<a href=\"".$value['link']."\" target=\"_blank\">".$value['title']."</a><br/>
							<small>".$value['pubdate']."</small><br/>
							<small>".$value['description']."</small>
						</td>
					</tr>
				";
			}

			echo "</table>";
			echo "
				<div class='modal fade' id='add-feed'>
				  <div class='modal-header'>
				    <a class='close' data-dismiss='modal'>&times;</a>
				    <h3>Выберите фид из списка</h3>
				  </div>
				  <div class='modal-body'>
				    <p></p>
				  </div>
				  <div class='modal-footer'>
				    <a href='#' class='btn' data-dismiss='modal'>Close</a>
				    <a href='#' class='btn btn-primary'>Save Changes</a>
				  </div>
				</div>'
			";
			include_once( $_PATH['include']."/footer.inc.php");
		break;
		default:
			//showing the RSS feed from the array
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
				echo "<enclosure length=\"".$value['imagelength']."\" type=\"".$value['imagetype']."\" url=\"".$value['image']."\"></enclosure>";
				echo "<pubDate>".$value['pubdate']."</pubDate>";
				echo "</item>";		
			}	
			
			echo "</channel>";
			echo "</rss>";		
	}
	
	mysql_close();
?>