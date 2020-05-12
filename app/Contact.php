<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $dates = ['birth_date'];


    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::parse($value);
    }

    /**
     * Get the user's birth date.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthDateAttribute($value)
    {
        return  Carbon::parse($value);
    }


    public function user ()
    {
        return $this->belongsTo(User::class);
    }

}
