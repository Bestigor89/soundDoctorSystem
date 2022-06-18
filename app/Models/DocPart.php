<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $part_id
 * @property string $part_name
 */
class DocPart extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'doc_part';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'part_id';

    /**
     * @var array
     */
    protected $fillable = ['part_name'];
}
