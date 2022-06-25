<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $track_id
 * @property string $track_name
 * @property string $track_url
 * @property integer $part_id
 * @property integer $duration
 */
class DocTrack extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_track';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'track_id';

    /**
     * @var array
     */
    protected $fillable = ['track_name', 'track_url', 'part_id', 'duration'];

    public function getTrackName(): string
    {
        return $this->track_name;
    }

    public function getTrackUrl(): string
    {
        return $this->track_url;
    }

    public function getTrackId(): string
    {
        return $this->track_id;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
