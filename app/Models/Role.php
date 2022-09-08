<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    const TITLE_ADMIN = 'Admin';
    const TITLE_PATIENT = 'Patient';
    const TITLE_DOCTOR = 'Doctor';

    public $table = 'roles';

    public $orderable = [
        'id',
        'title',
    ];

    public $filterable = [
        'id',
        'title',
        'permissions.title',
    ];

    protected $fillable = [
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @param string $title
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function byTitle(string $title)
    {
        return self::query()->where('title', $title)->first();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
