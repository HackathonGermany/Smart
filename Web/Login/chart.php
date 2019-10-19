<!DOCTYPE html>
<html>
<head>
<title>Creating Dynamic Data Graph using PHP and Chart.js</title>
<style type="text/css">
BODY {
    width: 550PX;
}

#chart-container {
    width: 100%;
    height: auto;
}
</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/Chart.min.js"></script>


</head>
<body>
    <div id="chart-container" sytle="display: flex; justify-content: center;">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("data.php",
                function (data)
                {
                    console.log(data);
                     var time = [];
                    var temperatur = [];

                    if ($_GET["plot"] == "Strom") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].Strom);
                        }
                    } elseif ($_GET["plot"] == "Spannung") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].Spannung);
                        }
                    } elseif ($_GET["plot"] == "Watt") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].Watt);
                        }
                    } elseif ($_GET["plot"] == "lichtstaerke") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].lichtstaerke);
                        }
                    } elseif ($_GET["plot"] == "temperatur") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].temperatur);
                        }
                    } elseif ($_GET["plot"] == "luftfeuchtigkeit") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].luftfeuchtigkeit);
                        }
                    } elseif ($_GET["plot"] == "status") {
                        for (var i in data) {
                            time.push(data[i].datum);                        
                            temperatur.push(data[i].status);
                        }
                    }

                    var chartdata = {
                        labels: time,
                        datasets: [
                            {
                                label: 'Temperatur',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: temperatur
                            }
                        ]
                    };

                    var option = {
                      layout: {
                        margin: {
                          left: 0,
                          right: 1,
                          top: 1,
                          bottom: 1
                        }
                      }
                    }

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata
                    });
                });
            }
        }
        </script>

</body>
</html>