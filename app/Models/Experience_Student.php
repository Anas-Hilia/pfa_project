<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience_Student extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'experience_student';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id_ExpS',
    ];
    protected $primaryKey = 'id_ExpS';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        
        'id_student',
        'employer_organization',
        'poste_occupied',
        

    ];

    protected $casts = [
        'employer_organization' => 'string',
        'poste_occupied' => 'string', 
        'theme_id' => 'integer',
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
