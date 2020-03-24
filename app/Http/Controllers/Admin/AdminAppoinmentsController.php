<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAppoinmentsController extends Controller
{

    public function index()
    {
        return view('admin.appointments.index', [
            'appointments' => Appointment::all()
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.appointments.create', [
            'vehicle_id' => $request->vehicle_id
        ]);
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = new Appointment($request->all());
        $appointment->creator_user_id = Auth::user()->id;
        $appointment->save();
        return redirect()->route('admin.appointments.index')->with('success_message', 'Cita creada');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', [
            'appointment' => $appointment
        ]);
    }

    public function edit(Appointment $appointment)
    {
        return view('admin.appointments.edit', [
            'appointment' => $appointment
        ]);
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        return redirect()->route('admin.appointments.index')->with('success_message', 'Cita actualizada');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success_message', 'Cita eliminada');
    }
}
