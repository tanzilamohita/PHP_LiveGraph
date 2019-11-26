<?php

/*
# =============================================================
# Live Graph
# =============================================================
# create date:2019/11/14     writen By Islam Tanzila
# modify date:2019/11/19
# =============================================================
*/

$rows = array();
$table = array();

// create table columns
$table['cols'] = array(
 array(
  'label' => 'Time',
  'type' => 'datetime'
 ),
 array(
  'label' => 'Temperature (°C)',
  'type' => 'number'
 )
);

// read csv file 
//$csvFile = file('http://hmrc.jp.net/CPUA2004B/HA197Q0001/data/2019/1114/2019114.csv');
$csvFile = file('data.csv');
// keep csv data in an array
$data = [];
foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
}
foreach ($data as $key => $value) {
  $sub_array = array();
// Returns date formatted according to given format
  $date = new DateTime($value[0]);
  $time = new DateTime($value[1]);
  $datetime = new DateTime($date->format('Y-m-d') .' ' .$time->format('H:i:s'));
  $datetime = $datetime->format('Y-m-d H:i:s');
  // converting an English textual date-time description to a UNIX timestamp
  $datetime = strtotime($datetime);
  $sub_array[] =  array("v" => 'Date('.$datetime. '000)');
  $temperature = $value[27]/1000;
  $sub_array[] =  array("v" => $temperature);
  $rows[] =  array("c" => $sub_array);
}
//print_a($rows);

$table['rows'] = $rows;

// return a json encoded string
$jsonTable = json_encode($table);

//print_a($jsonTable);

function print_a($array){
  echo "<div style='text-align:left;'>";
    echo "<pre>";
      print_r($array);
    echo "</pre>";
  echo "</div>";
}

?>


<html>
 <head>
    <meta charset="utf-8">
    <meta name="keyword" content="炎重工株式会社">
    <meta name="description" content="炎重工株式会社">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link href="http://hmrc.jp.net/css/sanitize.css" rel="stylesheet" media="all">
    <link href="http://hmrc.jp.net/css/layout.css" rel="stylesheet" media="all">
    <link href="http://hmrc.jp.net/css/tb.css" rel="stylesheet" media="screen and (max-width: 812px)">
    <link href="http://hmrc.jp.net/css/sp.css" rel="stylesheet" media="screen and (max-width: 420px)">
    <title>炎重工株式会社</title>
  <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  -->
  <!-- load libraries -->
  <script type="text/javascript" src="loader.js"></script>
  <script type="text/javascript" src="jquery.min.js"></script>
  <script type="text/javascript">
  // loading latest official release of Google Visualization API with the corechart package
   google.charts.load('current', {'packages':['corechart']});
   // Set a callback to run when the Google Visualization API is loaded.
   google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table from the json data, 
  // instantiates the line chart, passes in the data and draw it.
  function drawChart()
   {
    // Create the data table
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
    // Set chart options
    var options = {
      hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Temperature'
        },
     
     chartArea:{width:'70%', height:'75%'}
    };
    // json = JSON.parse(data);
    // window.alert(JSON.stringify(json));

    // Instantiate and draw our line chart, passing in some options.
    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
    chart.draw(data, options);

   }
  </script>

  <!-- set interval for live graph -->
  <script type="text/javascript" src="jQuery.js"></script>
        <script type="text/javascript">

                $(document).ready(function(){
                    // First load the chart once 
                    drawChart();
                    // Set interval to call the drawChart again
                    setInterval(drawChart, 1000);
                    });
        </script>
  <style>
  .page-wrapper{
	   width:1000px;
	   margin:0 auto;
  }

  .btn {
	  background-color: DodgerBlue;
	  border: none;
	  color: white;
	  padding: 12px 30px;
	  cursor: pointer;
	  font-size: 20px;
	  float:right;
	}

	.buttondiv {
	    margin-top: 20px;
	  	margin-left: 20px;
	  	margin-right: 20px;
	    position: relative;
	    overflow: auto;
	    
	}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
  </style>
 </head>
 <body onload="createImageLayer();">
    <div id="wrapper">
      <header id="header">
        <div id="siteLogo"><img src="http://hmrc.jp.net/images/logo.svg" art="炎重工株式会社"></div>
        <div id="headerButton"><a href="http://hmrc.jp.net/Graph/logout.php">ログアウト</a></div>
      </header>
      <!-- <span id="info">-</span> -->
      <div class="buttondiv">
      	<a href="http://hmrc.jp.net/Graph/data.csv">
      		<button class="btn">Download CSV File</button>
      	</a>
      </div>
    </div>
  <!--Div will hold the line chart-->
  <div class="page-wrapper">
   <br />
   <h2 align="center">Display CPU Temperature</h2>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>
