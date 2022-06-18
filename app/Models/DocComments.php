<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $comm_id
 * @property integer $user_id
 * @property integer $del_flag
 * @property string $dt
 * @property string $comm
 * @property string $answ
 * @property DocUser $docUser
 */
class DocComments extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'comm_id';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'del_flag', 'dt', 'comm', 'answ'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docUser()
    {
        return $this->belongsTo('App\Models\DocUser', 'user_id', 'user_id');
    }
}
