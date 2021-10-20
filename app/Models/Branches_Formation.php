<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Branches_Formation extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'branches_formations';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id_BrF',
    ];
    protected $primaryKey = 'id_BrF';


    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'coordinateur',
        'description',
        'id_formation',
        'c_accepted',
        'u_accepted',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected $casts = [
        'name'        => 'string',
        'coordinateur' => 'string',
        'id_formation' => 'integer',
        'description' => 'string',
        'c_accepted' => 'boolean',
        'u_accepted' => 'boolean',
        
    ];

    public function formation()
    {
        return $this->belongsTo(\App\Models\Formation::class);
    }
    public function profile()
    {
        return $this->belongsTo(\App\Models\Profile::class);
    }

}
