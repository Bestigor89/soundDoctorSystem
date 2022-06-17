<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mod extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public $table = 'mods';

    public $orderable = [
        'id',
        'name',
        'section.name',
    ];

    public $filterable = [
        'id',
        'name',
        'section.name',
        'sound_file.name',
    ];

    protected $fillable = [
        'name',
        'section_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function soundFile()
    {
        return $this->belongsToMany(FileLibrary::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
