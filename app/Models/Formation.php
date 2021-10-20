<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formation extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'formations';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'description',
        'nbr_max',
        'created_by',
        'updated_by',
        'deleted_by',
        'c_accepted',
        'u_accepted',

    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'name'        => 'string'  ,
        'type'        => 'string'  ,
        'description' => 'string'  ,
        'nbr_max'     => 'integer' ,
        'created_by'  => 'integer' ,
        'updated_by'  => 'integer' ,
        'deleted_by'  => 'integer' ,
        'c_accepted'  => 'boolean' ,
        'u_accepted'  => 'boolean' ,
    ];

    

    
}





