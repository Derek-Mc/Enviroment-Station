<html>
	<head><title>ErgoAgri - Platform 1 - Light Levels</title>
	</head>
	<body>
		<?php
			$servername="mysql.hostinger.co.uk";
			$username="u551669906_admin";
			$password="Kalamadea";
			$dbname="u551669906_ergo";
			$query="SELECT Date,Light FROM `DATA` WHERE Plant=1 ORDER by Date";
			$indicies="SELECT COUNT(*) FROM `DATA` WHERE Plant=1 ";
			$dates=array();
			$lights=array();
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
					$lights[]=$row['Light'];
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
					$light_list .= $dates[$counter];}
					else{
					$light_list = $dates[$counter];}
					$light_list .= "   -   ";
					$light_list .= $lights[$counter];
					$light_list .= " lux<br>";
				}
			}
		?>
		<h1>Light Levels for Plant 1</h1>
		<a href="../Plant_One.php">Back to Overview</a>
		<p>
				<script type="text/javascript">
			var datesList = <?php echo json_encode($dateList);?>;
			var lightsList = <?php echo json_encode($lights);?>;
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
				data:  [{x: getDatePoint(0), y: getLight(0)},{x: getDatePoint(1), y: getLight(1)},{x: getDatePoint(2), y: getLight(2)},{x: getDatePoint(3), y: getLight(3)},{x: getDatePoint(4), y: getLight(4)},{x: getDatePoint(5), y: getLight(5)},{x: getDatePoint(6), y: getLight(6)},{x: getDatePoint(7), y: getLight(7)},{x: getDatePoint(8), y: getLight(8)},{x: getDatePoint(9), y: getLight(9)},{x: getDatePoint(10), y: getLight(10)},{x: getDatePoint(11), y: getLight(11)},{x: getDatePoint(12), y: getLight(12)},{x: getDatePoint(13), y: getLight(13)},{x: getDatePoint(14), y: getLight(14)},{x: getDatePoint(15), y: getLight(15)},{x: getDatePoint(16), y: getLight(16)},{x: getDatePoint(17), y: getLight(17)},{x: getDatePoint(18), y: getLight(18)},{x: getDatePoint(19), y: getLight(19)},{x: getDatePoint(20), y: getLight(20)},{x: getDatePoint(21), y: getLight(21)},{x: getDatePoint(22), y: getLight(22)},{x: getDatePoint(23), y: getLight(23)}],
				color: "steelblue",
				name: "Light Level"
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
		
		var x_axis = new Rickshaw.Graph.Axis.X({
			graph: graph,
			pixelsPerTick: 175,
			tickFormat: function(x)
			{
				return stringer = new Date(x*1000).toLocaleString()
			}
		})
		x_axis.render();


		graph.render();
	
		function getDatePoint(count)
		{
			return parseInt(getDate(datesList[(datesList.length)-24+count]));
		}
		
		function getLight(count)
		{
			return parseFloat(lightsList[lightsList.length-24+count]);
		}
		
		function getDate(datestring)
		{
			var parts = datestring.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/);
			return parseInt((Date.UTC(+parts[1], +parts[2]-1, +parts[3], +parts[4], +parts[5], +parts[6]))/1000);
		}
		</script>
		</p>
		<p><?php echo $light_list ?></p>
	</body>
</html>
