<html>
	<head><title>Welcome to Your ErgoAgri!</title>
	</head>
	<body>
		<h1>Your ErgoAgri</h1>
		<h2>Welcome to your ErgoAgri Web Interface, your one-stop monitoring station for all of your ErgoAgri monitoring stations!</h2>
		<br/>
		<br/>
		<h3>Your Platforms</h3>
		<p><a href="./Plant_One.php">Platform 1</a></p>
		<h3>Notifications</h3>
		<p><b>Platform 1:</b>
		<?php
			$servername="mysql.hostinger.co.uk";
			$username="u551669906_admin";
			$password="Kalamadea";
			$dbname="u551669906_ergo";
			$query="SELECT Date,Moisture FROM `DATA` WHERE Plant=1 ORDER by Date";
			$indicies="SELECT COUNT(*) FROM `DATA` WHERE Plant=1 ";
			$dates=array();
			$moists=array();
			$counter = 0;
			
			$conn=new mysqli($servername,$username,$password,$dbname);
			if(mysqli_connect_errno($con)){
			die("Connection Failed: " . mysqli_connect_error);
			}
			$counts=mysqli_query($conn,$indicies) or die(mysql_error());
			$entries=mysqli_fetch_row($counts);
			if($result=mysqli_query($conn,$query))
			{
				while($row=mysqli_fetch_array($result))
				{
					$dates[]=$row['Date'];
					$moists[]=$row['Moisture'];
				}
				mysqli_free_result($result);
			}
			mysqli_close($conn);
			
			if(end($moists)<=70)
			{
				echo "<font color='red'>Recently needed watering (below 70% moisture)!</font></p>";
			}
			else
			{
				echo "<font color='green'>Moisture levels OK!</font></p>";
			}
		?>
	</body>
</html>