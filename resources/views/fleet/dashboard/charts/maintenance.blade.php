<canvas id="myChartVehicleMaintenance" width="200" height="50"></canvas>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var ctx = document.getElementById('myChartVehicleMaintenance');

  const data = {
    labels: ['Al día', 'Pasado'],
    datasets: [
      {
        label: 'Vehículo',
        data: [1,2],
        borderColor: ['#22c45d', '#ef4444'],
        backgroundColor: ['#22c45d', '#ef4444'],
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const config = {
    type: 'pie',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Mantenimiento'
        }
      }
    },
  };

  var myChart = new Chart(ctx, config);
  </script>
@endpush