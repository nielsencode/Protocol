<html>
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
        //$(function() {

            google.load('visualization', '1', {'packages': ['geochart']});
            google.setOnLoadCallback(drawMarkersMap);

            function drawMarkersMap() {
                $(function() {

                    var cities = JSON.parse(decodeURIComponent($('#chart_div').attr('data')));

                    var rows = [[
                        'Latitude','Longitude','City','Clients'
                    ]];

                    var counts = [];

                    $.each(cities,function(i,city) {
                        counts.push(city.clients);

                        rows.push([
                            parseInt(city.latitude),
                            parseInt(city.longitude),
                            city.city,
                            parseInt(city.clients)
                        ]);
                    });

                    var max = Math.ceil(Math.max.apply(null,counts)/10)*10;

                    var data = google.visualization.arrayToDataTable(rows);

                    var options = {
                        region: 'US',
                        displayMode: 'markers',
                        colorAxis: {minValue:1,maxValue:max,colors:['blue','red']},
                        resolution:'provinces'
                    };

                    var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
                    chart.draw(data, options);

                });
            };

        //});
    </script>
</head>
<body>
<div id="chart_div" data="{{ rawurlencode(json_encode($cities)) }}" style="width: 900px; height: 500px;"></div>
</body>
</html>