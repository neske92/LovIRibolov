<?php
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

$lat=$_POST['lat'];
$lon=$_POST['lon'];
$distance=5;
$zastoji=$_POST['zastoji'];
$nezgode=$_POST['nezgode'];
$udesi=$_POST['udesi'];
$pomoci=$_POST['pomoci'];

$distanceinlonmax=(float) ($distance*0.009)+$lon;
$distanceinlonmin=(float) $lon-($distance*0.009);
$distanceinlatmax=(float) ($distance*0.009)+$lat;
$distanceinlatmin=(float) $lat-($distance*0.009);

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

 $sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='zastoj' and status='active' and  
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
	
	$sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='nezgoda' and  status='active' and  ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";

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
	$sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='udes' and status='active' and  ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";
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
	$sql ="SELECT `id`, `description`,`longitude`,`latitude` FROM `object` WHERE type='pomoc' and status='active' and  ACOS(SIN(".$lat."*PI()/180.0)*SIN(latitude*PI()/180.0) + COS(".$lat."*PI()/180.0)*COS(latitude*PI()/180.0)*COS(longitude*PI()/180.0 - ".$lon."*PI()/180.0))*6371 < ".$distance."";

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
	print json_encode($rows);
	flush();
?>