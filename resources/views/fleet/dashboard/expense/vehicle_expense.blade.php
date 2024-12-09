@extends('layouts.fleet')

@section('title', __('Gasto por vehículo'))

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
        <label class="form-label">{{ __('Desde') }}</label>
        {!! Form::text('from', request()->query('from') ?? now()->subMonths(3)->format('Y-m-d'), ['placeholder' => '', 'class' => 'form-input datepicker']) !!}
      </div>
      <div class="lg:px-3 lg:mb-0 mb-3">
        <label class="form-label">{{ __('Hasta') }}</label>
        {!! Form::text('to', request()->query('to') ?? now()->format('Y-m-d'), ['placeholder' => '', 'class' => 'form-input datepicker']) !!}
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

  <script>
  var ctx = document.getElementById('myChart');

  var source = {!! json_encode($source) !!}

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