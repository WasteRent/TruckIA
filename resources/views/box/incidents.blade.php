@if($vehicle->incidents->count() > 0)
    @component('components.card', ['is_table' => true, 'no_shadow' => 1])
        @slot('title', __('Incidencias recientes'))
          <ul>
            @foreach($vehicle->incidents()->orderByDesc('id')->get() as $incidence)
            <li class="px-2 py-1 texr-sm">
              <div class="text-gray-700">
                <span class="text-gray-800 font-medium">
                  #{{$incidence->id}}  
                  {{ $incidence->created_at->format('d/m/Y') }} {{ $incidence->user->name }}:
                </span>

                {!! $incidence->incidence !!}
              </div>
            </li>
            @endforeach
        </ul>
    @endcomponent
@endif