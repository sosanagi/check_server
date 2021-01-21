@extends('ServerLayout')

@section('table_contents')

    <div class="box-body">
        <div style="width: 80%;">
            <canvas id="chart"></canvas>
        </div>
    </div>
    
@stop



@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/ja.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script>
    // X軸に使う日付
    // let labels = ["2020-02-01", "2020-02-02", "2020-02-03", "2020-02-06", "2020-02-07", "2020-02-14"];
    let labels = {!!$x_array!!}
    // Y軸に使う何かしらの数値
    // let values = [10, 21, 18, 13, 31, 3];
    let values = {!!$y_array!!}

    let config = {
        type: "line",
        data: {
        labels: labels,
        datasets: [{
            label: "cpu使用率",
            fill: false,
            borderColor: 'rgba(0, 0, 255, 0.5)',
            data: values
        }],
        },
        options: {
        scales: {
            xAxes: [{
            type: 'time',
            time: {
                unit: 'hour',
                displayFormats: {
                    hour: 'HH:MM'
                },
                parser: function(labels) {
                    return moment(labels).utc('+0900');
                }
                // parser: function (utcMoment) {
                //     return utcMoment.utcOffset('+0900');
                // } 
            }
            }]
        }
        }
    };
    // チャートの生成
    window.addEventListener("load", function() {
        let ctx = document.getElementById("chart").getContext("2d");
        myChart = new Chart(ctx, config);
    }, false);
</script>

@stop
