<?php

namespace App\Models;

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
use App\Models\VehicleCustomerHistory;
use App\Models\VehicleNote;
use App\Models\VehicleState;
use App\Models\VehicleStateHistory;
use App\Models\VehicleTracking;
use App\Models\VehicleType;
use App\Models\VehicleWorkCounter;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Auth;

class Vehicle extends EloquentModel
{
    protected $appends = ['chassis'];

    protected $fillable = [
        'assigned_customer_id',
        'plate',
        'fuel',
        'tachograph',
        'registration_date',
        'purchase_date',
        'discharged_date',
        'kms',
        'work_hours',
        'can_hours',
        'warranty_date',
        'vin',
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
        'euro'
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
        return $query->whereNull('discharged_date');
    }

    public function getChassisAttribute()
    {
        return optional($this->chassisMaker)->name . ' ' . optional($this->chassisModel)->name;
    }

    public function isMoving()
    {
        return $this->tracking()->whereBetween('fired_at', [now()->subHours(2), now()])->count() > 0;
    }

    public function changeState(int $state_id)
    {
        $this->update(['state_id' => $state_id]);
        VehicleStateHistory::create([
            'vehicle_id' => $this->id,
            'state_id' => $state_id,
            'user_id' => Auth::user()->id
        ]);
    }

    public function next()
    {
        $ids = Vehicle::active()->orderBy('plate')->get()->pluck('id');

        $index = $ids->search($this->id) + 1;

        if ($ids->has($index)) {
            return Vehicle::find($ids->get($index));
        }

        return $this;
    }

    public function prev()
    {
        $ids = Vehicle::active()->orderBy('plate')->get()->pluck('id');

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
                ->whereIn('manufacturer_id', $makers)
                ->whereIn('model_id', $models)
                ->get();
    }

    public function incrementCanHours(float $read)
    {
        $this->increment('can_hours', $read);
        $this->counters->where('type', 'hours')->each(function ($counter) use ($read) {
            $counter->increment('current', $read);
        });
    }

    public function incrementWorkHours(float $read)
    {
        $this->increment('work_hours', $read);
        $this->counters->where('type', 'hours')->each(function ($counter) use ($read) {
            $counter->increment('current', $read);
        });
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


    public static function filter(array $filters)
    {
        $query = Vehicle::query();

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->where('plate', 'LIKE', "%{$filters['plate']}%");
        }
        if (isset($filters['chassis_maker_id']) && $filters['chassis_maker_id'] != null) {
            $query->where('chassis_maker_id', $filters['chassis_maker_id'])
                ->orWhereHas('equipments', function ($q) use ($filters) {
                    $q->where('maker_id', $filters['chassis_maker_id']);
                });
        }
        if (isset($filters['chassis_model_id']) && $filters['chassis_model_id'] != null) {
            $query->where('chassis_model_id', $filters['chassis_model_id'])
                ->orWhereHas('equipments', function ($q) use ($filters) {
                    $q->where('model_id', $filters['chassis_model_id']);
                });
        }
        if (isset($filters['state_id']) && $filters['state_id'] != null) {
            $query->where('state_id', $filters['state_id']);
        }
        if (isset($filters['assigned_customer_id']) && $filters['assigned_customer_id'] != null) {
            $query->where('assigned_customer_id', $filters['assigned_customer_id']);
        }
        
        return $query;
    }
}
