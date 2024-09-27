<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
class FleetImportUserController extends Controller
{
    public function create()
    {
        return view('fleet.users.import.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:xlsx,txt',
        ]);
    
        try {
            DB::beginTransaction();

            Excel::import(new UsersImport(auth()->user()->fleet->id, 320), $request->file('attachment'));
    
            DB::commit();
            return redirect()->route('fleet.users.index')->with('success_message', 'Los usuarios se han importado correctamente.');
        } catch (ValidationException $e) {
            DB::rollBack();
        
            $errors = $e->errors();
            $translatedErrors = array_map(function ($error) {
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
        
            return redirect()->route('fleet.import-users.create')->with('error_message', $errorMessage);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->route('fleet.import-users.create')->with('error_message', 'Hubo un problema al importar los datos: ' . __($e->getMessage()));
        }
    }
}
    
