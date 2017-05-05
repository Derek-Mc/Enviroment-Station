<?php
			echo "i got here<br>";
			$servername="mysql.hostinger.co.uk";
			$username="u551669906_admin";
			$password="Kalamadea";
			$dbname="u551669906_ergo";
			$date_get="SELECT TO_CHAR(Date) FROM `DATA` WHERE Plant=1 ORDER by Date";
			$temp_get="SELECT Temperature FROM `DATA` WHERE Plant=1 ORDER by Date";
			$hum_get="SELECT Humidity FROM `DATA` WHERE Plant=1 ORDER by Date";
			$light_get="SELECT Light FROM `DATA` WHERE Plant=1 ORDER by Date";
			$moist_get="SELECT Moisture FROM `DATA` WHERE Plant=1 ORDER by Date";
			$query="SELECT Date,Temperature,Humidity,Light,Moisture FROM `DATA` WHERE Plant=1 ORDER by Date";
			$indicies="SELECT COUNT(*) FROM `DATA` WHERE Plant=1 ";
			$dates=array();
			$temps=array();
			$hums=array();
			$lights=array();
			$moists=array();
//			$queries = array($date_get,$temp_get,$hum_get,$light_get,$moist_get);
//			$arrays= array($dates,$temps,$hums,$lights,$moists);
			$counter = 0;
			
			$conn=new mysqli($servername,$username,$password,$dbname);
			if(mysqli_connect_errno($con)){
			die("Connection Failed: " . mysqli_connect_error);
			}
			echo "I connected<br>";
			$counts=mysqli_query($conn,$indicies) or die(mysql_error());
			$thing=$counts->fetch_row();

				if($result=mysqli_query($conn,$query))
				{
					while($row=mysqli_fetch_array($result))
					{
						$dates[]=$row['Date'];
						$temps[]=$row['Temperature'];
						$hums[]=$row['Humidity'];
						$lights[]=$row['Light'];
						$moists[]=$row['Moisture'];
						}
					
					mysqli_free_result($result);
				}
				
			mysqli_close($conn);
			echo "Connection closed<br>";
			echo $thing[0];
			echo "<br>";
			echo $temps[0];
			echo "<br>";
			$temp_no=count($temps);
			$date_no=count($dates);

			for($counter=0;$counter<$date_no;$counter++)
			{
				echo $dates[$counter];
				echo "<br>";
			}
			echo "<br>";

			for($counter=0;$counter<$entries[0];$counter++)
			{
				$temp_list = $dates[$counter] + '   -   ' + $temps[$counter] + '\n';
			}
			echo "$temp_list";
		?>