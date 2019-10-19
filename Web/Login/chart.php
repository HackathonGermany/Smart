<!DOCTYPE html>
<html>
  <head>
    <title>ChartJS - LineGraph</title>
    <style>
      .chart-container {
        width: 640px;
        height: auto;
      }
    </style>
  </head>
  <body>
  test
    <div class="chart-container">
      <canvas id="mycanvas"></canvas>
    </div>
    
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/Chart.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
  $.ajax({
    url : "http://192.168.1.179/Login/data.php",
    type : "GET",
    success : function(data){
      console.log(data);

      var time = [];
      var temp = [];

      for(var i in data) {
        time.push("Time " + data[i].time);
        temp.push(data[i].temp);
      }

      var chartdata = {
        labels: time,
        datasets: [
          {
            label: "temp",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(59, 89, 152, 0.75)",
            borderColor: "rgba(59, 89, 152, 1)",
            pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
            pointHoverBorderColor: "rgba(59, 89, 152, 1)",
            data: facebook_follower
          },
        ]
      };

      var ctx = $("#mycanvas");

      var LineGraph = new Chart(ctx, {
        type: 'line',
        data: chartdata
      });
    },
    error : function(data) {

    }
  });
});

    </script>
  </body>
</html>
