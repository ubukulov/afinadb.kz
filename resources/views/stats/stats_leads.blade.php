@extends('layouts.app')
@section('content')
    @if(!empty($stats))
        @php
            $suc = $stats[0]->suc;
            $pro = $stats[0]->pro;
            $can = $stats[0]->can;
            $new = $stats[0]->new;
            $cnt = $suc + $pro + $can + $new;
        @endphp
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Общее количество',     "<?php echo $cnt ?>"],
                ['Обработано',      "<?php echo $suc ?>"],
                ['Отказы',  "<?php echo $can ?>"],
                ['В процессе', "<?php echo $pro ?>"],
                ['Новые',    "<?php echo $new ?>"]
            ]);

            var options = {
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    @endif
@stop