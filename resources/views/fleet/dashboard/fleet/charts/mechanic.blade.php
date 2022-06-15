<canvas id="myChartMechanic" width="400" height="200"></canvas>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var ctxMechanic = document.getElementById('myChartMechanic');

  var source = {!! json_encode($vehicles_mechanic->toArray()) !!}

  const dataMechanic = {
    labels: source.map(x => x.name),
    datasets: [
      {
        type: 'bar',
        label: 'Incidencias',
        data: source.map(x => x.vehicles),
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgb(255, 99, 132)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      }
    ]
  };

  const configMechanic = {
    data: dataMechanic,
    options: {
      responsive: true,
      interaction: {
        mode: 'index',
        intersect: false,
      },
      stacked: false,
      plugins: {
        title: {
          display: true,
          text: 'Vehículos por mecánico'
        }
      },
      scales: {
        y: {
          type: 'linear',
          display: true,
          position: 'left',
        },
        y1: {
          type: 'linear',
          display: true,
          position: 'right',
          // grid line settings
          grid: {
            drawOnChartArea: false, // only want the grid lines for one axis to show up
          },
        },
      }
    },
  };

  var myChartMechanic = new Chart(ctxMechanic, configMechanic);
  </script>
@endpush