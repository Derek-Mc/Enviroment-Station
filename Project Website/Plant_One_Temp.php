<html>
	<head><title>ErgoAgri - Platform 1 - Temperature</title>
	</head>
	<body>
		<?php
			$servername="mysql.hostinger.co.uk";
			$username="u551669906_admin";
			$password="Kalamadea";
			$dbname="u551669906_ergo";
			$query="SELECT Date,Temperature FROM `DATA` WHERE Plant=1 ORDER by Date";
			$indicies="SELECT COUNT(*) FROM `DATA` WHERE Plant=1 ";
			$dates=array();
			$temps=array();
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
					$temps[]=$row['Temperature'];
				}
				$dateList = $dates;
				mysqli_free_result($result);
			}
			mysqli_close($conn);

			for($counter=$entries[0];$counter>0;$counter--)
			{
				if($dates[$counter])
				{
					if($counter!=$entries[0]){
					$temp_list .= $dates[$counter];}
					else{
					$temp_list = $dates[$counter];}
					$temp_list .= "   -   ";
					$temp_list .= $temps[$counter];
					$temp_list .= "&deg";
					$temp_list .="C";
					$temp_list .= "<br>";
				}
			}
		?>
		<h1>Temperature for Plant 1</h1>
		<a href="../Plant_One.php">Back to Overview</a>
		<p>
		<script type="text/javascript">
			var datesList = <?php echo json_encode($dateList);?>;
			var tempsList = <?php echo json_encode($temps);?>;
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
			width: 900,
			height: 400,
			renderer: 'line',
			interpolation: 'linear',
			series: [ {
				data:  [{x: getDatePoint(0), y: getTemp(0)},{x: getDatePoint(1), y: getTemp(1)},{x: getDatePoint(2), y: getTemp(2)},{x: getDatePoint(3), y: getTemp(3)},{x: getDatePoint(4), y: getTemp(4)},{x: getDatePoint(5), y: getTemp(5)},{x: getDatePoint(6), y: getTemp(6)},{x: getDatePoint(7), y: getTemp(7)},{x: getDatePoint(8), y: getTemp(8)},{x: getDatePoint(9), y: getTemp(9)},{x: getDatePoint(10), y: getTemp(10)},{x: getDatePoint(11), y: getTemp(11)},{x: getDatePoint(12), y: getTemp(12)},{x: getDatePoint(13), y: getTemp(13)},{x: getDatePoint(14), y: getTemp(14)},{x: getDatePoint(15), y: getTemp(15)},{x: getDatePoint(16), y: getTemp(16)},{x: getDatePoint(17), y: getTemp(17)},{x: getDatePoint(18), y: getTemp(18)},{x: getDatePoint(19), y: getTemp(19)},{x: getDatePoint(20), y: getTemp(20)},{x: getDatePoint(21), y: getTemp(21)},{x: getDatePoint(22), y: getTemp(22)},{x: getDatePoint(23), y: getTemp(23)}],
				color: "steelblue",
				name: "Temperature"
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
		
		function getTemp(count)
		{
			return parseFloat(tempsList[tempsList.length-24+count]);
		}
		
		function getDate(datestring)
		{
			var parts = datestring.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/);
			return parseInt((Date.UTC(+parts[1], +parts[2]-1, +parts[3], +parts[4], +parts[5], +parts[6]))/1000);
		}
		</script>


		</p>
		<p><?php echo $temp_list ?></p>
	</body>
</html>
