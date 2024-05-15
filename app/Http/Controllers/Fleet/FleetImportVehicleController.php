<?php

namespace App\Http\Controllers\Fleet;

use App\Imports\FleetVehicleImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FleetImportVehicleController extends Controller
{
    public function create()
    {
        return view('fleet.vehicles.import.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:xlsx,txt',
        ]);
    
        DB::beginTransaction();
    
        try {
            Excel::import(new FleetVehicleImport, $request->file('attachment'));
    
            DB::commit();
    
            return redirect()->route('fleet.vehicles.index')->with('success_message', 'Los vehículos y equipamientos se han importado correctamente.');
        } catch (ValidationException $e) {
            DB::rollBack();
        
            $errors = $e->errors();
            $translatedErrors = array_map(function ($error) {
                // Traduce la cadena "There was an error on row" y reemplaza en el mensaje
                $message = $error[0];
                $translatedMessage = str_replace(
                    'There was an error on row',
                    __('There was an error on row'),
                    $message
                );
        
                return $translatedMessage;
            }, $errors);
        
            $errorMessage = __('Hubo un problema al importar los datos:<br> :errors', [
                'errors' => implode('<br> ', $translatedErrors)
            ]);
        
            return redirect()->route('fleet.vehicles.index')->with('error_message', $errorMessage);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->route('fleet.vehicles.index')->with('error_message', 'Hubo un problema al importar los datos: ' . __($e->getMessage()));
        }
    }
}
    
