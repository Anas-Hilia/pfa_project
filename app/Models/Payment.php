<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Payment';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     *      */
    protected $guarded = [
        'id_payment',
    ];
    protected $primaryKey = 'id_payment';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'id_S',
        's1_amount',
        's1_receipt',
        's1_date',
        'status_s1',
        's2_amount',
        's2_receipt',
        's2_date',
        'status_s2',
        's3_amount',
        's3_receipt',
        's3_date',
        'status_s3',
        's4_amount',
        's4_receipt',
        's4_date',
        'status_s4',

    ];

    protected $casts = [
        


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





