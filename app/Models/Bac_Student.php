<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bac_Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bac_student';
    

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id_BacS',
    ];
    protected $primaryKey = 'id_BacS';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'id_student',
        'serie',
        'academy',
        'establishment_1',
        'bac_year',
        

    ];

    protected $casts = [
        'serie'          => 'string',
        'academy'        => 'string',
        'establishment_1'=> 'string',
        'bac_year'       => 'integer',
        
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
