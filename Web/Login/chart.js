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