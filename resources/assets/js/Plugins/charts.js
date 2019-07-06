require('chart.js')

/**** Bar Charts: CHARTJS ****/
function barCharts() {
    if ($('.bar-stats').length) {
        $('.bar-stats').each(function () {
            var randomScalingFactor = function () {
                return Math.round(Math.random() * 100)
            };
            var custom_colors = ['#C9625F', '#18A689', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#8085e8', '#91e8e1'];
            var custom_color = custom_colors[Math.floor(Math.random() * custom_colors.length)];
            var barChartData = {
                labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
                datasets: [{
                    backgroundColor: custom_color,
                    borderColor: custom_color,
                    pointBackgroundColor: "#394248",
                    pointBorderColor: "#394248",
                    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                }
                ]
            }
            var ctx = $(this);
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                responsive: true,
                scaleShowLabels: false,
                showScale: true,
                scaleLineColor: "rgba(0,0,0,.1)",
                scaleShowGridLines: false,
            });
        });
    }
}

barCharts()