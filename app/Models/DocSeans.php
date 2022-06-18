<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $seans_id
 * @property integer $job_id
 * @property boolean $flag
 * @property integer $track_id
 * @property string $sort
 * @property integer $duration
 */
class DocSeans extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'seans_id';

    /**
     * @var array
     */
    protected $fillable = ['job_id', 'flag', 'track_id', 'sort', 'duration'];
}
