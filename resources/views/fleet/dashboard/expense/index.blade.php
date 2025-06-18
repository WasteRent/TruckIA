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
        {!! Form::select('customer_id', $allowed_customers->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}      </div>
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
  <div class="flex gap-5 lg:px-3 lg:mb-0 my-3">
    <a class="mr-4 text-green-600" href="{{ route('fleet.export.expense', request()->query()) }}"><i class="fas fa-lg fa-file-excel"></i></a>
  </div>
  @endcomponent


  <canvas id="expense-chart" width="400" height="100"></canvas>

  <canvas id="orders-chart" width="400" height="100"></canvas>
@endsection

@push('js')

  <script>
  var expenseChart = document.getElementById('expense-chart');
  var ordersChart = document.getElementById('orders-chart');

  var source = {!! json_encode($source) !!}

  const dataExpenses = {
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
        type: 'line',
        label: 'Saco roto (€)',
        data: source[6].map(x => x.value),
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgb(255, 99, 132)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      }
    ]
  };

  const dataOrders = {
    labels: source[0].map(x => x.label),
    datasets: [
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

  const configExpenses = {
    data: dataExpenses,
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
          text: 'Gastos'
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

  const configOrders = {
    data: dataOrders,
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
          text: 'Ordenes'
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

  new Chart(expenseChart, configExpenses);
  new Chart(ordersChart, configOrders);
  </script>
@endpush