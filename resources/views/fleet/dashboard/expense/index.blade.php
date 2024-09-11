@extends('layouts.fleet')

@section('title', __('Gasto'))

@section('content')
  
  @include('fleet.dashboard.tabs', ['expense' => true])

  @include('fleet.dashboard.expense.sub_tab')

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
      <div class="lg:px-3 lg:mb-0 mb-3">
        <label class="form-label">{{ __('Cliente') }}</label>
        {!! Form::select('customer_id', auth()->user()->fleet->customers()->orderBy('name')->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
      </div>
      <div class="lg:px-3 lg:mb-0 mb-3">
        <label class="form-label">{{ __('Tipo de vehículo') }}</label>
        {!! Form::select('vehicle_type_id', App\Models\VehicleType::orderBy('name')->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
      </div>
      <div class="text-right">
          <button class="btn-search">
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
        label: 'Gasto total (€)',
        data: source[5].map(x => x.value),
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