<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FileLibrary extends Model implements HasMedia
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;
    use InteractsWithMedia;

    public $table = 'file_libraries';

    public $orderable = [
        'id',
        'name',
        'durations',
    ];

    public $filterable = [
        'id',
        'name',
        'durations',
    ];

    protected $appends = [
        'sound_file',
    ];

    protected $fillable = [
        'name',
        'durations',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getSoundFileAttribute()
    {
        return $this->getMedia('file_library_sound_file')->map(function ($item) {
            $media = $item->toArray();
            $media['url'] = $item->getUrl();

            return $media;
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getSection()
    {
        return $this->belongsToMany(Section::class); // todo добавить поля для связи
    }
}
