<?php

namespace App\Http\Controllers\Garage;

use App\Classes\AlertService;
use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\AppointmentRequest;
use App\Models\AlertType;
use App\Models\Appointment;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageAppointmentController extends Controller
{

    public function index()
    {
        return view('garage.appointments.index', [
            'appointments' => Auth::user()->garage->appointments
        ]);
    }

    public function create(Request $request)
    {
        return view('garage.appointments.create', [
            'vehicle_id' => $request->vehicle_id
        ]);
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = new Appointment($request->all());
        $appointment->creator_user_id = Auth::user()->id;
        $appointment->garage_id = Auth::user()->garage->id;
        $appointment->save();

        RapairOrderStateService::transit($request->repair_order_id, RepairOrderState::APPOINMENT_ARRANGED);

        if ($appointment->vehicle->customer) {
            (new AlertService)->to($appointment->vehicle->customer)->forVehicle($appointment->vehicle)->notify(
                'Nueva cita para llevar al taller',
                "Debes llevar el {$request->date_time} el vehículo a ".Auth::user()->garage->name,
                null,
                AlertType::APPOINMENT
            );
        }

        return redirect()->route('garage.appointments.index')->with('success_message', 'Cita creada');
    }

    public function show(Appointment $appointment)
    {
        return view('garage.appointments.show', [
            'appointment' => $appointment
        ]);
    }

    public function edit(Appointment $appointment)
    {
        return view('garage.appointments.edit', [
            'appointment' => $appointment
        ]);
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        return redirect()->route('garage.appointments.index')->with('success_message', 'Cita actualizada');
    }

    public function vehicleReceived(Appointment $appointment)
    {
        $appointment->vehicle_received = true;
        $appointment->vehicle_received_at = new \DateTime;
        $appointment->save();

        RapairOrderStateService::transit($appointment->repair_order_id, RepairOrderState::VEHICLE_RECEIVED);

        return back()->with('success_message', 'Vehículo recepcionado');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success_message', 'Cita eliminada');
    }
}
