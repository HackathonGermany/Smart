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
    <div id="chart-container">
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

                    for (var i in data) {
                        test = 0;
                        //test = new Date(data[i].time * 1000).format('h:i:s');
                        time.push(test);                        
                        temperatur.push(data[i].temperatur);
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