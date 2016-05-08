<?php
	header('Access-Control-Allow-Origin: *');  
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

	$username=$_POST['username'];
	$password=$_POST['password'];

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

	$sql ="SELECT password FROM users WHERE username='".$username."'";
	$aQResult = mysql_query($sql, $voidsoft_traffic);
	if (!$aQResult) {
		echo "Faild to execute query. Error desc: " . mysql_error();
		exit();
	}

	$data=mysql_fetch_assoc($aQResult);
        if (!$data) {
           echo "Failed on fatching data.";
           exit();
        }

        if ($data['password'] == "") {
           echo "No data found.";
           exit();
        }

	$tmp= $data['password'];
	if( $password==$tmp)
		echo 'true';
	else
		echo 'false';
?>
