<?
	include_once("config.inc.php");
	include_once($_PATH['include']."/header.inc.php");
	dbconnect();
	
	$sql = mysql_query("SELECT * FROM `providers`");
	echo "<h2>Список провайдеров</h2>";
	echo "<ul>";
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo 
		"<li class=\"dropdown\">
			<a href=\"".$_URL['siteroot']."/providers.php?providerid=".$row['provider_id']."\">
				".$row['provider_name']."
			</a> <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-cog\"></i></a>
			<ul class=\"dropdown-menu\">
				<li><a href=\"#test_modal\" data-toggle=\"modal\">Удалить</a></li>
				<li><a href=\"#\">Переименовать</a></li>
			</ul>
		</li>";
	}
	echo "</ul>";
	
	$sql = mysql_query("SELECT * FROM `export_feeds`");
	echo "<h2>Список выходных потоков</h2>";
	echo "<ul>";
	while( $row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
		echo "
		<li class=\"dropdown\">
			<a href=\"".$_URL['siteroot']."/viewfeed.php?feedid=".$row['exportfeed_id']."\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
				".$row['exportfeed_name']."<i class=\"icon-cog\" style=\"margin-left: 5px;\"></i></a>
			<ul class=\"dropdown-menu\">
				<li><a href=\"".$_URL['siteroot']."/viewfeed.php?feedid=".$row['exportfeed_id']."&viewtype=table\" /><i class=\"icon-list\"></i> Посмотреть как таблицу</a></li>
				<li><a href=\"".$_URL['siteroot']."/viewfeed.php?feedid=".$row['exportfeed_id']."\" /><i class=\"icon-file\"></i> Посмотреть как RSS</a></li>				
			</ul>
		</li>
		";
	}
	echo "</ul>";
	
	mysql_close();
?>
<div class="modal fade" id="test_modal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Действительно удалить?</h3>
  </div>
  <div class="modal-body">
    <p>Test Modal</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary">Save Changes</a>
  </div>
</div>

<?
	include_once($_PATH['include']."/footer.inc.php");
?>