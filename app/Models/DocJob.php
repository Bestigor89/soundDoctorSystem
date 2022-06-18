<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $job_id
 * @property integer $user_id
 * @property string $dt
 * @property boolean $flag
 * @property DocUser $docUser
 */
class DocJob extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'doc_job';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'job_id';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'dt', 'flag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docUser()
    {
        return $this->belongsTo('App\Models\DocUser', 'user_id', 'user_id');
    }
}
