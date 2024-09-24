<?php

namespace App\Models;

use App\Events\VehicleStateChanged;
use App\Models\VehicleLocation;
use App\User;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\TireReport;
class Vehicle extends EloquentModel implements \OwenIt\Auditing\Contracts\Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $appends = ['chassis'];

    protected $fillable = [
        'maintenance_included',
        'qrid',
        'denomination',
        'fleet_id',
        'assigned_customer_id',
        'plate',
        'fuel',
        'tachograph',
        'tachograph_date',
        'renting_start_date',
        'renting_end_date',
        'registration_date',
        'purchase_date',
        'discharged_date',
        'kms',
        'chassis_gps_work_hours',
        'chassis_can_work_hours',
        'chassis_version_id',
        'equipment_work_hours',
        'work_ratio_chassis_equipment',
        'gps_can_ratio',
        'counters_source',
        'can_hours',
        'grua_hours',
        'warranty_date',
        'vin',
        'last_itv_date',
        'itv_date',
        'chassis_maker_id',
        'chassis_model_id',
        'powertakeoff_type',
        'powertakeoff_serial_number',
        'powertakeoff_maker',
        'powertakeoff_model',
        'gearbox_type',
        'gearbox_serial_number',
        'gearbox_maker',
        'gearbox_model',
        'number_of_axes',
        'axe_1_2_distance',
        'axe_2_3_distance',
        'crane_work_hours',
        'width',
        'height',
        'length',
        'mma_kg',
        'tare_kg',
        'cc3',
        'power_kw',
        'vehicle_type_id',
        'webfleet_id',
        'state_id',
        'euro',
        'itv_exempt',
        'tachograph_exempt',
        'manufacturing_date',
        'location_id',
        'owner',
        'mechanic_user_id',
        'is_service_vehicle',
        'internal_id',
        'last_registration_date',
        'crane_revision_date',
        'gas_revision_date',
    ];

    public function setPlateAttribute($value)
    {
        $this->attributes['plate'] = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $value));
    }

    public function setKmsAttribute($value)
    {
        $this->attributes['kms'] = (int) $value;
    }

    public function setWorkHoursAttribute($value)
    {
        $this->attributes['work_hours'] = (float) $value;
    }

    public function setCanHoursAttribute($value)
    {
        $this->attributes['can_hours'] = (float) $value;
    }

    public function setGruaHoursAttribute($value)
    {
        $this->attributes['grua_hours'] = (float) $value;
    }

    public function scopeAllowForUser($query)
    {
        $fleet_id = auth()->user()->hasRole('fleet') 
                    ? auth()->user()->fleet->id
                    : auth()->user()->garage->fleet->id;

        $query = $query->where(function($q) use ($fleet_id) {
            $q->where('fleet_id', $fleet_id)->orWhereHas('guestFleet', function ($q2) use ($fleet_id) {
                $q2->where('fleet_id', $fleet_id);
            });
        });

        if (Auth::user()->allowedCustomers->count()) {
            $query = $query->whereIn('location_id', Auth::user()->allowedCustomers->pluck('id'));
        }

        return $query;
    }

    public function location()
    {
        return $this->belongsTo(Customer::class, 'location_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'assigned_customer_id');
    }

    public function mechanic()
    {
        return $this->belongsTo(User::class, 'mechanic_user_id');
    }

    public function customerHistory()
    {
        return $this->hasMany(VehicleCustomerHistory::class)->latest();
    }

    public function deliveries()
    {
        return $this->hasMany(VehicleDeliveryNote::class)->latest();
    }

    public function stateHistory()
    {
        return $this->hasMany(VehicleStateHistory::class)->latest();
    }

    public function counterHistory()
    {
        return $this->hasMany(VehicleCounterHistory::class)->latest();
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function guestFleet()
    {
        return $this->belongsToMany(Fleet::class, 'vehicle_fleet');
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }

    public function chassisMaker()
    {
        return $this->belongsTo(Manufacturer::class, 'chassis_maker_id');
    }

    public function chassisVersion()
    {
        return $this->belongsTo(Version::class, 'chassis_version_id');
    }

    public function chassisModel()
    {
        return $this->belongsTo(Model::class, 'chassis_model_id');
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function failures()
    {
        return $this->hasMany(Failure::class);
    }

    public function accident_reports()
    {
        return $this->hasMany(AccidentReport::class);
    }

    public function tires_reports()
    {
        return $this->hasMany(TireReport::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function notes()
    {
        return $this->hasMany(VehicleNote::class);
    }

    public function estinguishers()
    {
        return $this->hasMany(VehicleEstinguisher::class);
    }

    public function incidents()
    {
        return $this->hasMany(VehicleIncident::class);
    }

    public function tracking()
    {
        return $this->hasMany(VehicleTracking::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'vehicle_files');
    }

    public function pictures()
    {
        return $this->belongsToMany(File::class, 'vehicle_pictures')->withPivot('cover');
    }

    public function getCover()
    {
        return $this->pictures()->orderByDesc('cover')->first();
    }

    public function counters()
    {
        return $this->hasMany(VehicleWorkCounter::class)->orderBy('max');
    }

    public function state()
    {
        return $this->belongsTo(VehicleState::class);
    }

    public function vehicleChecklists()
    {
        return $this->hasMany(VehicleChecklist::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('discharged_date')
                    ->whereNotIn('state_id', [VehicleState::DISCHARGED, VehicleState::OUT_OF_SERVICE, VehicleState::SOLD]);
    }

    public function isActive()
    {
        return $this->discharged_date == null && ! in_array($this->state_id, [VehicleState::DISCHARGED, VehicleState::OUT_OF_SERVICE, VehicleState::SOLD]);
    }

    public function getChassisAttribute()
    {
        return optional($this->chassisMaker)->name.' '.optional($this->chassisModel)->name.' '.optional($this->chassisVersion)->name;
    }

    public function getEquipmentAttribute()
    {
        return optional(optional($this->equipments->first())->maker)->name.' '.optional(optional($this->equipments->first())->model)->name;
    }

    public function isMoving()
    {
        return $this->tracking()->whereBetween('fired_at', [now()->subHours(2), now()])->count() > 0;
    }

    public function alertsNotDailyOrWeekly()
    {
        return $this->hasMany(Alert::class)->where('title', 'NOT LIKE', '%diario%')->where('title', 'NOT LIKE', '%semanal%');
    }

    public function changeState(int $state_id, string $created_at = null)
    {
        if (! VehicleState::find($state_id)) {
            return;
        }

        $this->update(['state_id' => $state_id]);
        VehicleStateHistory::create([
            'vehicle_id' => $this->id,
            'state_id' => $state_id,
            'user_id' => Auth::user()->id ?? 987,
            'created_at' => $created_at ?? now(),
        ]);
        event(new VehicleStateChanged($this, VehicleState::findOrFail($state_id)));
    }

    public function next()
    {
        $ids = Vehicle::filter(session('filters') ?? [])
                    ->active()
                    ->where('fleet_id', Auth::user()->fleet->id)
                    ->orderBy('plate')
                    ->get()
                    ->pluck('id');

        $index = $ids->search($this->id) + 1;

        if ($ids->has($index)) {
            return Vehicle::find($ids->get($index));
        }

        return $this;
    }

    public function prev()
    {
        $ids = Vehicle::filter(session('filters') ?? [])
                    ->active()
                    ->where('fleet_id', Auth::user()->fleet->id)
                    ->orderBy('plate')
                    ->get()
                    ->pluck('id');

        $index = $ids->search($this->id) - 1;

        if ($ids->has($index)) {
            return Vehicle::find($ids->get($index));
        }

        return $this;
    }

    public function getMaintenancePlans()
    {
        $equipments = $this->equipments;

        if (auth()->user()) {
            $chassis = MaintenancePlan::query()
                    ->with('manufacturer', 'model')
                    ->where('manufacturer_id', $this->chassis_maker_id)
                    ->where('model_id', $this->chassis_model_id)
                    ->where('version_id', $this->chassis_version_id)
                    ->where('euro', $this->euro)
                    ->where('original', auth()->user()->allowOriginalPlans() ? 1 : 0)
                    ->orderBy('work_hours')
                    ->orderBy('can_hours')
                    ->orderBy('natural_hours')
                    ->orderBy('kms')
                    ->get();

            $equipments = MaintenancePlan::query()
                    ->with('manufacturer', 'model')
                    ->whereIn('manufacturer_id', $equipments->pluck('maker.id'))
                    ->whereIn('model_id', $equipments->pluck('model.id'))
                    ->where('original', auth()->user()->allowOriginalPlans() ? 1 : 0)
                    ->orderByDesc('name')
                    ->get();

            $assigned = MaintenancePlan::query()
                    ->with('manufacturer', 'model')
                    ->whereIn('id', $this->counters->pluck('plan_id')->filter())
                    ->orderByDesc('name')
                    ->get();

            $custom = auth()->user()->fleet->customPlans;
        } else {
            $chassis = MaintenancePlan::query()
                    ->with('manufacturer', 'model')
                    ->where('manufacturer_id', $this->chassis_maker_id)
                    ->where('model_id', $this->chassis_model_id)
                    ->where('version_id', $this->chassis_version_id)
                    ->where('euro', $this->euro)
                    ->orderBy('work_hours')
                    ->orderBy('can_hours')
                    ->orderBy('natural_hours')
                    ->orderBy('kms')
                    ->get();

            $equipments = MaintenancePlan::query()
                    ->with('manufacturer', 'model')
                    ->whereIn('manufacturer_id', $equipments->pluck('maker.id'))
                    ->whereIn('model_id', $equipments->pluck('model.id'))
                    ->orderByDesc('name')
                    ->get();

            $assigned = MaintenancePlan::query()
                    ->with('manufacturer', 'model')
                    ->whereIn('id', $this->counters->pluck('plan_id')->filter())
                    ->orderByDesc('name')
                    ->get();

            $custom = [];
        }

        return $chassis->merge($equipments)->merge($assigned)->merge($custom);
    }

    public function incrementCanHours(float $read)
    {
        $this->increment('chassis_can_work_hours', $read);
        $this->increment('equipment_work_hours', $read / $this->work_ratio_chassis_equipment);

        $this->counters
            ->where('vehicle_category', 'chassis')
            ->where('type', 'work_hours')
            ->each(function ($counter) use ($read) {
                $counter->increment('current', $read);
            });

        $this->counters
            ->where('vehicle_category', 'equipment')
            ->where('type', 'work_hours')
            ->each(function ($counter) use ($read) {
                $counter->increment('current', $read / $this->work_ratio_chassis_equipment);
            });
    }

    public function incrementChassisHours(float $read)
    {
        $this->increment('chassis_can_work_hours', $read);

        $this->counters
            ->where('vehicle_category', 'chassis')
            ->where('type', 'work_hours')
            ->each(function ($counter) use ($read) {
                $counter->increment('current', $read);
            });
    }

    public function incrementGpsHours(float $read)
    {
        $this->increment('chassis_gps_work_hours', $read);

        if ($this->counters_source == 'gps') {
            //Modify counters an CAN hours based on GPS data
            $this->incrementCanHours($read / $this->gps_can_ratio);
        }
    }

    public function incrementKms(int $read)
    {
        $this->increment('kms', $read);
        $this->counters->where('type', 'kms')->each(function ($counter) use ($read) {
            $counter->increment('current', $read);
        });
    }

    public function modelsRelated()
    {
        $vehicle_models = collect([$this->chassisModel]);

        foreach ($this->equipments as $equipment) {
            $vehicle_models->push($equipment->model);
        }

        return $vehicle_models;
    }

    public function usesCan()
    {
        return $this->can_hours > 0;
    }

    public function usesGrua()
    {
        return $this->grua_hours > 0;
    }

    public static function filter(array $filters)
    {
        $query = Vehicle::query();

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->where(function ($q) use ($filters) {
                $q->where('plate', 'LIKE', "%{$filters['plate']}%")->orWhere('internal_id', 'LIKE', "%{$filters['plate']}%");
            });
        }
        if (isset($filters['vin']) && $filters['vin'] != null) {
            $query->where('vin', 'LIKE', "%{$filters['vin']}%");
        }
        if (isset($filters['internal_id']) && $filters['internal_id'] != null) {
            $query->where('internal_id', $filters['internal_id']);
        }
        if (isset($filters['owner']) && $filters['owner'] != null) {
            $query->where('owner', $filters['owner']);
        }
        if (isset($filters['location_id']) && $filters['location_id'] != null) {
            $query->where('location_id', $filters['location_id']);
        }
        if (isset($filters['mechanic_user_id']) && $filters['mechanic_user_id'] != null) {
            if ($filters['mechanic_user_id'] == '-1') {
                $query->whereNull('mechanic_user_id');
            } else {
                $query->where('mechanic_user_id', $filters['mechanic_user_id']);
            }
        }

        if (isset($filters['chassis_maker_id']) && $filters['chassis_maker_id'] != null) {
            $query->where('chassis_maker_id', $filters['chassis_maker_id']);
        }
        if (isset($filters['chassis_model_id']) && $filters['chassis_model_id'] != null) {
            $query->where('chassis_model_id', $filters['chassis_model_id']);
        }
        if (isset($filters['equipment_maker_id']) && $filters['equipment_maker_id'] != null) {
            $query->whereHas('equipments', function ($q) use ($filters) {
                $q->where('maker_id', $filters['equipment_maker_id']);
            });
        }
        if (isset($filters['equipment_model_id']) && $filters['equipment_model_id'] != null) {
            $query->whereHas('equipments', function ($q) use ($filters) {
                $q->where('model_id', $filters['equipment_model_id']);
            });
        }
        if (isset($filters['with_itv_date']) && $filters['with_itv_date'] != null) {
            $filters['with_itv_date']
                ? $query->whereNotNull('itv_date')
                : $query->whereNull('itv_date');
        }
        if (isset($filters['state_id']) && $filters['state_id'] != null) {
            $query->where('state_id', $filters['state_id']);
        }
        if (isset($filters['vehicle_type_id']) && $filters['vehicle_type_id'] != null) {
            $query->where('vehicle_type_id', $filters['vehicle_type_id']);
        }
        if (isset($filters['assigned_customer_id']) && $filters['assigned_customer_id'] != null) {
            if ($filters['assigned_customer_id'] == '-1') {
                $query->whereNull('assigned_customer_id');
            } else {
                $query->where('assigned_customer_id', $filters['assigned_customer_id']);
            }
        }
        if (isset($filters['tachograph_exempt']) && $filters['tachograph_exempt'] != null) {
            $query->where('tachograph_exempt', $filters['tachograph_exempt']);
        }
        if (isset($filters['repair_orders_state_id']) && $filters['repair_orders_state_id'] != null) {
            $query->whereHas('repairOrders', function ($q) use ($filters) {
                $q->where('state_id', $filters['repair_orders_state_id']);
            });
        }

        return $query;
    }
}
