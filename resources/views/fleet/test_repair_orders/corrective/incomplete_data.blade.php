@extends('layouts.fleet')

@section('title', 'Crear Orden de Reparación Datos Incompletos')

@section('content')

@component('components.card')
	
@include('fleet.test_repair_orders.form', $vehicle)
	
  {!! Form::model($repair_order, [
			'route' => ['fleet.test-repair-orders.update', $repair_order],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}

    <div class="container border-2 border-secondary">
        <div class="flex flex-wrap mx-1 mb-6 mt-2">
            <div class="w-full md:w-1/4">
                Tiempo de desplazamiento (minutos): 
            </div>
            <div class="w-full md:w-1/4">
            {!! Form::number('time_displacement', $repair_order->time_displacement	, ['class' => 'form-input md:w-1/4', 'disabled']) !!}
            </div>
            <div class="w-full md:w-2/4 ">
                <div class="form-group float-right">
                {!! Form::label('sinister','¿Se trata de un siniestro?:',['class' => 'mr-3']) !!}
                {!! Form::select('sinister', ['1' => 'SI', '0' => 'NO'], $repair_order->sinister, ['disabled']) !!}
                </div>
            </div>
                <div class="w-full">
                    <div class="form-group float-right">
                    {!! Form::label('misuse','¿Intervención por malos usos / golpes?:',['class' => 'mr-3']) !!}
                    {!! Form::select('misuse', ['1' => 'SI', '0' => 'NO'], $repair_order->misuse, ['disabled']) !!}
                    </div>
                </div>
        </div>
        
        {{-- Aquí se saca con un foreach un listado de las operaciones asignadas a este OR (orden descendente)--}}
        <?php $x = 1; ?>
      @foreach($operations as $operation)   
        <div class="flex flex-wrap mx-1 mb-6 mt-2">

            <div class="w-full md:w-1/12"><?php echo $x; ?></div>

            <div class="w-full md:w-11/12 border-2 border-secondary">

                <div class="flex flex-wrap">
                    <div class="w-full md:w-3/12">
                        {!! Form::select('operation_family', ['chassis' => 'Chasis', 'equipment' => 'Equipo', 'both' => 'Ambas', 'unknow' => 'Desconocido'], $operation->operation_family, ['class' => 'form-select']) !!}
                    </div>
                    <div class="w-full md:w-3/12 ml-1">
                        {!! Form::select('operation_subfamily', ['hidraulic' => 'Hidráulica', 'mechanic' => 'Mecánica', 'electrical' => 'Eléctrica', 'pneumatics' => 'Neumática', 'unknow' => 'Desconocido', 'others' => 'Otros'] , $operation->operation_subfamily, ['class' => 'form-select']) !!}
                    </div>
                    <div class="w-full md:w-4/12 ml-1">
                    {!! Form::number('estimated_time', $operation->estimated_time, ['class' => 'form-input md:w-1/4']) !!} (min)
                    </div>
                    <div class="w-full md:w-1/12 float-right">
                      <a href="{{ route('fleet.test-repair-orders.destroyOperation', $operation) }}">
                            <i class="fas fa-trash"></i>
                          </a>
                    </div>                      
                </div>

                <div class="flex flex-wrap mt-1">
                    <div class="w-full">
                        {!! Form::textarea('operation_description', $operation->operation_description, ['class' => 'form-input', 'rows' => 2]) !!}
                    </div>
                </div>

                {{-- Ahora salen listados los recambios asignados (orden descendente)--}}
                  <?php $z = 1; ?>
                  @foreach($operations_parts as $operations_part)
                    @if($operations_part->repair_order_operation_id == $operation->id)
                    <div class="container">
                      <div class="flex flex-wrap mb-1">
                        <div class="w-full md:w-1/12">
                          <?php echo $z; ?>
                        </div>
                        <div class="w-full md:w-4/12 -mx-6">
                            {!! Form::text('name',$operations_part->name ,['class' => 'form-input', 'placeholder' => 'Nombre']) !!}
                        </div>
                        <div class="w-full md:w-2/12 ml-1">
                            {!! Form::text('reference',$operations_part->reference , ['class' => 'form-input']) !!}
                        </div>
                        <div class="w-full md:w-2/12 ml-1">
                        {!! Form::select('type',['new' => 'Nuevo', 'stock' => 'Stock'], $operations_part->type , ['class' => 'form-input']) !!}
                        </div>
                        <div class="w-full md:w-2/12 ml-1">
                            {!! Form::number('total_price' ,$operations_part->total_price , ['class' => 'form-input', 'placeholder' => ' -- €']) !!}
                        </div>
                        <div class="w-full md:w-1/12 float-right ml-1">
                          <a href="{{ route('fleet.test-repair-orders.destroyPart', $operations_part) }}">
                            <i class="fas fa-trash"></i>
                          </a>
                      </div>
                    </div>
                    @endif
                    <?php $z++; ?>
                  @endforeach
                </div>

            </div>
            
        </div>
        <?php $x++; ?>
      @endforeach

            <button class="btn-indigo float-right m-2">
                Guardar
            </button>

    </div>

  {!! Form::close() !!}
  @endcomponent
  @endsection