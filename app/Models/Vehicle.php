<?php

namespace App\Models;

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
use App\Models\VehicleTracking;
use App\Models\VehicleType;
use App\Models\VehicleWorkCounter;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Vehicle extends EloquentModel
{
    protected $appends = ['chassis'];

    protected $fillable = [
        'assigned_customer_id',
        'plate',
        'registration_date',
        'purchase_date',
        'kms',
        'work_hours',
        'can_hours',
        'warranty_date',
        'vin',
        'discharged_at',
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
        'webfleet_id'
    ];

    public function setPlateAttribute($value)
    {
        $this->attributes['plate'] = strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $value));
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'assigned_customer_id');
    }

    public function customerHistory()
    {
        return $this->hasMany(VehicleCustomerHistory::class)->latest();
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
        return $this->belongsToMany(File::class, 'vehicle_pictures');
    }

    public function counters()
    {
        return $this->hasMany(VehicleWorkCounter::class);
    }

    public function getChassisAttribute()
    {
        return optional($this->chassisMaker)->name . ' ' . optional($this->chassisModel)->name;
    }

    public function isMoving()
    {
        return $this->tracking()->whereBetween('fired_at', [now()->subHours(2), now()])->count() > 0;
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


    public static function filters($query)
    {
        $filters = [];

        if (isset($query['plate']) && $query['plate'] != null) {
            $filters[] = ['plate', 'LIKE', "%{$query['plate']}%"];
        }

        if (isset($query['chassis_maker_id']) && $query['chassis_maker_id'] != null) {
            $filters[] = ['chassis_maker_id', $query['chassis_maker_id']];
        }

        if (isset($query['chassis_model_id']) && $query['chassis_model_id'] != null) {
            $filters[] = ['chassis_model_id', $query['chassis_model_id']];
        }

        if (isset($query['assigned_customer_id']) && $query['assigned_customer_id'] != null) {
            $filters[] = ['assigned_customer_id', $query['assigned_customer_id']];
        }
        
        return $filters;
    }
}
