$(function () {

      /**** Radar Charts: ChartJs ****/
      var radarChartData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [
          {
            label: "My First dataset",
            backgroundColor: "rgba(220,220,220,0.2)",
            borderColor: "rgba(220,220,220,1)",
            pointBackgroundColor: "rgba(220,220,220,1)",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            data: [65,59,90,81,56,55,40]
          },
          {
            label: "My Second dataset",
            backgroundColor: "rgba(49, 157, 181,0.2)",
            borderColor: "#319DB5",
            pointBackgroundColor: "#319DB5",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "#319DB5",
            data: [28,48,40,19,96,27,100]
          }
        ]
      };

      var ctx = document.getElementById("radar-chart").getContext("2d");
      var myRadarChart = new Chart(ctx, {
          type: 'radar',
          data: radarChartData,
          options: {
               scale: {
                  ticks: {
                      display: false
                  },
                  gridLines: {
                    color: 'rgba(0,0,0,0.05)'
                  }
              },
              legend:{
                  display: false
              },
              tooltips : {
                  cornerRadius: 0
              }
          }
      });

      /**** Line Charts: ChartJs ****/
      var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
      var lineChartData = {
        labels : ["January","February","March","April","May","June","July"],
        datasets : [
          {
            label: "My First dataset",
            backgroundColor : "rgba(220,220,220,0.2)",
            borderColor : "rgba(220,220,220,1)",
            pointBackgroundColor : "rgba(220,220,220,1)",
            pointBorderColor : "#fff",
            pointHoverBackgroundColor : "#fff",
            pointHoverBorderColor : "rgba(220,220,220,1)",
            data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
          },
          {
            label: "My Second dataset",
            backgroundColor : "rgba(49, 157, 181,0.2)",
            borderColor : "#319DB5",
            pointBackgroundColor : "#319DB5",
            pointBorderColor : "#fff",
            pointHoverBackgroundColor : "#fff",
            pointHoverBorderColor : "#319DB5",
            data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
          }
        ]
      }
      var ctx = document.getElementById("line-chart").getContext("2d");
      var myLineChart = new Chart(ctx, {
          type: 'line',
          data: lineChartData,
          options: {
               scales : {
                  xAxes : [{
                      gridLines : {
                          color : 'rgba(0,0,0,0.05)'
                      }
                  }],
                  yAxes : [{
                      gridLines : {
                          color : 'rgba(0,0,0,0.05)'
                      }
                  }]
              },
              legend:{
                  display: false
              },
              tooltips : {
                  cornerRadius: 0
              }
          }
      });


      /**** Pie Chart : ChartJs ****/
      var pieData = {
          labels: [
              "Blue",
              "Red",
              "Yellow",
              "Green",
              "Dark Grey"

          ],
          datasets: [
              {
                  data: [300, 40, 100, 40, 120],
                  backgroundColor: [
                      "rgba(54, 173, 199,0.9)",
                      "rgba(201, 98, 95,0.9)",
                      "rgba(255, 200, 112,0.9)",
                      "rgba(100, 200, 112,0.9)",
                      "rgba(97, 103, 116,0.9)"
                  ],
                  hoverBackgroundColor: [
                      "rgba(54, 173, 199,1)",
                      "rgba(201, 98, 95,1)",
                      "rgba(255, 200, 112,1)",
                      "rgba(100, 200, 112,1)",
                      "rgba(97, 103, 116,1)"
                  ]
              }]
      };

      var pieData2 = {
          labels: [
              "Green",
              "Yellow",
              "Blue",
              "Red",
              "Dark Grey"

          ],
          datasets: [
              {
                  data: [80, 120, 80, 60, 60],
                  backgroundColor: [
                      "rgba(27, 184, 152,0.9)",
                      "rgba(255, 200, 112,0.9)",
                      "rgba(54, 173, 199,0.9)",
                      "rgba(201, 98, 95,0.9)",
                      "rgba(97, 103, 116,0.9)"
                  ],
                  hoverBackgroundColor: [
                      "rgba(27, 184, 152,1)",
                      "rgba(255, 200, 112,1)",
                      "rgba(54, 173, 199,1)",
                      "rgba(201, 98, 95,1)",
                      "rgba(97, 103, 116,1)"
                  ]
              }]
      };

      var ctx = document.getElementById("pie-chart").getContext("2d");
        var myPieChart = new Chart(ctx,{
          type: 'pie',
          data: pieData,
          options: {
            legend:{
                display: false
            },
          }
      });

      var ctx = document.getElementById("pie-chart2").getContext("2d");
        var myPieChart2 = new Chart(ctx,{
          type: 'pie',
          data: pieData2,
          options: {
            legend:{
                display: false
            },
          }
      });
    
      /**** Polar Chart : ChartJs ****/
      var polarData = {
          datasets: [{
              data: [80,120,80,60,60],
              backgroundColor: [
                  "rgba(27, 184, 152,0.9)",
                  "rgba(255, 200, 112,0.9)",
                  "rgba(54, 173, 199,0.9)",
                  "rgba(201, 98, 95,0.9)",
                  "rgba(97, 103, 116,0.9)"
              ],
              hoverBackgroundColor: [
                  "rgba(27, 184, 152,1)",
                  "rgba(255, 200, 112,1)",
                  "rgba(54, 173, 199,1)",
                  "rgba(201, 98, 95,1)",
                  "rgba(97, 103, 116,1)"
              ]
          }],
          labels: [
              "Green",
              "Yellow",
              "Blue",
              "Red",
              "Dark Grey"
          ]
      };
      var polarData2 = {
          datasets: [{
              data: [300,40,100,50,120],
              backgroundColor: [
                  "rgba(54, 173, 199,0.9)",
                  "rgba(201, 98, 95,0.9)",
                  "rgba(255, 200, 112,0.9)",
                  "rgba(27, 184, 152,0.9)",
                  "rgba(97, 103, 116,0.9)"
              ],
              hoverBackgroundColor: [
                  "rgba(54, 173, 199,1)",
                  "rgba(201, 98, 95,1)",
                  "rgba(255, 200, 112,1)",
                  "rgba(27, 184, 152,1)",
                  "rgba(97, 103, 116,1)"
              ]
          }],
          labels: [
              "Blue",
              "Red",
              "Yellow",
              "Green",
              "Dark Grey"
          ]
      };

      var ctx = document.getElementById("polar-chart").getContext("2d");
      var myPolarChart = new Chart(ctx, {
          data: polarData,
          type: 'polarArea',
          options: {
            legend:{
                display: false
            },
          }
      });
  
      var ctx = document.getElementById("polar-chart2").getContext("2d");
      var myPolarChart = new Chart(ctx, {
          data: polarData2,
          type: 'polarArea',
          options: {
            legend:{
                display: false
            },
          }
      });
    

});