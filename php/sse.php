<?php
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

$lat_param = $_GET['lat'];
$lon_param = $_GET['lon'];
$distance_param = 5;
$zastoji_param = $_GET['zastoji'];
$nezgode_param = $_GET['nezgode'];
$udesi_param = $_GET['udesi'];
$pomoci_param  =$_GET['pomoci'];
$intervale_param = 5000; //miliseconds

function sendNewObjects($lat, $lon, $zastoji, $nezgode, $udesi, $pomoci, $distance, $intervale) {

$st = strtotime('now') + 3600;
$time = new DateTime("@$st");
$time = $time->modify("-5 second");
$time = date_format($time, 'Y-m-d H:i:s');



$voidsoft_traffic = mysql_connect("localhost","voidsoft_damjan","PetrovoSelo");
if (!voidsoft_traffic)
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$db_selected = mysql_select_db('voidsoft_traffic', $voidsoft_traffic);
if (!$db_selected)
{
  echo "Failed to select data base: ". mysql_error();
  exit();
}

$rows = array();
$row1 = array();
$row2 = array();
$row3 = array();
$row4 = array();

if($zastoji==1)
{

 $sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='zastoj' and status='active' and add_time >= '". $time ."' and
 ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";

	$aQResult = mysql_query($sql,$voidsoft_traffic);
	if (!$aQResult) {
		printf("Error: %s\n", mysqli_error("neka greska"));
		exit();
	}
	while($row =  mysql_fetch_array($aQResult)) 
	{
			$row1[] = array( "id"=>$row['id'],
			"type"=>'zastoj',
			"description"=>$row['description'],
			"longitude"=>$row['longitude'],
			"latitude"=>$row['latitude']
			);
	}
}

if($nezgode==1)
{
	
	$sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='nezgoda' and  status='active' and   add_time >= '". $time ."' and ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";

	$aQResult = mysql_query($sql,$voidsoft_traffic);
	if (!$aQResult) {
		printf("Error: %s\n", mysqli_error("neka greska"));
		exit();
	}
	while($row =  mysql_fetch_array($aQResult)) 
	{
			$row2[] = array( "id"=>$row['id'],
			"type"=>'nezgoda',
			"description"=>$row['description'],
			"longitude"=>$row['longitude'],
			"latitude"=>$row['latitude']
			);
	}
}

if($udesi==1)
{
	$sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='udes' and status='active' and  add_time >= '". $time ."' and ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";
	$aQResult = mysql_query($sql,$voidsoft_traffic);
	if (!$aQResult) {
		printf("Error: %s\n", mysqli_error("neka greska"));
		exit();
	}
	while($row =  mysql_fetch_array($aQResult)) 
	{
			$row3[] = array( "id"=>$row['id'],
			"type"=>'udes',
			"description"=>$row['description'],
			"longitude"=>$row['longitude'],
			"latitude"=>$row['latitude']
			);
	}
}

if($pomoci==1)
{
	$sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='pomoc' and status='active' and add_time >= '". $time ."' and ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";

	$aQResult = mysql_query($sql,$voidsoft_traffic);
	if (!$aQResult) {
		printf("Error: %s\n", mysqli_error("neka greska"));
		exit();
	}
	while($row =  mysql_fetch_array($aQResult)) 
	{
			$row4[] = array( "id"=>$row['id'],
			"type"=>'pomoc',
			"description"=>$row['description'],
			"longitude"=>$row['longitude'],
			"latitude"=>$row['latitude']
			);
	}
}

$rows=array_merge($row1,$row2,$row3,$row4);
  echo "retry: " . $intervale . PHP_EOL; 
  echo "data:" . json_encode($rows) . PHP_EOL;
  echo PHP_EOL; 
  flush();
}
 
sendNewObjects($lat_param, $lon_param, $zastoji_param, $nezgode_param, $udesi_param, $pomoci_param, $distance_param, $intervale_param);

?>