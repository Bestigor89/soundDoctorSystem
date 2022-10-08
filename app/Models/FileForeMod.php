<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileForeMod extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public $table = 'file_fore_mods';

    public $orderable = [
        'id',
        'file.name',
        'file.durations',
        'sort_order',
        'mod.name',
    ];

    public $filterable = [
        'id',
        'file.name',
        'file.durations',
        'sort_order',
        'mod.name',
    ];

    protected $fillable = [
        'file_id',
        'sort_order',
        'mod_id',
        'durations',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function file()
    {
        return $this->belongsTo(FileLibrary::class);
    }

    public function mod()
    {
        return $this->belongsTo(Mod::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
