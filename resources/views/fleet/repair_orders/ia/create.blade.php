@extends('layouts.fleet')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Procesamiento de Documentos con IA</h1>
            <p class="text-gray-600">Sube documentos como facturas, albaranes o recibos para extraer información automáticamente usando inteligencia artificial.</p>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('fleet.repair-orders.ia.store', $repair_order) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- File Upload -->
                <div class="space-y-4">
                    <label for="file" class="block text-sm font-medium text-gray-700">
                        Seleccionar archivo
                    </label>
                    <input type="file" 
                           id="file" 
                           name="file" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                           required>
                    <p class="text-sm text-gray-500">
                        Formatos soportados: PDF, JPG, JPEG, PNG. Tamaño máximo: 10MB
                    </p>
                    
                    <!-- Selected File Info -->
                    <div id="fileInfo" class="hidden bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-900">Archivo seleccionado:</p>
                                <p class="text-sm text-green-700" id="fileName"></p>
                                <p class="text-xs text-green-600" id="fileSize"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('fleet.vehicles.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Procesar Documento
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section (if data is passed from controller) -->
        @if(isset($results))
        <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Resultados del Procesamiento</h2>
            <div class="space-y-4">
                @if(is_array($results))
                    @foreach($results as $key => $value)
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                            <span class="text-gray-900">
                                @if(is_array($value))
                                    {{ implode(', ', $value) }}
                                @else
                                    {{ $value }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600">No se pudieron extraer datos del documento.</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Error Section (if error is passed from controller) -->
        @if(isset($error))
        <div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-red-800">Error al procesar el documento</h3>
                    <p class="text-red-700 mt-1">{{ $error }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            
            // Mostrar información del archivo
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.classList.remove('hidden');
        } else {
            fileInfo.classList.add('hidden');
        }
    });

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endsection
