<canvas id="myChartVehicleState" width="300" height="200"></canvas>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var myChartVehicleState = document.getElementById('myChartVehicleState');

  var sourceA = {!! json_encode($vehicles->values()->toArray()) !!}

  const dataA = {
    labels: sourceA.map(x => `${x.state} - ${x.percent}%`),
    datasets: [
      {
        type: 'bar',
        label: 'Vehículo',
        data: sourceA.map(x => x.count),
        borderColor: '#3b82f6',
        backgroundColor: '#3b82f6',
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const configA = {
    type: 'bar',
    data: dataA,
    options: {
      indexAxis: 'y',
      // Elements options apply to all of the options unless overridden in a dataset
      // In this case, we are setting the border of each horizontal bar to be 2px wide
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
          text: '{{ $vehicles->count() }} vehículos'
        }
      }
    },
  };

  var myChart = new Chart(myChartVehicleState, configA);
  </script>
@endpush