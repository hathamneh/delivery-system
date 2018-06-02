$(function () {

    /**** FINANCIAL CHARTS: HIGHSTOCK ****/
    function financialCharts(){

          var seriesOptions = [],
          seriesCounter = 0,
          names = ['MSFT', 'AAPL', 'GOOG'],
          // create the chart when all data is loaded
          createChart = function () {

              $('#financial-chart').highcharts('StockChart', {
                  chart: {
                    height:300,
                    borderColor: '#C9625F',
                    backgroundColor: 'transparent'
                  },
                  rangeSelector : {
                      selected : 1,
                      inputEnabled: $('#container').width() > 480
                  },
                  colors: ['#18A689', '#f7a35c', '#8085e9', '#f15c80', '#91e8e1'],
                  credits: {
                    enabled: false
                  },
                  exporting: {
                      enabled: false
                  },
                  scrollbar: {
                    enabled: false
                  },
                  navigator: {
                      enabled: false
                  },
                  xAxis: {
                      lineColor:'#e1e1e1',
                      tickColor:'#EFEFEF',
                  },
                  yAxis: {
                      gridLineColor:'#e1e1e1',
                      labels: {
                          formatter: function () {
                              return (this.value > 0 ? ' + ' : '') + this.value + '%';
                          }
                      },
                      plotLines: [{
                          value: 0,
                          width: 2,
                          color: 'silver'
                      }]
                  },
                  plotOptions: {
                      series: {
                          compare: 'percent'
                      }
                  },
                  tooltip: {
                      pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
                      valueDecimals: 2
                  },

                  series: seriesOptions
              });
          };

      $.each(names, function (i, name) {

          $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=' + name.toLowerCase() + '-c.json&callback=?',    function (data) {

              seriesOptions[i] = {
                  name: name,
                  data: data
              };
              seriesCounter += 1;

              if (seriesCounter === names.length) {
                  createChart();
              }
          });
      });
    }
    financialCharts();

    /**** Candle Chart: HighStock ****/
    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?a=e&filename=aapl-ohlc.json&callback=?', function (data) {
        // create the chart
        $('#candle-chart').highcharts('StockChart', {
            chart: {
                height:300,
                borderColor: '#C9625F',
                backgroundColor: 'transparent'
            },
            rangeSelector : {
                selected : 1,
                inputEnabled: $('#container').width() > 480
            },
            colors: ['#18A689', '#f7a35c', '#8085e9', '#f15c80', '#91e8e1'],
            credits: {
              enabled: false
            },
            exporting: {
                enabled: false
            },
            scrollbar: {
              enabled: false
            },
            navigator: {
                enabled: false
            },
            xAxis: {
                lineColor:'#e1e1e1',
                tickColor:'#EFEFEF',
            },
            yAxis: {
                gridLineColor:'#e1e1e1',
                labels: {
                    formatter: function () {
                        return (this.value > 0 ? ' + ' : '') + this.value + '%';
                    }
                },
                plotLines: [{
                    value: 0,
                    width: 2,
                    color: 'silver'
                }]
            },
            plotOptions: {
                candlestick: {
                    color: '#319DB5',
                    upColor: '#f15c80',
                    lineColor: '#ededed'
                }
            },
            series : [{
                type : 'candlestick',
                name : 'AAPL Stock Price',
                data : data,
                dataGrouping : {
                    units : [
                        [
                            'week', // unit name
                            [1] // allowed multiples
                        ], [
                            'month',
                            [1, 2, 3, 4, 6]
                        ]
                    ]
                }
            }]
        });
    });

    /**** OHLC Chart: HighStock ****/
    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-ohlc.json&callback=?', function (data) {

        // create the chart
        $('#ohlc-chart').highcharts('StockChart', {
            chart: {
                height:300,
                borderColor: '#C9625F',
                backgroundColor: 'transparent'
            },
            rangeSelector : {
                inputEnabled: false,
                selected : 2
            },
            credits: {
              enabled: false
            },
            exporting: {
                enabled: false
            },
            scrollbar: {
              enabled: false
            },
            navigator: {
                enabled: false
            },
            colors: ['rgba(241,92,128,0.7)'],
            xAxis: {
                lineColor:'#e1e1e1',
                tickColor:'#EFEFEF'
            },
            yAxis: {
                gridLineColor:'#e1e1e1'
            },
            series : [{
                type : 'ohlc',
                name : 'AAPL Stock Price',
                data : data,
                dataGrouping : {
                    units : [[
                        'week', // unit name
                        [1] // allowed multiples
                    ], [
                        'month',
                        [1, 2, 3, 4, 6]
                    ]]
                }
            }]
        });
    });

    /**** Aera Range Chart: HighStock ****/
    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=range.json&callback=?', function (data) {

        $('#arearange-chart').highcharts('StockChart', {
            chart: {
                type: 'arearange',
                height:300,
                backgroundColor: 'transparent'
            },
            rangeSelector : {
                inputEnabled: false,
                selected : 2
            },
            credits: {
              enabled: false
            },
            colors:['rgba(49, 157, 181,0.4)'],
            exporting: {
                enabled: false
            },
            scrollbar: {
              enabled: false
            },
            navigator: {
                enabled: false
            },
            xAxis: {
                lineColor:'#e1e1e1',
                tickColor:'#EFEFEF'
            },
            yAxis: {
                gridLineColor:'#e1e1e1'
            },
            tooltip: {
                valueSuffix: '°C'
            },
            series: [{
                name: 'Temperatures',
                data: data
            }]
        });
    });


    /**** Real Time Chart: HighStock ****/
    $('#realtime-chart').highcharts('StockChart', {
        chart : {
            height:300,
            backgroundColor: 'transparent',
            events : {
                load : function () {

                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            y = Math.round(Math.random() * 100);
                        series.addPoint([x, y], true, true);
                    }, 1000);
                }
            }
        },
        credits: {
          enabled: false
        },
        exporting: {
            enabled: false
        },
        scrollbar: {
          enabled: false
        },
        colors:['rgba(49, 157, 181,0.5)'],
        xAxis: {
            lineColor:'#e1e1e1',
            tickColor:'#EFEFEF'
        },
        yAxis: {
            gridLineColor:'#e1e1e1'
        },
        navigator: {
          outlineColor: '#E4E4E4'
        },
        rangeSelector: {
            buttons: [{
                count: 1,
                type: 'minute',
                text: '1M'
            }, {
                count: 5,
                type: 'minute',
                text: '5M'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: false,
            selected: 0
        },
        exporting: {
            enabled: false
        },
        series : [{
            name : 'Real Time Data',
            data : (function () {
                // generate an array of random data
                var data = [], time = (new Date()).getTime(), i;

                for (i = -999; i <= 0; i += 1) {
                    data.push([
                        time + i * 1000,
                        Math.round(Math.random() * 100)
                    ]);
                }
                return data;
            }())
        }]
    });

    
    /**** Column Chart : HighStock ****/
    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-v.json&callback=?', function (data) {

        // create the chart
        $('#bar-chart').highcharts('StockChart', {
            chart: {
                alignTicks: false,
                height:300,
                borderColor: '#C9625F',
                backgroundColor: 'transparent'
            },
            rangeSelector : {
                inputEnabled: false,
                selected : 1
            },
            credits: {
              enabled: false
            },
            exporting: {
                enabled: false
            },
            scrollbar: {
              enabled: false
            },
            navigator: {
                enabled: false
            },
            colors:['rgba(128, 133, 233,0.8)'],
            xAxis: {
                lineColor:'#e1e1e1',
                tickColor:'#EFEFEF'
            },
            yAxis: {
                gridLineColor:'#e1e1e1'
            },
            series: [{
                type: 'column',
                name: 'AAPL Stock Volume',
                data: data,
                dataGrouping: {
                    units: [[
                        'week', // unit name
                        [1] // allowed multiples
                    ], [
                        'month',
                        [1, 2, 3, 4, 6]
                    ]]
                }
            }]
        });
    });

    /**** Export Tools Example: HighStock ****/
    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=usdeur.json&callback=?', function (data) {

        // Create the chart
        $('#export-tools-chart').highcharts('StockChart', {
            chart: {
                height:300,
                borderColor: '#C9625F',
                backgroundColor: 'transparent'
            },
            rangeSelector : {
                inputEnabled: false,
                selected : 1
            },
            yAxis : {
                title : {
                    text : 'Exchange rate'
                }
            },
            credits: {
                enabled: false
            },
            navigator: {
                enabled: false
            },
            scrollbar: {
              enabled: false
            },
            colors:['rgba(128, 133, 233,0.8)'],
            xAxis: {
                lineColor:'#e1e1e1',
                tickColor:'#EFEFEF'
            },
            yAxis: {
                gridLineColor:'#e1e1e1'
            },
            series : [{
                name : 'USD to EUR',
                data : data,
                id : 'dataseries',
                tooltip : {
                    valueDecimals: 4
                }
            }, {
                type : 'flags',
                data : [{
                    x : Date.UTC(2011, 1, 22),
                    title : 'A',
                    text : 'Shape: "squarepin"'
                }, {
                    x : Date.UTC(2011, 3, 28),
                    title : 'A',
                    text : 'Shape: "squarepin"'
                }],
                onSeries : 'dataseries',
                shape : 'squarepin',
                width : 16
            }, {
                type : 'flags',
                data : [{
                    x : Date.UTC(2011, 2, 10),
                    title : 'C',
                    text : 'Shape: "flag"'
                }, {
                    x : Date.UTC(2011, 3, 11),
                    title : 'C',
                    text : 'Shape: "flag"'
                }],
                color : "rgba(128, 133, 233,0.8)",
                fillColor : "rgba(128, 133, 233,0.8)",
                onSeries : 'dataseries',
                width : 16,
                style : {// text style
                    color : 'white'
                },
                states : {
                    hover : {
                        fillColor : '#5C338A' // darker
                    }
                }
            }]
        });
    });


    /**** Point Chart: HighStock ****/
    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {

        // Create the chart
        $('#point-chart').highcharts('StockChart', {
            chart: {
                height:300,
                borderColor: '#C9625F',
                backgroundColor: 'transparent'
            },
            rangeSelector : {
                inputEnabled: false,
                selected : 2
            },
            credits: {
              enabled: false
            },
            exporting: {
                enabled: false
            },
            scrollbar: {
              enabled: false
            },
            navigator: {
                enabled: false
            },
            series : [{
                name : 'AAPL Stock Price',
                data : data,
                lineWidth : 0,
                marker : {
                    enabled : true,
                    radius : 2
                },
                tooltip: {
                    valueDecimals: 2
                }
            }]
        });
    });




});






