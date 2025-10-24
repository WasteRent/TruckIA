<div class="p-6 bg-gradient-to-r from-gray-50 to-white rounded-xl">
	<div class="flex items-center mb-4">
		<div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
			<i class="fas fa-chart-bar text-white text-xl"></i>
		</div>
		<div>
			<h3 class="text-xl font-bold text-gray-900">{{ __('Estado de Vehículos') }}</h3>
			<p class="text-sm text-gray-600">Total: {{ $vehicles_state->sum('count') }} vehículos | @foreach($vehicles_owner as $owner => $count) {{ $owner }}: {{ $count }}@if(!$loop->last), @endif @endforeach</p>
		</div>
	</div>
	<div class="bg-white p-4 rounded-lg border border-gray-200">
		<canvas id="myChartVehicleState" width="300" height="70"></canvas>
	</div>
</div>

@push('js')

  <script>
  var myChartVehicleState = document.getElementById('myChartVehicleState');

  var sourceA = {!! json_encode($vehicles_state->values()->toArray()) !!}

  const dataA = {
    labels: sourceA.map(x => `${x.state} - ${x.percent}%`),
    datasets: [
      {
        type: 'bar',
        label: 'Vehículos',
        data: sourceA.map(x => {
          return {'label': `${x.state} - ${x.percent}%`, 'count': x.count, 'link': '{{ route('fleet.vehicles.index') }}' + '?state_id='+x.id}
        }),
        borderColor: '#16a34a',
        backgroundColor: 'rgba(22, 163, 74, 0.8)',
        cubicInterpolationMode: 'monotone',
        borderRadius: 10,
        borderWidth: 2,
        tension: 0.4,
        hoverBackgroundColor: 'rgba(22, 163, 74, 1)'
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
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.85)',
          padding: 15,
          titleFont: {
            size: 15,
            weight: 'bold'
          },
          bodyFont: {
            size: 14
          },
          borderColor: '#16a34a',
          borderWidth: 2,
          cornerRadius: 8
        }
      },
      scales: {
        x: {
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          },
          ticks: {
            font: {
              size: 12,
              family: 'Inter',
              weight: '600'
            }
          }
        },
        y: {
          grid: {
            display: false
          },
          ticks: {
            font: {
              size: 13,
              family: 'Inter',
              weight: '600'
            },
            color: '#374151'
          }
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