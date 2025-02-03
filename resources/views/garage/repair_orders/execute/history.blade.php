@if($operation->repairOrderOperationHistories()->count() > 0)
<div class="py-4">
    <span class="uppercase tracking-wide text-sm text-gray-800 mr-2">Historial</span>
    <div class="relative border-l-4 border-primary-orange pl-5 ml-2 space-y-4 rounded-lg shadow-md">
        @foreach($operation->repairOrderOperationHistories as $history)
        <div class="flex items-center space-x-3">
            <span class="bg-primary-orange text-green-700 rounded-full w-8 h-8 flex items-center justify-center">
                <i class="fas fa-user"></i> 
            </span>
            <p class="text-gray-800">
                <strong class="text-primary-orange">{{ $history->user->name ?? 'Un mecánico' }}</strong> 
                dedicó <strong class="text-green-700">{{ $history->hours_spent }} horas</strong> 
                a la orden de reparación el 
                <strong>{{ $history->created_at->format('d/m/Y H:i') }}</strong>.
            </p>
        </div>
        
        @endforeach
    </div>
</div>   
@endif
