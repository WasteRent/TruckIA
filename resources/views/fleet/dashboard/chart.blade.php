@extends('layouts.fleet')

@section('title', __('Chart'))

@section('content')
  @component('components.search-card')  
  {!! 
    Form::model(request()->all(), [
      'method' => 'GET',
      'class' => ['md:flex items-center']
    ])
  !!}
      <div class="lg:px-3 lg:mb-0 mb-3">
        <label class="form-label">{{ __('Matrícula') }}</label>
        {!! Form::text('plate', null, ['placeholder' => '', 'class' => 'form-input']) !!}
      </div>
      <div class="text-right">
          <button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-search"></i>
          </button>
      </div>
  {!! Form::close() !!}
  @endcomponent


  <canvas id="myChart" width="400" height="200"></canvas>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var ctx = document.getElementById('myChart');

  var source = {!! json_encode($source) !!}

  const data = {
    labels: source[0].map(x => x.label),
    datasets: [
      {
        type: 'line',
        label: 'Recambios (€)',
        data: source[1].map(x => x.value),
        borderColor: 'rgb(0, 221, 94)',
        backgroundColor: 'rgb(0, 221, 94)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        type: 'line',
        label: 'Mano de obra (€)',
        data: source[2].map(x => x.value),
        borderColor: 'rgb(251, 191, 36)',
        backgroundColor: 'rgb(251, 191, 36)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        type: 'line',
        label: 'Gasto (€)',
        data: source[3].map(x => x.value),
        borderColor: 'rgb(119,136,153)',
        backgroundColor: 'rgb(119,136,153)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        type: 'bar',
        label: 'Ordenes de reparación',
        data: source[0].map(x => x.value),
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgb(255, 99, 132)',
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
      stacked: false,
      plugins: {
        title: {
          display: true,
          text: 'Evolución'
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

  var myChart = new Chart(ctx, config);
  </script>
@endpush