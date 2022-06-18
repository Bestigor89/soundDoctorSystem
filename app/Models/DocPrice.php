<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $price_id
 * @property string $dt
 * @property integer $sum
 */
class DocPrice extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'doc_price';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'price_id';

    /**
     * @var array
     */
    protected $fillable = ['dt', 'sum'];
}
