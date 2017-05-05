<?php
	$servername="mysql.hostinger.co.uk";
	$username="u551669906_admin";
	$password="Kalamadea";
	$dbname="u551669906_ergo";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	$Temperature = $_GET['Temperature'];
	$Humidity = $_GET['Humidity'];
	$Light = $_GET['Light'];
	$Moisture = $_GET['Moisture'];
	$date= date('Y-m-d H:i:s');
	
	$sql = "INSERT INTO DATA (Plant, Date, Temperature, Humidity, Light, Moisture)
	VALUES (1,NOW(), $Temperature, $Humidity, $Light, $Moisture)";
	/*
		if connection above doesn't work
		$conn =mysqli_connect($servername, $username, $password, $dbname);
		if (mysqli_query($conn,$sql)
		{
			echo "New record created successfully";
		}
		else 
		{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	*/
	if ($conn->query($sql) === TRUE)
	{
		echo "New record created successfully";
	} 
	else 
	{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>
