<?php
/* array for JSON response */
$response = array();

/* CONNECTION SETTINGS */
$DB_HOST = "mysql.hostinger.co.uk";
$DB_UNAME = "u551669906_admin";
$DB_PWD = "Kalamadea";
$DB_DATABASE = "u551669906_ergo";

/* Connecting to mysql database */
$mysqli = new mysqli($DB_HOST, $DB_UNAME, $DB_PWD, $DB_DATABASE);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//$username = $_GET['username'];
//$username = $_POST['username'];

/* CONSTRUCT THE QUERY change Drone to user database*/
$query="SELECT Temperature, Humidity, Light, Moisture FROM DATA Where plant = '1' ORDER BY Date DESC LIMIT 24;";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

if ($result === false)  {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else  {

    $response["stuff"] = array();

    while($row = $result->fetch_assoc())    {

        $stuff= array();

        /* ADD THE TABLE COLUMNS TO THE JSON OBJECT CONTENTS if it doesnt work, reverse stuff/row values*/
		$stuff["temp"] = $row['Temperature'];
		$stuff["light"] = $row['Light'];
        $stuff["humid"] = $row['Humidity'];
        $stuff["moist"] = $row['Moisture'];

        array_push($response["stuff"], $stuff);

        // $response[] = $row;
    }
    // success
    $response["success"] = 1;
    echo(json_encode($response));
}

/* CLOSE THE CONNECTION */
mysqli_close($mysqli);
?>		
