<?
	$_PATH['include'] = $_SERVER['DOCUMENT_ROOT']."/include";
	
	function dbconnect() {
		$mysql_connect = mysql_connect( 
			"localhost", 
			"msnuser", 
			"ZmFFYjvJRw9yXRY5" ) 
		or die ( "Cannot connect to server" );
		$mysql_select_db = mysql_select_db( "msnrealty", $mysql_connect ) or die ( "Cannot select database" );
		mysql_query( "SET NAMES 'utf8'" );
	}
?>