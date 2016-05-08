<?php
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

$objectId=$_POST['objectId'];

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

$sql ="DELETE FROM object WHERE id = ". $objectId ."";
$aQResult = mysql_query( $sql, $voidsoft_traffic );
if (!$aQResult) {
	echo "Faild to delete object. Error desc: " . mysql_error();
    exit();
}
else
    echo 'true';
?>