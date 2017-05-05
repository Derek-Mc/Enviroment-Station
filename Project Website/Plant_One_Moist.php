<html>
	<head><title>ErgoAgri - Platform 1 - Moisture</title>
	</head>
	<body>
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
				$dateList = $dates;
				mysqli_free_result($result);
			}
			mysqli_close($conn);

			for($counter=$entries[0];$counter>0;$counter--)
			{
				if($dates[$counter])
				{
					if($counter!=0){
					$moist_list .= $dates[$counter];}
					else{
					$moist_list = $dates[$counter];}
					$moist_list .= "   -   ";
					$moist_list .= $moists[$counter];
					$moist_list .= "%<br>";
				}
			}
		?>
		<h1>Moisture Levels for Plant 1</h1>
		<a href="../Plant_One.php">Back to Overview</a>
		<p>
				<script type="text/javascript">
			var datesList = <?php echo json_encode($dateList);?>;
			var moistsList = <?php echo json_encode($moists);?>;
		</script>
		<link type="text/css" rel="stylesheet" href="./Rickshaw/rickshaw.min.css">
		<script src="./Rickshaw/vendor/d3.min.js"></script>
		<script src="./Rickshaw/vendor/d3.layout.min.js"></script>
		<script src="./Rickshaw/rickshaw.min.js"></script>

		<style>
		#chart_container {
				position: relative;
				font-family: Arial, Helvetica, sans-serif;
		}
		#chart {
				position: relative;
				left: 40px;
		}
		#y_axis {
				position: absolute;
				top: 0;
				bottom: 0;
				width: 40px;
		}
		</style>

		<div id="chart_container">
				<div id="y_axis"></div>
				<div id="chart"></div>
		</div>

		<script type="text/javascript">
		var graph = new Rickshaw.Graph( {
			element: document.querySelector("#chart"),
			width: 800,
			height: 400,
			renderer: 'line',
			interpolation: 'linear',
			series: [ {
				data:  [{x: getDatePoint(0), y: getMoist(0)},{x: getDatePoint(1), y: getMoist(1)},{x: getDatePoint(2), y: getMoist(2)},{x: getDatePoint(3), y: getMoist(3)},{x: getDatePoint(4), y: getMoist(4)},{x: getDatePoint(5), y: getMoist(5)},{x: getDatePoint(6), y: getMoist(6)},{x: getDatePoint(7), y: getMoist(7)},{x: getDatePoint(8), y: getMoist(8)},{x: getDatePoint(9), y: getMoist(9)},{x: getDatePoint(10), y: getMoist(10)},{x: getDatePoint(11), y: getMoist(11)},{x: getDatePoint(12), y: getMoist(12)},{x: getDatePoint(13), y: getMoist(13)},{x: getDatePoint(14), y: getMoist(14)},{x: getDatePoint(15), y: getMoist(15)},{x: getDatePoint(16), y: getMoist(16)},{x: getDatePoint(17), y: getMoist(17)},{x: getDatePoint(18), y: getMoist(18)},{x: getDatePoint(19), y: getMoist(19)},{x: getDatePoint(20), y: getMoist(20)},{x: getDatePoint(21), y: getMoist(21)},{x: getDatePoint(22), y: getMoist(22)},{x: getDatePoint(23), y: getMoist(23)}],
				color: "steelblue",
				name: "Moisture"
			} ]
		} );


		var y_axis = new Rickshaw.Graph.Axis.Y( {
			graph: graph,
			orientation: "left",
			tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
			element: document.getElementById("y_axis")
			} );
		
		
		var hoverDetail = new Rickshaw.Graph.HoverDetail( {
			graph: graph,
			xFormatter: function(x) {
			return new Date(x * 1000).toString();
			}
		} );

		graph.render();
	
		function getDatePoint(count)
		{
			return parseInt(getDate(datesList[(datesList.length)-24+count]));
		}
		
		function getMoist(count)
		{
			return parseFloat(moistsList[moistsList.length-24+count]);
		}
		
		function getDate(datestring)
		{
			var parts = datestring.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/);
			return parseInt((Date.UTC(+parts[1], +parts[2]-1, +parts[3], +parts[4], +parts[5], +parts[6]))/1000);
		}
		</script>
		</p>
		<p><?php echo $moist_list ?></p>
	</body>
</html>
