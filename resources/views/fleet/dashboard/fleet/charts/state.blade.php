<canvas id="myChartVehicleState" width="300" height="70"></canvas>

@push('js')

  <script>
  var myChartVehicleState = document.getElementById('myChartVehicleState');

  var sourceA = {!! json_encode($vehicles_state->values()->toArray()) !!}

  const dataA = {
    labels: sourceA.map(x => `${x.state} - ${x.percent}%`),
    datasets: [
      {
        type: 'bar',
        label: 'Vehículo',
        data: sourceA.map(x => {
          return {'label': `${x.state} - ${x.percent}%`, 'count': x.count, 'link': '{{ route('fleet.vehicles.index') }}' + '?state_id='+x.id}
        }),
        borderColor: '#3b82f6e8',
        backgroundColor: '#3b82f6c7',
        cubicInterpolationMode: 'monotone',
        borderRadius: 8,
        tension: 0.4
      }
    ]
  };

  const configA = {
    type: 'bar',
    data: dataA,
    options: {
      indexAxis: 'y',
      parsing: {
        xAxisKey: 'count',
        yAxisKey: 'label'
      },
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      plugins: {
        legend: {
          position: 'right',
        },
        title: {
          display: true,
          text: 'Total: {{ $vehicles_state->sum('count') }}, @foreach($vehicles_owner as $owner => $count) {{ $owner }}: {{ $count }}@if(!$loop->last),@endif @endforeach'
        }
      }
    },
  };

  var vehicleStateChart = new Chart(myChartVehicleState, configA);


  document.getElementById("myChartVehicleState").onclick = function(evt){
      const points = vehicleStateChart.getElementsAtEventForMode(evt, 'nearest', {intersect: true}, true);

      if (points.length) {
        const firstPoint = points[0];
        const value = vehicleStateChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index]
        window.open(value.link)
      }
    }
  </script>
@endpush