<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public $table = 'costs';

    public $filterable = [
        'id',
        'price',
    ];

    public $orderable = [
        'id',
        'price',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'price',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getActive()
    {
        return self::query()->where('status', true)
            ->first();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
