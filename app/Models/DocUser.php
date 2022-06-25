<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $email
 * @property integer $user_id
 * @property string $login
 * @property integer $user_type
 * @property string $user_pwd
 * @property string $user_lang
 * @property string $user_pic_link
 * @property boolean $active
 * @property string $info
 * @property string $about
 * @property integer $param
 * @property string $fio
 * @property string $dob
 * @property integer $owner
 * @property string $tel
 * @property string $reset_pwd_key
 * @property string $updated_pwd_dt
 * @property DocComment[] $docComments
 * @property DocJob[] $docJobs
 */
class DocUser extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $orderable = [
        'user_id', 'login', 'user_type', 'user_pwd', 'user_lang', 'user_pic_link', 'active', 'info', 'about', 'param', 'fio', 'dob', 'owner', 'tel', 'reset_pwd_key', 'updated_pwd_dt'
    ];

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'login', 'user_type', 'user_pwd', 'user_lang', 'user_pic_link', 'active', 'info', 'about', 'param', 'fio', 'dob', 'owner', 'tel', 'reset_pwd_key', 'updated_pwd_dt'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'id', 'doc_user_id');
    }

    /**
     * @return HasMany
     */
    public function docComments()
    {
        return $this->hasMany('App\Models\DocComment', 'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function docJobs()
    {
        return $this->hasMany('App\Models\DocJob', 'user_id', 'user_id');
    }

    public function getPhone(): string
    {
        return $this->tel ?? '';
    }

    public function getBirthdayDate(): string
    {
        return $this->dob ?? '';
    }
}
