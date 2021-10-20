<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diploma_Student extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'diploma_student';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id_DiplS',
    ];
    protected $primaryKey = 'id_DiplS';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'id_student',
        'diploma',
        'date_obtained',
        'establishment_2',

    ];

    protected $casts = [
        'diploma'=> 'string',
        'date_obtained '=> 'datetime:Y-m-d',
        'establishment_2'=> 'string',
        
        
    ];

    /**
     * A profile belongs to a user.
     *
     * @return mixed
     */
    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
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
