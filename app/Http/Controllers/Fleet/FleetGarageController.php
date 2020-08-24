<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\GarageRequest;
use App\Models\Garage;
use App\Models\Manufacturer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FleetGarageController extends Controller
{

    public function index(Request $request)
    {
        if ($request->all()) {
            session(['filters' => $request->all()]);
        }
        
        $garages = Garage::filter(session('filters') ?? [])->paginate();
        return view('fleet.garages.index', [
            'garages' => $garages,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function create()
    {
        return view('fleet.garages.create', [
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function store(GarageRequest $request)
    {
        try {
            DB::beginTransaction();

            $garage = new Garage($request->all());
            $garage->save();

            User::create([
                'name'      => $request->name,
                'username'  => $request->garage_email ?? str_random(20),
                'email'     => $request->garage_email ?? str_random(20),
                'password'  => bcrypt(str_random(10)),
                'role'      => 'garage',
                'entity_relation_id' => $garage->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_message', 'Ha ocurrido un error');
        }

        return redirect()->route('fleet.garages.index')->with('success_message', 'Taller creado');
    }

    public function show(Garage $garage)
    {
        return view('fleet.garages.show', [
            'garage' => $garage
        ]);
    }

    public function edit(Garage $garage)
    {
        return view('fleet.garages.edit', [
            'garage' => $garage,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function update(GarageRequest $request, Garage $garage)
    {
        $garage->update($request->all());
        return back()->with('success_message', 'Taller actualizado');
    }

    public function destroy(Garage $garage)
    {
        $garage->delete();

        return back()->with('success_message', 'Taller eliminado');
    }
}
