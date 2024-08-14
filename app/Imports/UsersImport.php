<?php

namespace App\Imports;

use App\Models\Customer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        $fleet_id = 30;  //acciona
        $garage_id = 320;  //acciona

        $job = [
            'Conductor' => 'driver',
            'Mecanico' => 'mechanic',
            'Jefe taller' => '',
        ];

        $role = [
            'Conductor' => 'fleet',
            'Mecanico' => 'garage',
            'Jefe taller' => 'fleet',
        ];

        $entity_id = [
            'Conductor' => $fleet_id,
            'Mecanico' => $garage_id,
            'Jefe taller' => $fleet_id,
        ];

        $user = User::create([
            'name' => "{$row['nombre']} {$row['primer_apellido']} {$row['segundo_apellido']}",
            'username' => $row['usuario'],
            'password' => Hash::make($row['contrasena']),
            'email' => $row['usuario'],
            'is_active' => 1,
            'is_readonly' => 0,
            'job' => $job[$row['rol']],
            'role' => $role[$row['rol']],
            'entity_relation_id' => $entity_id[$row['rol']],
            'allowed_schedule' => null,
        ]);

        $customer = Customer::where('fleet_id', $fleet_id)->where('name', $row['cliente'])->firstOrFail();
        $user->allowedCustomers()->sync($customer->id);

        return null;
    }


    public function rules(): array
    {
        return [
            '*.primer_apellido' => 'required',
            '*.segundo_apellido' => 'nullable',
            '*.nombre' => 'required|string|max:255',
            '*.usuario' => 'nullable|string|max:255',
            '*.contrasena' => 'required',
            '*.rol' => ['required', 'string', Rule::in(['Conductor', 'Mecanico', 'Jefe taller'])],
            '*.cliente' => ['required', 'string', Rule::exists('customers', 'name')],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => 'El campo :attribute es obligatorio en la fila :row.',
            '*.integer' => 'El campo :attribute debe ser un número entero en la fila :row.',
            '*.date' => 'El campo :attribute debe ser una fecha válida en la fila :row.',
            '*.string' => 'El campo :attribute debe ser una cadena de texto en la fila :row.',
            '*.exists' => 'El campo :attribute debe existir en la base de datos en la fila :row.',
            '*.max' => 'El campo :attribute no debe exceder :max caracteres en la fila :row.',
            '*.numeric' => 'El campo :attribute debe ser un número en la fila :row.',
        ];
    }
}
