<?php

namespace App\Models;

use App\Events\VehicleStateChanged;
use App\Models\AccidentReport;
use App\Models\Alert;
use App\Models\Appointment;
use App\Models\Equipment;
use App\Models\Failure;
use App\Models\File;
use App\Models\Fleet;
use App\Models\Garage;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\RepairOrder;
use App\Models\VehicleCounterHistory;
use App\Models\VehicleCustomerHistory;
use App\Models\VehicleNote;
use App\Models\VehicleState;
use App\Models\VehicleStateHistory;
use App\Models\VehicleTracking;
use App\Models\VehicleType;
use App\Models\VehicleWorkCounter;
use App\Models\Version;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Vehicle extends EloquentModel
{
    use SoftDeletes;
    
    protected $appends = ['chassis'];

    protected $fillable = [
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
        'extinguisher_date',
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
        'manufacturing_date'
    ];

    public function setPlateAttribute($value)
    {
        $this->attributes['plate'] = strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $value));
    }

    public function setKmsAttribute($value)
    {
        $this->attributes['kms'] = (int)$value;
    }

    public function setWorkHoursAttribute($value)
    {
        $this->attributes['work_hours'] = (float)$value;
    }

    public function setCanHoursAttribute($value)
    {
        $this->attributes['can_hours'] = (float)$value;
    }

    public function setGruaHoursAttribute($value)
    {
        $this->attributes['grua_hours'] = (float)$value;
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'assigned_customer_id');
    }

    public function customerHistory()
    {
        return $this->hasMany(VehicleCustomerHistory::class)->latest();
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

    public function scopeActive($query)
    {
        return $query->whereNull('discharged_date')
                    ->whereNotIn('state_id', [VehicleState::DISCHARGED, VehicleState::OUT_OF_SERVICE, VehicleState::SOLD]);
    }

    public function isActive()
    {
        return $this->discharged_date == null && !in_array($this->state_id, [VehicleState::DISCHARGED, VehicleState::OUT_OF_SERVICE, VehicleState::SOLD]);
    }


    public function getChassisAttribute()
    {
        return optional($this->chassisMaker)->name . ' ' . optional($this->chassisModel)->name . ' ' . optional($this->chassisVersion)->name;
    }

    public function getEquipmentAttribute()
    {
        return optional(optional($this->equipments->first())->maker)->name . ' ' . optional(optional($this->equipments->first())->model)->name;
    }

    public function isMoving()
    {
        return $this->tracking()->whereBetween('fired_at', [now()->subHours(2), now()])->count() > 0;
    }
    
    public function alertsNotDailyOrWeekly()
    {
        return $this->hasMany(Alert::class)->where('title', 'NOT LIKE', '%diario%')->where('title', 'NOT LIKE', '%semanal%');
    }

    public function changeState(int $state_id)
    {
        $this->update(['state_id' => $state_id]);
        VehicleStateHistory::create([
            'vehicle_id' => $this->id,
            'state_id' => $state_id,
            'user_id' => Auth::user()->id
        ]);
        event(new VehicleStateChanged($this, VehicleState::find($state_id)));
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
        $makers = $equipments->pluck('maker.id')->push($this->chassis_maker_id);
        $models = $equipments->pluck('model.id')->push($this->chassis_model_id);

        return MaintenancePlan::query()
                ->with('manufacturer', 'model')
                ->whereIn('manufacturer_id', $makers)
                ->whereIn('model_id', $models)
                ->get();
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
            $query->where('plate', 'LIKE', "%{$filters['plate']}%");
        }
        if (isset($filters['vin']) && $filters['vin'] != null) {
            $query->where('vin', 'LIKE', "%{$filters['vin']}%");
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
