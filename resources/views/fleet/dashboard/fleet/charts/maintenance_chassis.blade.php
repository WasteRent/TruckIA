<div class="p-4 bg-gradient-to-br from-green-50 to-white rounded-xl">
	<div class="flex items-center mb-3">
		<div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
			<i class="fas fa-car text-white"></i>
		</div>
		<h3 class="text-lg font-bold text-gray-900">Mantenimiento Chasis</h3>
	</div>
	<canvas id="myChartVehicleMaintenanceChassis" width="200" height="50"></canvas>
</div>

@push('js')

  <script>
  var ctx = document.getElementById('myChartVehicleMaintenanceChassis');

  var up_to_date = {{ $maintenance_chassis->where('state', 'Al día')->count() }}
  var past = {{ $maintenance_chassis->where('state', 'Pasado')->count() }}
  var count = {{$maintenance_chassis->count()}}

  const dataChassis = {
    labels: [`Al día ${(100*up_to_date/count).toFixed(2)}%`, `Pasado ${(100*past/count).toFixed(2)}%`],
    datasets: [
      {
        label: 'Vehículo',
        data: [up_to_date, past],
        borderColor: ['#16a34a', '#ef4444'],
        backgroundColor: ['#16a34a', '#ef4444'],
        borderWidth: 2,
        hoverOffset: 10
      }
    ]
  };

  const configChassis = {
    type: 'doughnut',
    data: dataChassis,
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 15,
            font: {
              size: 12,
              family: 'Inter',
              weight: '600'
            },
            usePointStyle: true,
            pointStyle: 'circle'
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
            weight: 'bold'
          },
          bodyFont: {
            size: 13
          },
          borderColor: '#16a34a',
          borderWidth: 1
        }
      },
      cutout: '65%'
    },
  };

  var myChart = new Chart(ctx, configChassis);
  </script>
@endpush