<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskForPatient extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public $table = 'task_for_patients';

    public $filterable = [
        'id',
        'pacient.name',
        'cost.price',
        'mode.name',
    ];

    public $orderable = [
        'id',
        'pacient.name',
        'cost.price',
        'mode.name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'pacient_id',
        'cost_id',
        'mode_id',
        'status',
    ];

    public function pacient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function cost()
    {
        return $this->belongsTo(Cost::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mod::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
