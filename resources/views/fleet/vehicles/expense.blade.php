<canvas id="myChart" width="400" height="200"></canvas>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var ctx = document.getElementById('myChart');

  var source = {!! json_encode($expense_data) !!}

  const data = {
    labels: source.map(x => x.plate),
    datasets: [
      {
        type: 'bar',
        label: 'Recambios (€)',
        data: source.map(x => x.parts_expense),
        borderColor: 'rgb(251, 191, 36)',
        backgroundColor: 'rgb(251, 191, 36)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        type: 'bar',
        label: 'Mano de obra (€)',
        data: source.map(x => x.operations_expense),
        borderColor: 'rgb(119,136,153)',
        backgroundColor: 'rgb(119,136,153)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        type: 'bar',
        label: 'Total (€)',
        data: source.map(x => x.total_expense),
        borderColor: 'rgb(54 162 235)',
        backgroundColor: 'rgb(54 162 235)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      }
    ]
  };

  const config = {
    data: data,
    options: {
      responsive: true,
      interaction: {
        mode: 'index',
        intersect: false,
      },
      plugins: {
        title: {
          display: true,
          text: 'Gasto por vehículo'
        }
      },
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      }
    },
  };

  var myChart = new Chart(ctx, config);
  </script>
@endpush