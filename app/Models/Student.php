<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     *      */
    protected $guarded = [
        'id_S',
    ];
    protected $primaryKey = 'id_S';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_branche_formation',
        'CNE',
        'CIN',
        'date_birth',
        'place_birth',
        'validate',
        'tranche_1',
        'tranche_2',
        'amount_tr1',
        'amount_tr2',
        'status_tr1',
        'status_tr2',

    ];

    protected $casts = [
        'id_user' => 'integer',
        'id_branche_formation' => 'integer',
        'CNE' => 'integer',
        'CIN' => 'integer',
        'date_birth' => 'datetime:Y-m-d',
        'place_birth' => 'string',
        'validate' => 'boolean',
        'tranche_1' => 'string',
        'tranche_2' => 'string',
        'amount_tr1' => 'double',
        'amount_tr2' => 'double',
        'status_tr1'=> 'boolean',
        'status_tr2'=> 'boolean',


    ];

    /**
     * A profile belongs to a user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Profile Theme Relationships.
     *
     * @var array
     */
    public function theme()
    {
        return $this->hasOne(\App\Models\Theme::class);
    }
}





