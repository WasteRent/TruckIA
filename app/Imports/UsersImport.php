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

    public function __construct(private int $fleet_id, private int $garage_id)
    {
    }

    public function model(array $row)
    {
        $job = [
            'Conductor' => 'driver',
            'Taller' => 'garage',
            'Mecánico' => 'mechanic',
            'Jefe taller' => 'garage_boss',
            'Capataz' => 'capataz',
        ];

        $role = [
            'Conductor' => 'fleet',
            'Mecánico' => 'garage',
            'Jefe taller' => 'fleet',
            'Capataz' => 'fleet',
        ];

        $entity_id = [
            'Conductor' => $this->fleet_id,
            'Mecánico' => $this->garage_id,
            'Jefe taller' => $this->fleet_id,
            'Capataz' => $this->fleet_id,
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

        $customers = Customer::where('fleet_id', $this->fleet_id)->whereIn('name', explode(',', $row['clientes']))->get();
        $user->allowedCustomers()->sync($customers->pluck('id'));

        return null;
    }


    public function rules(): array
    {
        return [
            '*.nombre' => 'required|string|max:255',
            '*.primer_apellido' => 'required',
            '*.segundo_apellido' => 'nullable',
            '*.rol' => ['required', 'string', Rule::in(['Conductor', 'Mecánico', 'Jefe taller', 'Capataz'])],
            '*.usuario' => 'nullable|string|max:255',
            '*.contrasena' => 'required',
            '*.clientes' => ['required'],
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
