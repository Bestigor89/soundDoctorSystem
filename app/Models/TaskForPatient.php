<?php

namespace App\Models;

use App\Models\Scopes\TaskForPatient\WithoutHidden;
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
        'date_start' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'date_start',
    ];

    protected $fillable = [
        'pacient_id',
        'cost_id',
        'mode_id',
        'status',
        'date_start',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new WithoutHidden);
    }

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
